<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insere um usuário admin
        DB::table('users')->insert([
            'name' => 'Admin', // Nome do usuário
            'email' => 'admin@diskentregas.com', // Email do usuário
            'password' => Hash::make('T5r4e3!t5r4e3!@#'), // Senha segura usando hash
            'email_verified_at' => now(), // Data de verificação do email
            'remember_token' => Str::random(10), // Token de 'lembrar de mim'
            'created_at' => now(), // Data de criação
            'updated_at' => now(), // Data de atualização
        ]);
    }
}
