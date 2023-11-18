<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Bus\PendingBatch;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Modules\Patient\app\Models\Patient;
use Modules\Patient\app\Resources\PatientResource;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_patient_success(): void
    {
        $patient = Patient::factory()->make([
            'date_of_birth' => fake()->date('d-m-Y')
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSuccessful()
            ->assertJson(PatientResource::make(Patient::query()->firstWhere('cpf', $patient->cpf))->response()->getData(TRUE));

        $this->assertDatabaseHas('patients', $patient->toArray());
    }

    public function test_create_patient_fails(): void
    {
        $patient = Patient::factory()->make([
            'full_name' => ''
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['full_name' => 'The full name field is required.']);

        $patient = Patient::factory()->make([
            'full_name' => 12
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['full_name' => 'The full name field must be a string.']);

        $patient = Patient::factory()->make([
            'mothers_full_name' => ''
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['mothers_full_name' => 'The mothers full name field is required.']);

        $patient = Patient::factory()->make([
            'mothers_full_name' => 12
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['mothers_full_name' => 'The mothers full name field must be a string.']);

        $patient = Patient::factory()->make([
            'date_of_birth' => ''
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['date_of_birth' => 'The date of birth field is required.']);

        $patient = Patient::factory()->make([
            'date_of_birth' => '2023/2/3'
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['date_of_birth' => 'The date of birth field must match the format d-m-Y.']);

        $patient = Patient::factory()->make([
            'cpf' => ''
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cpf' => 'The cpf field is required.']);

        $patient = Patient::factory()->make([
            'cpf' => 12
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cpf' => 'The cpf field must be a string.']);

        $patient = Patient::factory()->make([
            'cpf' => '123321'
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cpf' => 'O campo cpf não é um CPF válido.']);

        $patient = Patient::factory()->make([
            'cns' => ''
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cns' => 'The cns field is required.']);

        $patient = Patient::factory()->make([
            'cns' => 12
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cns' => 'The cns field must be a string.']);

        $patient = Patient::factory()->make([
            'cns' => '123321'
        ]);

        $this->post('patient', $patient->toArray())
            ->assertSessionHasErrors(['cns' => 'O campo cns não é um CNS válido.']);
    }

    public function test_update_patient_success(): void
    {
        $patient = Patient::factory()->create();

        $newDateOfBirth = [
            'date_of_birth' => fake()->date('d-m-Y')
        ];

        $this->put('/patient/'. $patient->id, $newDateOfBirth)
            ->assertSuccessful()
            ->assertJson(PatientResource::make(Patient::query()->firstWhere('cpf', $patient->cpf))->response()->getData(TRUE));

        $this->assertDatabaseCount('patients', 1);
        $this->assertDatabaseHas('patients', [
            'date_of_birth' => $newDateOfBirth['date_of_birth']
        ]);
        $this->assertDatabaseMissing('patients', [
            'date_of_birth' => $patient->date_of_birth
        ]);
    }

    public function test_import_patients_in_mass(): void
    {
        Bus::fake();

        Storage::fake('local');

        Storage::disk('local')->put('import.csv', $this->makeFakeContentForFile());

        $path = Storage::disk('local')->path('import.csv');

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->post('patient/import/', [
            'patients' => new UploadedFile($path, 'patients.csv', NULL, NULL, TRUE),
        ])->assertSuccessful();

        Bus::assertBatched(function (PendingBatch $batch) {
            return $batch->name === 'Patients data validation.';
        });

        $this->assertDatabaseCount('failed_jobs', 0);

    }

    private function makeFakeContentForFile(): string
    {
        $content = "Nome,Nome da Mãe,Data de Nascimento,CPF,CNS,Foto\n";

        for ($i = 0; $i < 10; $i++) {
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

    public function test_patient_shown_success(): void
    {
        $patient = Patient::factory()->create();

        $this->get('/patient/'. $patient->id)
            ->assertSuccessful()
            ->assertJson(PatientResource::make(Patient::query()->firstWhere('cpf', $patient->cpf))->response()->getData(TRUE));
    }

    public function test_patient_shown_fails(): void
    {
        $this->get('/patient/'. fake()->uuid)
            ->assertNotFound();
    }

    public function test_patient_delete_success(): void
    {
        $patient = Patient::factory()->create();

        $this->delete('/patient/'. $patient->id)
            ->assertSuccessful();

        $this->assertDatabaseCount('patients', 0);
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }

    public function test_patient_delete_fails(): void
    {
        $this->delete('/patient/'. fake()->uuid)
            ->assertNotFound();
    }
}
