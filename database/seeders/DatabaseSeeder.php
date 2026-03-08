<?php

namespace Database\Seeders;

use App\Models\Buku; 
use App\Models\Anggota; 
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
       { 
        Buku::factory(20)->create(); 
 
        Anggota::factory(15)->create(); 
 
        Peminjaman::factory(10)->create(); 
 
        $peminjamanAktif = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->get(); 
        foreach ($peminjamanAktif as $pinjam) { 
            $buku = Buku::find($pinjam->id_buku); 
            if ($buku) { 
                $buku->stok -= 1; 
                $buku->save(); 
            } 
        } 
    } 
}
