<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'first_name'=>'Admin',
            'last_name'=>'User',
            'email'=>'admin@code-brew.com', 
            'password'=>Hash::make('password'),
            'account_status'=>config('constants.account_status.ACTIVE'),
            'is_super'=>1,
            'phone_code'=>'91',
            'phone_number'=>'9646367199'
        ]);
    }
}