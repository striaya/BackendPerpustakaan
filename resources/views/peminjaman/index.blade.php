@extends('layouts.app')

@section('title', 'Data Peminjaman')
@section('page-title', 'Data Peminjaman')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-journal-bookmark"></i> Daftar Peminjaman</h5>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Peminjaman
            </a>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($peminjaman->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-2">Belum ada data peminjaman.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th>Judul Buku</th>
                                <th>Nama Anggota</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjaman as $index => $item)
                                <tr>
                                    <td>{{ $peminjaman->firstItem() + $index }}</td>
                                    <td>{{ $item->buku->judul ?? '-' }}</td>
                                    <td>{{ $item->anggota->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}
                                        @if (!$item->tanggal_kembali && \Carbon\Carbon::now()->gt($item->tanggal_jatuh_tempo))
                                            <span class="badge bg-danger ms-1">Terlambat</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tanggal_kembali)
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @elseif (\Carbon\Carbon::now()->gt($item->tanggal_jatuh_tempo))
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if (!$item->tanggal_kembali)
                                            <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $peminjaman->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection