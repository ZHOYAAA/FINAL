<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data lama
        echo "Menghapus data lama...\n";
        
        // Urutan truncate yang benar (dari child ke parent)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('carts')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('sliders')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Membuat role admin
        $adminRole = Role::create(['name' => 'admin']);

        // Membuat user admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123')
        ]);
        $admin->assignRole('admin');

        // Membuat categories
        $categories = [
            [
                'title' => 'Laptop Gaming',
                'description' => 'Koleksi laptop gaming terbaik'
            ],
            [
                'title' => 'Fashion Pria',
                'description' => 'Koleksi fashion pria terkini'
            ],
            [
                'title' => 'Makanan & Minuman',
                'description' => 'Aneka makanan dan minuman'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Membuat products
        $products = [
            [
                'title' => 'ROG Strix G15',
                'description' => 'Laptop gaming dengan performa tinggi',
                'price' => 15000000,
                'image' => 'https://images.pexels.com/photos/18105/pexels-photo.jpg',
                'category_id' => 1
            ],
            [
                'title' => 'Kemeja Pria Casual',
                'description' => 'Kemeja casual nyaman dipakai',
                'price' => 250000,
                'image' => 'https://images.pexels.com/photos/297933/pexels-photo-297933.jpeg',
                'category_id' => 2
            ],
            [
                'title' => 'Snack Box Premium',
                'description' => 'Kumpulan snack berkualitas',
                'price' => 100000,
                'image' => 'https://images.pexels.com/photos/1027811/pexels-photo-1027811.jpeg',
                'category_id' => 3
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Membuat sliders
        $sliders = [
            [
                'title' => 'Promo Laptop Gaming',
                'subtitle' => 'Diskon hingga 20%',
                'image' => 'https://images.pexels.com/photos/777001/pexels-photo-777001.jpeg'
            ],
            [
                'title' => 'Fashion Pria Terbaru',
                'subtitle' => 'Koleksi 2024',
                'image' => 'https://images.pexels.com/photos/845434/pexels-photo-845434.jpeg'
            ],
            [
                'title' => 'Snack Box Spesial',
                'subtitle' => 'Untuk Acara Spesialmu',
                'image' => 'https://images.pexels.com/photos/1099680/pexels-photo-1099680.jpeg'
            ]
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
