<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test@example.com'),
        ]);

        DB::table('kategori')->insert([
            'nama_kategori'=> 'Nasional'
        ]);

        DB::table('berita')->insert([
            'judul_berita'=> 'Lorem Ipsum',
            'isi_berita'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc',
            'gambar_berita' => 'lorem.jpg',
            'id_kategori' => 1
        ]);

        DB::table('page')->insert([
            'judul_page'=> 'Lorem Ipsum',
            'isi_page'=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc',
            'status_page' => 1
        ]);
    }
}
