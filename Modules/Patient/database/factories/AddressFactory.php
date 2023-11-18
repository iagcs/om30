<?php

namespace Modules\Patient\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Patient\app\Models\Address::class;


    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cep' => $this->faker->numerify('########'),
            'address' => $this->faker->address,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->numerify,
            'neighbour' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->countryCode,
        ];
    }
}

