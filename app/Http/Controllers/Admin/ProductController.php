<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['shop', 'category', 'primaryImage'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'integer', 'min:1'],
            'condition' => ['nullable', 'in:new,used'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated) {
            $defaultShop = Shop::first();
            $shopId = $defaultShop ? $defaultShop->id : 1;

            $slug = Str::slug($validated['name']);
            $count = Product::where('slug', 'like', "{$slug}%")->count();
            if ($count > 0) {
                $slug = "{$slug}-" . ($count + 1);
            }

            $sku = 'PRD-' . strtoupper(Str::random(6));

            $product = Product::create([
                'shop_id' => $shopId,
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'sku' => $sku,
                'description' => $validated['description'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'stock' => $validated['stock'],
                'weight' => $validated['weight'] ?? 500,
                'condition' => $validated['condition'] ?? 'new',
                'is_active' => true,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk baru berhasil ditambahkan oleh Admin.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $product->load(['category', 'images']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['nullable', 'integer', 'min:1'],
            'condition' => ['nullable', 'in:new,used'],
            'is_active' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        DB::transaction(function () use ($product, $request, $validated) {
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'stock' => $validated['stock'],
                'weight' => $validated['weight'] ?? $product->weight,
                'condition' => $validated['condition'] ?? $product->condition,
                'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : $product->is_active,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $product->images()->count() === 0,
                        'sort_order' => $product->images()->count(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.products.index')->with('success', "Informasi produk {$product->name} berhasil diperbarui.");
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan (take down)';

        return back()->with('success', "Status produk {$product->name} berhasil {$status}.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
            $product->delete();
        });

        return back()->with('success', 'Produk berhasil dihapus secara permanen dari sistem.');
    }
}
