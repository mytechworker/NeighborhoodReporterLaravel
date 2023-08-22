<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Communitie;
use App\UserCommunitie;

class AdminUserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'provider_id'=>1,
            'password' => bcrypt('sparkle1#'),
            'type' => 'Superadmin',
            'phone' => '971-223-0232',
            'website' => 'www.abhiitsinhpiludaria.com',
            'timezone' => '2',
            'bio' => 'Test new admin seeder',
            'profile_image' => 'am_1.jpg',
            'region_id' => '1',
        ]);
        $explode = explode(",",$user->region_id);
        $communitie = Communitie::where('region_id',$explode[0])->first();
        $user_community = UserCommunitie::create([
            'user_id' => $user->id,
            'communitie_id' => $communitie['id'],
            'default'=>1,
        ]);
    }

}
