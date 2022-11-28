<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Fee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Fee::create([
            'name' => 'basic',
            'type' => 'percent',
            'value' => 10,
            'min' => 10,
            'max' => 50
        ]);
        Fee::create([
            'name' => 'special',
            'type' => 'percent',
            'value' => 2,
        ]);
        Fee::create([
            'name' => 'association',
            'type' => 'assoc',
            'value' => 5,
            'min' => 1,
            'max' => 500
        ]);
        Fee::create([
            'name' => 'association',
            'type' => 'assoc',
            'value' => 10,
            'min' => 501,
            'max' => 1000
        ]);
        Fee::create([
            'name' => 'association',
            'type' => 'assoc',
            'value' => 15,
            'min' => 1001,
            'max' => 3000
        ]);
        Fee::create([
            'name' => 'association',
            'type' => 'assoc',
            'value' => 20,
            'min' => 3001
        ]);
        Fee::create([
            'name' => 'storage',
            'type' => 'fixed',
            'value' => 100
        ]);
    }
}
