<?php

namespace Database\Seeders\Auth;

use App\Enum\Authorization\DefaultRolesEnum;
use App\Models\CompanyAbout\Company;
use App\Models\CompanyAbout\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = 'admin@gmail.com';
            $company = Company::updateOrCreate(["email"=>$adminEmail],[
                'name' => [
                    'en' => 'Company test',
                    'ar' => 'شركة 1 '
                ],
                'address' => json_encode([
                    'en' => 'address',
                    'ar' => 'عنوان'
                ]),
                'phone1' => '123456789',
                'phone2' => '234567891',
                'tax_percentage' => 12,
                'vat_percentage' => 1,
                'email' => 'admin@gmail.com',
                'registration' => 123,
                'tax' => 0,
                "is_hide"=>1,
                'vat' => 0,
                'company_filed' => 1,
                'logo' => null

            ]);


        $contact = Contact::where(['contact_email' => $adminEmail])->first();

        if (!$contact) {
            $contact = Contact::updateOrCreate(["contact_email"=>$adminEmail],[
                'address' => json_encode([
                    'en' => 'address',
                    'ar' => 'عنوان'
                ]),
                'name' => json_encode([
                    'en' => ['first' => 'Admin', 'second' => 'second', 'third' => 'third'],
                    'ar' => ['first' => 'مدير', 'second' => 'second', 'third' => 'third']
                ]),
                'phone1' => '123456789',
                'phone2' => '234567891',
                'is_key_contact' => 1,
                'position' =>json_encode( [
                    'en' => 'Admin',
                    'ar' => 'مدير'
                ]),
                'company_id' => $company->id,
                'contact_email' => $adminEmail,
                'image' => null,
            ]);
        }



        $role = Role::where('key', DefaultRolesEnum::SUPER_ADMIN)->first(); 
        $Permission = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($Permission);

        $user = User::where(['email' => $adminEmail])->first();
        if (!$user) {
            $user = User::updateOrCreate(["email"=>$adminEmail],[
                'email' => $adminEmail,
                'password' => Hash::make('1234567'),
                'code' => 1234567,
                'is_active' => 1,
                'role_id' => $role->id,
                'contact_id' => $contact->id,
                "contact_name"=>$contact->name,
                "is_default"=>1,
                "is_hide"=>1,
            ]);
        }

        $user->assignRole($role);
    }
}
