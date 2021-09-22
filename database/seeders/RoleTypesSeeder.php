<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleTypes;

class RoleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Admin','User'];

        foreach($items as $item) {
            RoleTypes::firstOrCreate(['name' => $item]);
        }
    }
}
