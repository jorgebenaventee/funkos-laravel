<?php

namespace Database\Seeders;

use App\Models\Funko;
use Illuminate\Database\Seeder;

class FunkoSeeder extends Seeder
{
    public function run(): void
    {
        Funko::factory(10)->create();
    }
}
