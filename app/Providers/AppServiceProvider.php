<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        HeadingRowFormatter::extend('custom', static function ($value, $key) {
            return match (\Str::squish(strtolower($value))) {
                'nome'               => 'full_name',
                'nome da mãe'        => 'mothers_full_name',
                'data de nascimento' => 'date_of_birth',
                'cpf'                => 'cpf',
                'cns'                => 'cns',
                'foto'              => 'image',
                default              => \Str::squish(strtolower($value)),
            };
        });
    }
}
