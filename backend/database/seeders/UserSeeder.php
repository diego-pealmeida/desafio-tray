<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')
            ->updateOrInsert(
                [ 'email' => 'teste@exemplo.com.br' ],
                [
                    'name' => 'Administrador Teste',
                    'password' => bcrypt('Mudar@123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
    }
}
