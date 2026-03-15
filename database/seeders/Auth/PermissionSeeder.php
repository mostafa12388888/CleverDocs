<?php

namespace Database\Seeders\Auth;

use App\Enum\Authorization\PermissionEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PermissionEnum::getLocalConstants() as $key)
            Permission::updateOrCreate( ['name' => $key],['name' => $key, 'guard_name' => 'api']);
    }
}
