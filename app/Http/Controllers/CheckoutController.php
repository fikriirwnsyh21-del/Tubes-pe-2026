<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CheckoutService;
use App\Services\VoucherService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        public CheckoutService $checkoutService,
        public VoucherService $voucherService
    ) {}

    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        $cart = Cart::where('user_id', $user->id)->first();
        if (! $cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $selectedItems = CartItem::with(['product.primaryImage', 'product.shop', 'variant'])
            ->where('cart_id', $cart->id)
            ->where('is_selected', true)
            ->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Silakan pilih setidaknya 1 produk di keranjang belanja untuk checkout.');
        }

        $addresses = Address::where('user_id', $user->id)->orderByDesc('is_primary')->latest()->get();
        $primaryAddress = $addresses->firstWhere('is_primary', true) ?? $addresses->first();

        $couriers = [
            [
                'name' => 'Reguler (JNE / SiCepat / J&T - 2-3 Hari)',
                'service' => 'Reguler',
                'etd' => '2-3 Hari',
                'cost' => 15000,
            ],
            [
                'name' => 'Hemat (SiCepat HALU - 3-5 Hari)',
                'service' => 'Hemat',
                'etd' => '3-5 Hari',
                'cost' => 10000,
            ],
            [
                'name' => 'Express (JNE YES - 1 Hari)',
                'service' => 'Express',
                'etd' => '1 Hari (Besok Sampai)',
                'cost' => 25000,
            ],
        ];

        $paymentMethods = [
            [
                'category' => 'Midtrans Payment Gateway (Sandbox)',
                'badge' => 'Rekomendasi Utama',
                'methods' => [
                    [
                        'id' => 'midtrans_snap',
                        'name' => 'Midtrans Snap (Semua Pembayaran Sandbox)',
                        'code' => 'MIDTRANS',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Pop-up otomatis Midtrans Snap: QRIS, GoPay, ShopeePay, Virtual Account (BCA, Mandiri, BNI, BRI, Permata), dan Kartu Kredit.',
                        'badge' => 'Paling Lengkap',
                        'icon' => 'Midtrans',
                    ],
                ],
            ],
            [
                'category' => 'Channel Spesifik Midtrans Sandbox',
                'badge' => 'Verifikasi Otomatis',
                'methods' => [
                    [
                        'id' => 'qris',
                        'name' => 'QRIS Sandbox (Midtrans)',
                        'code' => 'QRIS',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Scan otomatis via GoPay, OVO, DANA, ShopeePay, BCA Mobile, Livin, BRImo, dll.',
                        'badge' => 'Scan & Bayar',
                        'icon' => 'QRIS',
                    ],
                    [
                        'id' => 'gopay',
                        'name' => 'GoPay Sandbox (Midtrans)',
                        'code' => 'GOPAY',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Pembayaran instan langsung dari saldo GoPay uji coba Midtrans.',
                        'badge' => 'E-Wallet',
                        'icon' => 'GoPay',
                    ],
                    [
                        'id' => 'bca_va',
                        'name' => 'BCA Virtual Account (Midtrans)',
                        'code' => 'BCA_VA',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Transfer virtual account BCA verifikasi instan 24 jam.',
                        'badge' => 'Bank Transfer',
                        'icon' => 'BCA',
                    ],
                    [
                        'id' => 'mandiri_va',
                        'name' => 'Mandiri Virtual Account (Midtrans)',
                        'code' => 'MANDIRI_VA',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Transfer virtual account Bank Mandiri verifikasi instan 24 jam.',
                        'badge' => 'Bank Transfer',
                        'icon' => 'Mandiri',
                    ],
                    [
                        'id' => 'bri_va',
                        'name' => 'BRI Virtual Account (Midtrans)',
                        'code' => 'BRI_VA',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Transfer BRIVA verifikasi otomatis via ATM atau BRImo.',
                        'badge' => 'Bank Transfer',
                        'icon' => 'BRI',
                    ],
                    [
                        'id' => 'bni_va',
                        'name' => 'BNI Virtual Account (Midtrans)',
                        'code' => 'BNI_VA',
                        'type' => 'gateway',
                        'fee' => 0,
                        'desc' => 'Transfer virtual account BNI verifikasi otomatis via BNI Mobile.',
                        'badge' => 'Bank Transfer',
                        'icon' => 'BNI',
                    ],
                ],
            ],
            [
                'category' => 'Pembayaran Tunai',
                'badge' => 'Bayar di Tempat',
                'methods' => [
                    [
                        'id' => 'cod',
                        'name' => 'Bayar di Tempat (COD)',
                        'code' => 'COD',
                        'type' => 'cod',
                        'fee' => 0,
                        'desc' => 'Bayar tunai langsung kepada kurir saat paket pesanan sampai di alamat Anda.',
                        'badge' => 'Tunai',
                        'icon' => 'COD',
                    ],
                ],
            ],
        ];

        return view('checkout.index', compact(
            'cart',
            'selectedItems',
            'addresses',
            'primaryAddress',
            'couriers',
            'paymentMethods'
        ));
    }

    public function checkVoucher(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
            'subtotal' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $res = $this->voucherService->validateAndApply(
                $request->string('code'),
                (float) $request->input('subtotal'),
                $request->user()->id
            );

            return response()->json([
                'success' => true,
                'message' => "Voucher '{$res['voucher']->name}' berhasil diterapkan!",
                'discount' => $res['discount_amount'],
                'voucherCode' => $res['voucher']->code,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function process(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->checkoutService->processCheckout($request->user(), $request->validated());

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
