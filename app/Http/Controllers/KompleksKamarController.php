<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\MasterKompleks;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KompleksKamarController extends Controller
{
    public function index()
    {
        $kompleks = MasterKompleks::with('kamar')->get();
        $kamar = Kamar::with('kompleks')->get();
        return view('kompleks-kamar.index', compact('kompleks', 'kamar'));
    }

    public function storeKompleks(Request $request)
    {
        $request->validate([
            'nama_kompleks' => 'required|string|max:255|unique:master_kompleks',
        ]);

        MasterKompleks::create($request->all());

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kompleks berhasil ditambahkan');
    }

    public function storeKamar(Request $request)
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

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil ditambahkan');
    }

    public function destroyKompleks($id)
    {
        $kompleks = MasterKompleks::findOrFail($id);
        $kompleks->delete();

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kompleks berhasil dihapus');
    }

    public function destroyKamar($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return redirect()->route('kompleks-kamar.index')
            ->with('success', 'Data kamar berhasil dihapus');
    }
} 