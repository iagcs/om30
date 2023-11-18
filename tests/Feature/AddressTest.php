<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Patient\app\Models\Address;
use Modules\Patient\app\Models\Patient;
use Modules\Patient\app\Resources\AddressResource;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_search_address_by_cep_success(): void
    {
        $response = $this->post('/address/search-by-cep',[
            'cep' => '31260100'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            "cep" => "31260-100",
            "address" => "Rua Ana Vaz de Melo",
            "complement" => "",
            "neighbour" => "Dona Clara",
            "city" => "Belo Horizonte",
            "state" => "MG"
        ]);
    }

    public function test_search_address_by_cep_fails(): void
    {
        $this->post('/address/search-by-cep',[
            'cep' => fake()->randomNumber(3)
        ])->assertSessionHasErrors(['cep' => 'The cep field must be between 8 and 8 characters.'])->assertStatus(302);

        $this->post('/address/search-by-cep',[
            'cep' => 'asdasssd'
        ])->assertSessionHasErrors(['cep' => 'O CEP deve conter apenas números'])->assertStatus(302);
    }

    public function test_create_address_success(): void
    {
        $patient = Patient::factory()->create();
        $address = Address::factory()->make();

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSuccessful()
            ->assertJson(AddressResource::make(Address::query()->firstWhere('patient_id', $patient->id))->response()->getData(TRUE));

        $this->assertDatabaseCount('addresses', 1);
        $this->assertDatabaseHas('addresses', $address->toArray());
    }

    public function test_create_address_fails(): void
    {
        $patient = Patient::factory()->create();

        $address = Address::factory()->make([
            'cep' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'cep' => 'The cep field is required.'
            ]);

        $address = Address::factory()->make([
            'cep' => 'fake()->$this->randomNumber()3'
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'cep' => 'The cep field must be between 8 and 8 characters.'
            ]);

        $address = Address::factory()->make([
            'cep' => 'asdasdas'
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'cep' => 'O cep deve conter apenas números.'
            ]);

        $address = Address::factory()->make([
            'address' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'address' => 'The address field is required.'
            ]);

        $address = Address::factory()->make([
            'address' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'address' => 'The address field must be a string.'
            ]);

        $address = Address::factory()->make([
            'number' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'number' => 'The number field is required.'
            ]);

        $address = Address::factory()->make([
            'number' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'number' => 'The number field must be a string.'
            ]);

        $address = Address::factory()->make([
            'number' => 'asdas'
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'number' => 'O number deve conter apenas números.'
            ]);

        $address = Address::factory()->make([
            'complement' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'complement' => 'The complement field is required.'
            ]);

        $address = Address::factory()->make([
            'complement' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'complement' => 'The complement field must be a string.'
            ]);

        $address = Address::factory()->make([
            'neighbour' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'neighbour' => 'The neighbour field is required.'
            ]);

        $address = Address::factory()->make([
            'neighbour' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'neighbour' => 'The neighbour field must be a string.'
            ]);

        $address = Address::factory()->make([
            'city' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'city' => 'The city field is required.'
            ]);

        $address = Address::factory()->make([
            'city' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'city' => 'The city field must be a string.'
            ]);

        $address = Address::factory()->make([
            'state' => ''
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'state' => 'The state field is required.'
            ]);

        $address = Address::factory()->make([
            'state' => fake()->randomNumber()
        ]);

        $this->post('/address/store/'. $patient->id, $address->toArray())
            ->assertSessionHasErrors([
                'state' => 'The state field must be a string.'
            ]);
    }

    public function test_update_address_success(): void
    {
        $patient = Patient::factory()->create();
        $address = Address::factory()->for($patient)->create();

        $newStreet = [
            'address' => fake()->streetAddress
        ];

        $this->put('address/'. $address->id, $newStreet)
        ->assertSuccessful()
        ->assertJson(AddressResource::make(Address::query()->firstWhere('patient_id', $patient->id))->response()->getData(TRUE));

        $this->assertDatabaseCount('addresses', 1);
        $this->assertDatabaseMissing('addresses', [
            'address' => $address->address
        ]);
        $this->assertDatabaseHas('addresses', [
            'address' => $newStreet['address']
        ]);
    }

    public function test_update_address_fails()
    {
        $newStreet = [
            'address' => fake()->streetAddress
        ];

        $this->put('address/'. fake()->uuid, $newStreet)
            ->assertNotFound();
    }

    public function test_address_shown_success()
    {
        $address = Address::factory()->forPatient()->create();

        $this->get('/address/'. $address->id)
        ->assertSuccessful()
        ->assertJson(AddressResource::make(Address::query()->find($address->id))->response()->getData(TRUE));
    }

    public function test_address_shown_fails()
    {
        $this->get('/address/'. fake()->uuid)
            ->assertNotFound();
    }

    public function test_address_delete_success()
    {
        $address = Address::factory()->forPatient()->create();

        $this->delete('/address/'. $address->id)
            ->assertSuccessful();

        $this->assertDatabaseCount('addresses', 0);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_address_delete_fails()
    {
        $this->delete('/address/'. fake()->uuid)
            ->assertNotFound();
    }
}

