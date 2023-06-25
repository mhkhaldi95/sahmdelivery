<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Constants\Enum;
use App\Models\Constant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'sahm',
            'email' => 'sahm@gmail.com',
            'username' => 'sahm',
            'role' => Enum::SUPER_ADMIN,
            'password' => Hash::make('123456'),
        ]);
        $constant = [
            ['key'=> 'ratio' , 'value'=>0.14],
            ['key'=> 'fix_amount' , 'value'=>2],
            ['key'=> 'closed_amount' , 'value'=>5],
        ];

        foreach ($constant as $row) {
            Constant::query()->create($row);
        }
    }
}
