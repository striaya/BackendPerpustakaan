<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua request yang terautentikasi
    }
    public function rules(): array
    {
        $rules = [
            'judul' => 'required|min:3|max:255',
            'penulis' => 'required|min:3|max:255',
            'penerbit' => 'required|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'required|integer|min:1',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
        // Unique ISBN, kecuali untuk update
        if ($this->isMethod('POST')) {
            $rules['isbn'] = 'required|unique:bukus,isbn|max:20';
        } else {
            $rules['isbn'] = [
                'required',
                'max:20',
                Rule::unique('bukus', 'isbn')->ignore($this->route('buku'))
            ];
        }
        return $rules;
    }
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku harus diisi',
            'judul.min' => 'Judul minimal 3 karakter',
            'penulis.required' => 'Penulis harus diisi',
            'isbn.required' => 'ISBN harus diisi',
            'isbn.unique' => 'ISBN sudah terdaftar',
            'sampul.image' => 'File harus berupa gambar',
            'sampul.max' => 'Ukuran gambar maksimal 2MB'
        ];
    }
}
