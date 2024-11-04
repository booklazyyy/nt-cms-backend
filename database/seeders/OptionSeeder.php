<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OptionModel;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OptionModel::create([
            'option_name' => 'site_title',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'tagline',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'site_icon',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'site_address',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'admin_email',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'membership',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'newuser_default_role',
            'option_value' => NULL,
        ]);
        OptionModel::create([
            'option_name' => 'site_language',
            'option_value' => NULL,
        ]);
    }
}
