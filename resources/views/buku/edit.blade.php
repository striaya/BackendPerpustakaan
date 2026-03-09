@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

@section('content')

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('judul') is-invalid @enderror"
                           id="judul"
                           name="judul"
                           value="{{ old('judul', $buku->judul) }}"
                           required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="penulis" class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('penulis') is-invalid @enderror"
                               id="penulis"
                               name="penulis"
                               value="{{ old('penulis', $buku->penulis) }}"
                               required>
                        @error('penulis')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="penerbit" class="form-label">Penerbit <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('penerbit') is-invalid @enderror"
                               id="penerbit"
                               name="penerbit"
                               value="{{ old('penerbit', $buku->penerbit) }}"
                               required>
                        @error('penerbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number"
                               class="form-control @error('tahun_terbit') is-invalid @enderror"
                               id="tahun_terbit"
                               name="tahun_terbit"
                               value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                               min="1900"
                               max="{{ date('Y') }}"
                               required>
                        @error('tahun_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text"
                               class="form-control @error('isbn') is-invalid @enderror"
                               id="isbn"
                               name="isbn"
                               value="{{ old('isbn', $buku->isbn) }}"
                               required>
                        @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                        <input type="number"
                               class="form-control @error('jumlah_halaman') is-invalid @enderror"
                               id="jumlah_halaman"
                               name="jumlah_halaman"
                               value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}"
                               min="1"
                               required>
                        @error('jumlah_halaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror"
                                id="kategori"
                                name="kategori"
                                required>

                            <option value="Novel" {{ old('kategori',$buku->kategori)=='Novel'?'selected':'' }}>Novel</option>
                            <option value="Komik" {{ old('kategori',$buku->kategori)=='Komik'?'selected':'' }}>Komik</option>
                            <option value="Pelajaran" {{ old('kategori',$buku->kategori)=='Pelajaran'?'selected':'' }}>Pelajaran</option>
                            <option value="Ilmiah" {{ old('kategori',$buku->kategori)=='Ilmiah'?'selected':'' }}>Ilmiah</option>
                            <option value="Biografi" {{ old('kategori',$buku->kategori)=='Biografi'?'selected':'' }}>Biografi</option>
                            <option value="Sejarah" {{ old('kategori',$buku->kategori)=='Sejarah'?'selected':'' }}>Sejarah</option>
                            <option value="Agama" {{ old('kategori',$buku->kategori)=='Agama'?'selected':'' }}>Agama</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number"
                               class="form-control @error('stok') is-invalid @enderror"
                               id="stok"
                               name="stok"
                               value="{{ old('stok', $buku->stok) }}"
                               min="0"
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sinopsis" class="form-label">Sinopsis</label>
                    <textarea class="form-control"
                              id="sinopsis"
                              name="sinopsis"
                              rows="5">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="sampul" class="form-label">Sampul Buku</label>
                    <input type="file"
                           class="form-control"
                           id="sampul"
                           name="sampul"
                           accept="image/*">

                    <small class="text-muted">Kosongkan jika tidak ingin mengganti sampul</small>

                    @if($buku->sampul)
                    <div class="mt-2">
                        <img src="{{ asset('storage/'.$buku->sampul) }}" style="max-height:200px;">
                    </div>
                    @endif
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary me-md-2">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update Buku
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

</div>
@endsection
