<?php

namespace App\Http\Controllers;

use App\Models\MasterKompleks;
use Illuminate\Http\Request;

class MasterKompleksController extends Controller
{
    public function index()
    {
        $kompleks = MasterKompleks::with('kamar')->get();
        return view('master-kompleks.index', compact('kompleks'));
    }

    public function create()
    {
        return view('master-kompleks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kompleks' => 'required|string|max:255|unique:master_kompleks',
        ]);

        MasterKompleks::create($request->all());

        return redirect()->route('master-kompleks.index')
            ->with('success', 'Data kompleks berhasil ditambahkan');
    }

    public function edit(MasterKompleks $masterKompleks)
    {
        return view('master-kompleks.edit', compact('masterKompleks'));
    }

    public function update(Request $request, MasterKompleks $masterKompleks)
    {
        $request->validate([
            'nama_kompleks' => 'required|string|max:255|unique:master_kompleks,nama_kompleks,' . $masterKompleks->id,
        ]);

        $masterKompleks->update($request->all());

        return redirect()->route('master-kompleks.index')
            ->with('success', 'Data kompleks berhasil diperbarui');
    }

    public function destroy(MasterKompleks $masterKompleks)
    {
        $masterKompleks->delete();

        return redirect()->route('master-kompleks.index')
            ->with('success', 'Data kompleks berhasil dihapus');
    }
} 