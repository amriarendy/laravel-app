<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Amria Rendy',
            'email' => 'admin@admin.com',
            'password' => 'admin@admin.com',
            'picture' => 'github-mark-white.svg',
        ]);

        DB::table('master_categories')->insert([
            [
                'category' => 'News',
                'slug' => 'news',
                'created_at' => Carbon::now()
            ],
            [
                'category' => 'Technology',
                'slug' => 'technology',
                'created_at' => Carbon::now()
            ],
            [
                'category' => 'Design',
                'slug' => 'design',
                'created_at' => Carbon::now()
            ],
            [
                'category' => 'Business',
                'slug' => 'business',
                'created_at' => Carbon::now()
            ],
            [
                'category' => 'Politics',
                'slug' => 'politics',
                'created_at' => Carbon::now()
            ]
        ]);

        DB::table('metas')->insert([
            [
                'title' => 'Amria Fondation - Free Blog and Company Profile',
                'description' => 'Amria Fondation is a pioneering Free Blog and Company Profile company dedicated to driving innovation and shaping the future. With a focus on creativity, collaboration, and impact, we specialize in delivering cutting-edge freelance apps/services that exceed expectations. Join us on our journey as we unlock new possibilities and make a positive impact on the world.',
                'favicon' => 'favicon.ico',
                'keywords' => 'amriarendy, github, blog website, company profile, landingpage, starter project',
                'author' => 'amriarendy',
                'image' => 'image.png',
                'copyright' => 'amriarendy',
                'robots' => 'index, follow',
                'googlebot' => 'index, follow',
                'googlebotnews' => 'index, follow',
                'sitename' => 'https://github.com/amriarendy',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
