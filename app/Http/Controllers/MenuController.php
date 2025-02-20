<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('outlet_id', auth()->id())->get();
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $foto = $request->file('foto');
        $fotoPath = $foto->store('menu', 'public');

        Menu::create([
            'outlet_id' => auth()->id(),
            'nama' => $request->nama,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        if ($menu->outlet_id !== auth()->id()) {
            abort(403);
        }
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($menu->outlet_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            // Upload foto baru
            $foto = $request->file('foto');
            $data['foto'] = $foto->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->outlet_id !== auth()->id()) {
            abort(403);
        }

        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }
        
        $menu->delete();

        return redirect()->route('menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }

    public function updateStok(Request $request, Menu $menu)
    {
        if ($menu->outlet_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $menu->update([
            'stok' => $request->stok
        ]);

        return redirect()->route('menu.index')
            ->with('success', 'Stok berhasil diperbarui');
    }
} 