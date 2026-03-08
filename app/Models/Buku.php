<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model {
  use HasFactory; 
 
    protected $table = 'bukus'; 
    protected $primaryKey = 'id'; 
    protected $fillable = [ 
        'judul', 'penulis', 'penerbit', 'tahun_terbit',  
        'isbn', 'jumlah_halaman', 'kategori', 'stok',  
        'sinopsis', 'sampul' 
    ]; 
 
    public function peminjaman() 
    { 
        return $this->hasMany(Peminjaman::class, 'id_buku'); 
    } 
 
    public function scopeTersedia($query) 
    { 
        return $query->where('stok', '>', 0); 
    } 
 
    public function getStatusStokAttribute() 
    { 
        if ($this->stok > 0) { 
            return '<span class="badge bg-success">Tersedia</span>'; 
        } 
        return '<span class="badge bg-danger">Habis</span>'; 
    } 
    
    }
