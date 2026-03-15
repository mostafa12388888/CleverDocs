<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Form\{CustomOptionsListSeeder, InputTypeTableSeeder, TemplateFormTableSeeder,TemplateInputTableSeeder};
use Database\Seeders\Auth\{RoleSeeder, AdminSeeder, CompanyTableSeed, ContentTableSeed, PermissionSeeder};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,

            CustomOptionsListSeeder::class,
           InputTypeTableSeeder::class,


       ]);
    }
}
