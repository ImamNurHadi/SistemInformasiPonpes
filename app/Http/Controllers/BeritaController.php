<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::orderBy('tanggal', 'desc')->paginate(10);
        return view('berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ringkasan' => 'required|string',
            'konten' => 'required|string',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('img/news'), $imageName);

        Berita::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'image' => 'img/news/'.$imageName,
            'ringkasan' => $request->ringkasan,
            'konten' => $request->konten,
            'slug' => Str::slug($request->judul)
        ]);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ringkasan' => 'required|string',
            'konten' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (File::exists(public_path($berita->image))) {
                File::delete(public_path($berita->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('img/news'), $imageName);
            $berita->image = 'img/news/'.$imageName;
        }

        $berita->judul = $request->judul;
        $berita->tanggal = $request->tanggal;
        $berita->ringkasan = $request->ringkasan;
        $berita->konten = $request->konten;
        $berita->slug = Str::slug($request->judul);
        $berita->save();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        // Hapus gambar terkait
        if (File::exists(public_path($berita->image))) {
            File::delete(public_path($berita->image));
        }
        
        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Display berita for public view.
     */
    public function detail(string $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        
        return view('berita.detail', compact('berita'));
    }
} 