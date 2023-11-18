<?php

namespace Modules\Patient\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Patient\app\Models\Address;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Patient\app\Models\Patient::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'full_name'         => $this->faker->name,
            'mothers_full_name' => $this->faker->name('female'),
            'date_of_birth'     => $this->faker->date('d-m-Y'),
            'cpf'               => $this->faker->cpf,
            'cns'               => '276206093770002',
            'image'             => $this->faker->filePath()
        ];
    }
}

