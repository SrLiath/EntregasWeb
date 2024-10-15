<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LocalidadesSeeder extends Seeder
{
    public function run()
    {
        // Caminhos dos arquivos SQL
        $files = [
            'estados' => database_path('data/estados.sql'),
            'cidades' => database_path('data/cidades.sql'),
            'bairros' => database_path('data/bairros.sql'),
        ];

        foreach ($files as $name => $filePath) {
            // Verifica se o arquivo existe
            if (File::exists($filePath)) {
                // Lê o conteúdo do arquivo
                $sql = File::get($filePath);

                // Executa os comandos SQL
                DB::unprepared($sql);
                
                echo "Dados inseridos na tabela: $name" . PHP_EOL;
            } else {
                // Mensagem caso o arquivo não exista
                echo "O arquivo $filePath não foi encontrado." . PHP_EOL;
            }
        }
    }
}
