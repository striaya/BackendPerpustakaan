<?php

namespace Database\Factories;

use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        $kategori = ['Novel', 'Komik', 'Pelajaran', 'Ilmiah', 'Biografi', 'Sejarah', 'Agama']; 
         
        return [ 
            'judul' => fake()->sentence(3), 
            'penulis' => fake()->name(), 
            'penerbit' => fake()->company(), 
            'tahun_terbit' => fake()->year(), 
            'isbn' => fake()->unique()->isbn13(), 
            'jumlah_halaman' => fake()->numberBetween(50, 1000), 
            'kategori' => fake()->randomElement($kategori), 
            'stok' => fake()->numberBetween(0, 10), 
            'sinopsis' => fake()->paragraphs(3, true), 
            'sampul' => null, 
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'), 
            'updated_at' => now(), 
        ]; 
    } 
}

