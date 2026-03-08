<?php

namespace Database\Factories;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    protected $model = Anggota::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $kelas = ['X RPL 1', 'X RPL 2', 'XI RPL 1', 'XI RPL 2', 'XII RPL 1', 'XII RPL 2']; 
         
        return [ 
            'nis' => fake()->unique()->numerify('##########'), 
            'nama_lengkap' => fake()->name(), 
            'kelas' => fake()->randomElement($kelas), 
            'jenis_kelamin' => fake()->randomElement(['L', 'P']), 
            'alamat' => fake()->address(), 
            'no_telepon' => fake()->phoneNumber(), 
            'email' => fake()->unique()->safeEmail(), 
            'tanggal_daftar' => fake()->dateTimeBetween('-6 months', 'now'), 
            'status_aktif' => fake()->boolean(80),  
            'created_at' => now(), 
            'updated_at' => now(), 
        ]; 
    } 
}
