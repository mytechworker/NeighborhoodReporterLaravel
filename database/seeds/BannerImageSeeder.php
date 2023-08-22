<?php

use App\BannerImage;
use Illuminate\Database\Seeder;

class BannerImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BannerImage::truncate();

        $bannerimages =  [
            [
              'page_name' => 'FaqCategory',
              'page_slug' => 'faqCategory',
              'image' => 'patch_hero_992.jpg',
            ],
            [
              'page_name' => 'Home',
              'page_slug' => 'home',
              'image' => 'patch_hero_992.jpg',
            ],
            
          ];

          BannerImage::insert($bannerimages);
    }
}
