<?php

use App\Page;
use Illuminate\Database\Seeder;

class FooterPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::truncate();

        $pages =  [
            [
              'title' => 'About',
              'slug' => 'About',
              'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">About</h1>',
            ],
            [
                'title' => 'Community Guidelines',
                'slug' => 'community-guidelines',
                'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">Community Guidelines</h1>',
            ],
            [
                'title' => 'Posting Instructions',
                'slug' => 'posting-instructions',
                'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">Posting Instructions</h1>',
            ],
            [
                'title' => 'Terms of Use',
                'slug' => 'terms',
                'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">Terms of Use</h1>',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">Privacy Policy</h1>',
            ],
             [
                'title' => 'Contact',
                'slug' => 'contact-us',
                'content' => '<h1 class="st_About__Header" style="box-sizing: border-box; margin: 12px 0px; line-height: 1.2; font-size: 32px; color: #111111; font-family: Merriweather, Georgia, Times, serif; background-color: #ebedef;">Contact</h1>',
            ],
          ];

          Page::insert($pages);
    }
}
