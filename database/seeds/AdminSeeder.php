<?php

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Admin();
        $user->insert([
            [
//                'display_name'  => 'Administrator',
                'is_online'     => 0,
                'email'         => 'admin@admin.com',
                'password'      => bcrypt('12345678'),
                'is_super'          => '0',
                'last_access'   => Carbon::now(),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],

            [
                'is_online'     => 0,
                'email'         => 'superadmin@superadmin.com',
                'password'      => bcrypt('12345678'),
                'is_super'          => '1',
                'last_access'   => Carbon::now(),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ]);
    }
}
