<?php

namespace Database\Seeders\Auth;

use App\Enum\Authorization\DefaultRolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**'name' => [
                    'en' => 'Company test',
                    'ar' => 'شركة 1 '
                ],
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DefaultRolesEnum::getLocalConstants() as $roleEnum) {
            Role::updateOrCreate(
                ['key' => $roleEnum],
                [
                    'key' => $roleEnum,
                    'name' => json_encode([
                       'en' =>trans('permission.roles.' . $roleEnum, [], 'en'),
                        'ar' =>trans('permission.roles.' . $roleEnum, [], 'ar')
                    ]),
                    'is_default' => true,
                    'guard_name' => 'api'
                ]
            );
        }
    }
}
