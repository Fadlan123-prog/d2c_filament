<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sizes;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = new Sizes;
        $data->size = 'S';
        $data->save();

        $data = new Sizes;
        $data->size = 'M';
        $data->save();

        $data = new Sizes;
        $data->size = 'L';
        $data->save();

        $data = new Sizes;
        $data->size = 'XL';
        $data->save();

        $data = new Sizes;
        $data->size = 'S/M';
        $data->save();

        $data = new Sizes;
        $data->size = 'L/XL';
        $data->save();

        $data = new Sizes;
        $data->size = 'VAC';
        $data->save();

        $data = new Sizes;
        $data->size = 'NV';
        $data->save();

        $data = new Sizes;
        $data->size = 'Front All Size';
        $data->save();

        $data = new Sizes;
        $data->size = 'Full All Size';
        $data->save();

        $data = new Sizes;
        $data->size = 'Full Coating';
        $data->save();

        $data = new Sizes;
        $data->size = 'Clean Wash';
        $data->save();
    }
}
