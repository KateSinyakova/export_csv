<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Генерируем пользователей пакетами по 5000 для экономии памяти
        $batchSize = 5000;
        $total = 500000;
        for ($i = 0; $i < $total / $batchSize; $i++) {
            User::factory($batchSize)->create();
        }
    }
} 