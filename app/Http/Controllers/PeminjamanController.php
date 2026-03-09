<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['buku', 'anggota']);
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $peminjaman = $query->latest()->paginate(20);
        return view('peminjaman.index', compact('peminjaman'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buku = Buku::tersedia()->get();
        $anggota = Anggota::aktif()->get();
        return view('peminjaman.create', compact('buku', 'anggota'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id',
            'id_anggota' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_pinjam',
        ]);
        $buku = Buku::find($request->id_buku);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia!');
        }
        $buku->stok -= 1;
        $buku->save();
        Peminjaman::create([
            'id_buku' => $request->id_buku,
            'id_anggota' => $request->id_anggota,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status' => 'dipinjam'
        ]);
        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }
    /**
     * Fungsi khusus untuk pengembalian buku
     */
    public function kembali(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status == 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya!');
        }
        $request->validate([
            'tanggal_kembali' => 'required|date'
        ]);
        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);
        $denda = 0;
        $status = 'dikembalikan';
        if ($tanggalKembali > $jatuhTempo) {
            $hariTerlambat = $tanggalKembali->diffInDays($jatuhTempo);
            $denda = $hariTerlambat * 1000;
            $status = 'terlambat';
        }
        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali,
            'status' => $status,
            'denda' => $denda
        ]);
        $buku = Buku::find($peminjaman->id_buku);
        $buku->stok += 1;
        $buku->save();
        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengembalian berhasil diproses. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }
    /**
     * Laporan peminjaman aktif
     */
    public function laporan()
    {
        $totalBuku = Buku::count();
        $totalAnggotaAktif = Anggota::aktif()->count();
        $bukuDipinjam = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $bukuTerlambat = Peminjaman::where('status', 'terlambat')->count();
        $peminjamanAktif = Peminjaman::with(['buku', 'anggota'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->get();
        return view('peminjaman.laporan', compact(
            'totalBuku',
            'totalAnggotaAktif',
            'bukuDipinjam',
            'bukuTerlambat',
            'peminjamanAktif'
        ));
    }

    public function show($id)
{
    $peminjaman = Peminjaman::with(['buku', 'anggota'])->findOrFail($id);
    return view('peminjaman.show', compact('peminjaman'));
}
}
