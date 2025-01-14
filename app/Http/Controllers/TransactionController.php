<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false; // Pastikan false untuk sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function checkout()
    {
        try {
            // Ambil cart items user yang sedang login
            $cartItems = Cart::with('product')
                ->where('user_id', auth()->id())
                ->get();

            if($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
            }

            // Hitung total harga
            $totalPrice = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Validasi total harga
            if ($totalPrice <= 0) {
                return redirect()->route('cart.index')->with('error', 'Total harga tidak valid');
            }

            // Buat transaksi baru
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'order_id' => 'TRX-' . Str::random(10)
            ]);

            // Simpan detail transaksi
            foreach($cartItems as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Set up parameter Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => (int) $transaction->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ]
            ];

            // Log parameter yang dikirim ke Midtrans
            \Log::info('Midtrans Request:', [
                'server_key' => substr(Config::$serverKey, 0, 4) . '...' . substr(Config::$serverKey, -4),
                'params' => $params
            ]);

            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // Update transaksi dengan snap token
            $transaction->update([
                'snap_token' => $snapToken
            ]);

            // Hapus cart items
            Cart::where('user_id', auth()->id())->delete();

            // Load relationship yang dibutuhkan
            $transaction = Transaction::with(['transactionDetails.product'])->find($transaction->id);

            // Ambil data yang dibutuhkan untuk layout
            $appname = config('app.name');
            $menu = \App\Models\Page::where(['is_group' => 0, 'is_active' => 1])->get();
            $submenu = \App\Models\Page::where(['is_group' => 1, 'is_active' => 1])->get();
            $categories = \App\Models\Category::all();

            return view('checkout', compact('transaction', 'snapToken', 'appname', 'menu', 'submenu', 'categories'));
        } catch (\Exception $e) {
            // Log error lengkap
            \Log::error('Midtrans Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Jika terjadi error, hapus transaksi yang sudah dibuat
            if (isset($transaction)) {
                $transaction->delete();
            }
            
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if($hashed == $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            
            if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update([
                    'payment_status' => 'paid'
                ]);
            } elseif($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                $transaction->update([
                    'payment_status' => 'failed'
                ]);
            } elseif($request->transaction_status == 'pending') {
                $transaction->update([
                    'payment_status' => 'pending'
                ]);
            }
        }
    }

    public function success()
    {
        // Ambil data yang dibutuhkan untuk layout
        $appname = config('app.name');
        $menu = \App\Models\Page::where(['is_group' => 0, 'is_active' => 1])->get();
        $submenu = \App\Models\Page::where(['is_group' => 1, 'is_active' => 1])->get();
        $categories = \App\Models\Category::all();

        return view('transaction.success', compact('appname', 'menu', 'submenu', 'categories'));
    }

    public function pending()
    {
        // Ambil data yang dibutuhkan untuk layout
        $appname = config('app.name');
        $menu = \App\Models\Page::where(['is_group' => 0, 'is_active' => 1])->get();
        $submenu = \App\Models\Page::where(['is_group' => 1, 'is_active' => 1])->get();
        $categories = \App\Models\Category::all();

        return view('transaction.pending', compact('appname', 'menu', 'submenu', 'categories'));
    }

    public function error()
    {
        // Ambil data yang dibutuhkan untuk layout
        $appname = config('app.name');
        $menu = \App\Models\Page::where(['is_group' => 0, 'is_active' => 1])->get();
        $submenu = \App\Models\Page::where(['is_group' => 1, 'is_active' => 1])->get();
        $categories = \App\Models\Category::all();

        return view('transaction.error', compact('appname', 'menu', 'submenu', 'categories'));
    }

    public function process(Request $request)
    {
        // Redirect ke halaman checkout
        return redirect()->route('checkout');
    }
} 