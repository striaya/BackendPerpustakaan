<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Buku::query();
        if ($request->has('cari')) {
            $query->where('judul', 'LIKE', '%' . $request->cari . '%')
                ->orWhere('penulis', 'LIKE', '%' . $request->cari . '%');
        }
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        $buku = $query->paginate(12);
        $kategoriList = Buku::distinct('kategori')->pluck('kategori');
        return view('buku.index', compact('buku', 'kategoriList'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated(); 

        $request->validate([
            'judul' => 'required|min:3|max:255',
            'penulis' => 'required|min:3|max:255',
            'penerbit' => 'required|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|unique:bukus,isbn|max:20',
            'jumlah_halaman' => 'required|integer|min:1',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $data = $request->all();
        if ($request->hasFile('sampul')) {
            $file = $request->file('sampul');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/sampul', $filename);
            $data['sampul'] = $filename;
        }
        Buku::create($data);
        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
{
    $data = $request->validate([
        'judul' => 'required|min:3|max:255',
        'penulis' => 'required|min:3|max:255',
        'penerbit' => 'required|max:255',
        'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
        'isbn' => 'required|max:20|unique:bukus,isbn,' . $buku->id,
        'jumlah_halaman' => 'required|integer|min:1',
        'kategori' => 'required',
        'stok' => 'required|integer|min:0',
        'sinopsis' => 'nullable',
        'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($request->hasFile('sampul')) {

        // hapus sampul lama
        if ($buku->sampul) {
            Storage::delete('public/sampul/' . $buku->sampul);
        }

        $file = $request->file('sampul');
        $filename = time().'_'.$file->getClientOriginalName();

        $file->storeAs('public/sampul', $filename);

        $data['sampul'] = $filename;
    }

    $buku->update($data);

    return redirect()->route('buku.index')
        ->with('success', 'Buku berhasil diperbarui!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        if ($buku->sampul) {
            Storage::delete('public/sampul/' . $buku->sampul);
        }
        $buku->delete();
        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
