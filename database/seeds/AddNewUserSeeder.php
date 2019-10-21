<?php

use Illuminate\Database\Seeder;

class AddNewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\User::where('email', 'damir@dash.ba')->count()){
            \App\Models\User::create(['name' => 'Damir', 'email' => 'damir@dash.ba', 'password' => bcrypt('password')]);
        }
        if(!\App\Models\User::where('email', 'damir.idzakovic@gmail.com')->count()){
            \App\Models\User::create(['name' => 'Damir Idzakovic', 'email' => 'damir.idzakovic@gmail.com', 'password' => bcrypt('hordezla')]);
        }
    }
}
