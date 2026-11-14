<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerOnlyMiddleware
{
    /**
     * Handle an incoming request.
     * Pastikan hanya pembeli/pelanggan yang dapat mengakses keranjang dan checkout.
     * Akun Administrator dilarang berbelanja dan akan diarahkan ke Dashboard Admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            // Bersihkan item keranjang admin jika ada tersimpan dari sesi sebelumnya
            if ($user->cart) {
                $user->cart->items()->delete();
            }

            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Administrator hanya bertugas mengelola sistem dan tidak diperbolehkan melakukan transaksi belanja. Silakan gunakan akun Pelanggan.',
                ], 403);
            }

            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun Administrator hanya bertugas mengelola sistem dan tidak diperbolehkan melakukan transaksi belanja. Silakan gunakan akun Pelanggan.');
        }

        return $next($request);
    }
}
