<?php

namespace Database\Factories;

use App\Models\Buku; 
use App\Models\Anggota; 
use App\Models\Peminjaman; 
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
       { 
        $tanggalPinjam = fake()->dateTimeBetween('-3 months', 'now'); 
        $tanggalJatuhTempo = (clone $tanggalPinjam)->modify('+7 days'); 
        $status = fake()->randomElement(['dipinjam', 'dikembalikan', 'terlambat']); 
        $tanggalKembali = null; 
        $denda = 0; 
 
        if ($status == 'dikembalikan') { 
            $tanggalKembali = fake()->dateTimeBetween($tanggalPinjam, $tanggalJatuhTempo); 
        } elseif ($status == 'terlambat') { 
            $tanggalKembali = fake()->dateTimeBetween($tanggalJatuhTempo, '+1 month'); 
            $hariTerlambat = (clone $tanggalKembali)->diff($tanggalJatuhTempo)->days; 
            $denda = $hariTerlambat * 1000; 
        } 
 
        return [ 
            'id_buku' => Buku::inRandomOrder()->first()->id, 
            'id_anggota' => Anggota::where('status_aktif', true)->inRandomOrder()->first()->id, 
            'tanggal_pinjam' => $tanggalPinjam, 
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo, 
            'tanggal_kembali' => $tanggalKembali, 
            'status' => $status, 
            'denda' => $denda, 
            'created_at' => $tanggalPinjam, 
            'updated_at' => now(), 
        ]; 
    } 
} 
