@extends('layouts.app')

@section('title', 'Tambah Peminjaman')
@section('page-title', 'Tambah Peminjaman')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-bookmark-plus"></i> Form Tambah Peminjaman</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_buku" class="form-label fw-semibold">Buku <span class="text-danger">*</span></label>
                            <select name="id_buku" id="id_buku" class="form-select @error('id_buku') is-invalid @enderror" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach ($buku as $b)
                                    <option value="{{ $b->id }}" {{ old('id_buku', request('buku')) == $b->id ? 'selected' : '' }}>
                                        {{ $b->judul }} (Stok: {{ $b->stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_buku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_anggota" class="form-label fw-semibold">Anggota <span class="text-danger">*</span></label>
                            <select name="id_anggota" id="id_anggota" class="form-select @error('id_anggota') is-invalid @enderror" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach ($anggota as $a)
                                    <option value="{{ $a->id }}" {{ old('id_anggota') == $a->id ? 'selected' : '' }}>
                                        {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_anggota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_jatuh_tempo" class="form-label fw-semibold">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                                class="form-control @error('tanggal_jatuh_tempo') is-invalid @enderror"
                                value="{{ old('tanggal_jatuh_tempo') }}" required>
                            @error('tanggal_jatuh_tempo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection