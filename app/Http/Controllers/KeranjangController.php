<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::with('menu')
            ->where('user_id', auth()->id())
            ->get();
        
        $total = $keranjang->sum('total_harga');
        
        return view('keranjang.index', compact('keranjang', 'total'));
    }

    public function addToCart(Menu $menu)
    {
        if (auth()->user()->hasRole('Outlet')) {
            abort(403, 'Outlet tidak dapat melakukan pembelian.');
        }

        $keranjang = Keranjang::where('user_id', auth()->id())
            ->where('menu_id', $menu->id)
            ->first();

        if ($keranjang) {
            if ($menu->stok > $keranjang->jumlah) {
                $keranjang->increment('jumlah');
                $keranjang->update([
                    'total_harga' => $keranjang->jumlah * $menu->harga
                ]);
            } else {
                return response()->json([
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }
        } else {
            if ($menu->stok > 0) {
                Keranjang::create([
                    'user_id' => auth()->id(),
                    'menu_id' => $menu->id,
                    'jumlah' => 1,
                    'total_harga' => $menu->harga
                ]);
            } else {
                return response()->json([
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }
        }

        return response()->json([
            'message' => 'Menu berhasil ditambahkan ke keranjang',
            'cart_count' => auth()->user()->keranjang()->count()
        ]);
    }

    public function removeFromCart(Menu $menu)
    {
        $keranjang = Keranjang::where('user_id', auth()->id())
            ->where('menu_id', $menu->id)
            ->first();

        if ($keranjang) {
            if ($keranjang->jumlah > 1) {
                $keranjang->decrement('jumlah');
                $keranjang->update([
                    'total_harga' => $keranjang->jumlah * $menu->harga
                ]);
            } else {
                $keranjang->delete();
            }
        }

        return response()->json([
            'message' => 'Menu berhasil dihapus dari keranjang',
            'cart_count' => auth()->user()->keranjang()->count()
        ]);
    }

    public function destroy(Keranjang $keranjang)
    {
        if ($keranjang->user_id !== auth()->id()) {
            abort(403);
        }

        $keranjang->delete();

        return redirect()->route('keranjang.index')
            ->with('success', 'Menu berhasil dihapus dari keranjang');
    }
} 