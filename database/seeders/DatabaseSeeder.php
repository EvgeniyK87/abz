<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Position;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->delete();
        DB::table('positions')->delete();
        
        Position::factory(42)->create();
        $positions = Position::all(); 

        User::factory(45)->create()->each(function ($user) use ($positions) {
            $user->positions()->attach(
                $positions->random(1)->pluck('id')->toArray()
            );
        });

    }
}
