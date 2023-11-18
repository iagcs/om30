<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Modules\Patient\app\Models\Address;
use Modules\Patient\app\Models\Patient;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'qweqwe123'
        ]);
        Patient::factory(10)->has(Address::factory())->create();

        Storage::disk('local')->put('import.csv', $this->generatePatientsFile());
    }

    private function generatePatientsFile(): string
    {
        $content = "Nome,Nome da Mãe,Data de Nascimento,CPF,CNS,Foto\n";

        for ($i = 0; $i < 10000; $i++) {
            $content .= fake()->name.','.
                        fake()->name('female').','.
                        fake()->date('d-m-Y').','.
                        fake()->unique()->cpf.','.
                        "276206093770002".','.
                        fake()->filePath().
                        PHP_EOL;
        }

        return $content;
    }
}
