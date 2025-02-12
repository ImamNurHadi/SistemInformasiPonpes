<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\MasterKompleks;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::with('kompleks')->get();
        return view('kamar.index', compact('kamar'));
    }

    public function create()
    {
        $kompleks = MasterKompleks::all();
        return view('kamar.create', compact('kompleks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kompleks_id' => 'required|exists:master_kompleks,id',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar')->where(function ($query) use ($request) {
                    return $query->where('kompleks_id', $request->kompleks_id);
                }),
            ],
        ]);

        Kamar::create($request->all());

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan');
    }

    public function edit(Kamar $kamar)
    {
        $kompleks = MasterKompleks::all();
        return view('kamar.edit', compact('kamar', 'kompleks'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'kompleks_id' => 'required|exists:master_kompleks,id',
            'nama_kamar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kamar')->where(function ($query) use ($request) {
                    return $query->where('kompleks_id', $request->kompleks_id);
                })->ignore($kamar->id),
            ],
        ]);

        $kamar->update($request->all());

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kamar.index')
            ->with('success', 'Data kamar berhasil dihapus');
    }

    public function getByKompleks($kompleksId)
    {
        $kamar = Kamar::where('kompleks_id', $kompleksId)->get();
        return response()->json($kamar);
    }
} 