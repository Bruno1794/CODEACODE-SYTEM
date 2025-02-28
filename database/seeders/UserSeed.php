<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        if (!User::where('username', '=', 'bruno1020')->exists()) {
            User::create([
                'name' => 'Bruno Costa',
                'username' => 'bruno1020',
                'type_user' => 'FULL',
                'password' => Hash::make("1020", ['rounds' => 12]),
            ]);
        }
    }
}
