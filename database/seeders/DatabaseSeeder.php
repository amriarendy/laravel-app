<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('admin@admin.com'),
            'picture' => 'github-mark-white.svg',
        ]);

        DB::table('master_categories')->insert([
            [
                'category' => 'News',
                'slug' => 'news',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Technology',
                'slug' => 'technology',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Design',
                'slug' => 'design',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Business',
                'slug' => 'business',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Politics',
                'slug' => 'politics',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Software Developer',
                'slug' => 'software-developer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category' => 'Music',
                'slug' => 'music',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('master_tags')->insert([
            [
                'tag' => 'laravel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tag' => 'php',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tag' => 'software developer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tag' => 'github',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'tag' => 'rest api',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('metas')->insert([
            [
                'title' => 'Amria Fondation',
                'description' => 'Amria Fondation is a pioneering Free Blog and Company Profile company dedicated to driving innovation and shaping the future. With a focus on creativity, collaboration, and impact, we specialize in delivering cutting-edge freelance apps/services that exceed expectations. Join us on our journey as we unlock new possibilities and make a positive impact on the world.',
                'favicon' => 'logomark.min.svg',
                'keywords' => 'amriarendy, github, blog website, company profile, landingpage, starter project',
                'author' => 'amriarendy',
                'image' => 'logotype.min.svg',
                'copyright' => 'amriarendy',
                'robots' => 'index, follow',
                'googlebot' => 'index, follow',
                'googlebotnews' => 'index, follow',
                'sitename' => 'https://github.com/amriarendy',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        DB::table('blogs')->insert([
            [
                'title' => 'What is Lorem Ipsum?',
                'user_id' => 1,
                'category_id' => 1,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'body' => "<p style='text-align: justify; '>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p><p style='text-align: justify; '><br></p><p style='text-align: justify; '>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of 'de Finibus Bonorum et Malorum' (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 'Lorem ipsum dolor sit amet..', comes from a line in section 1.10.32.</p><p style='text-align: center;'><img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSArto-r6sEqy9AyZUUmcY7vJRDCVG-pJDpCw&amp;s' style='width: 225px;'><br></p><p style='text-align: justify; '>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p style='text-align: center;'><img src='http://127.0.0.1:8000/uploads/posts/1717514542.jpg' style='width: 206px;'><br></p><p style='text-align: justify; '>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p style='text-align: center;'><iframe frameborder='0' src='//www.youtube.com/embed/IdxBE_yh06Q' width='640' height='360' class='note-video-clip'></iframe><br></p><p style='text-align: justify; '>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>",
                'image' => 'cover-photo.png',
                'date_post' => 'amriarendy',
                'slug' => '10-tahun-jokowi-jadi-presiden-narasi-explains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
