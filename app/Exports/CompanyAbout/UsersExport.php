<?php

namespace App\Exports\CompanyAbout;

use App\Exports\BaseExport;
use Illuminate\Support\Collection;

class UsersExport extends BaseExport
{

    /**
     * __construct
     *
     * @param  mixed $collection
     * @param  mixed $fileName
     * @return void
     */
    public function __construct($collection, string $fileName = null)
    {
        $mapped = collect($collection)->map(function ($user) {
            return [
                'Email' => $user->email,
                'Code' => $user->code,
                'Is Active' => $user->is_active ? 'Yes' : 'No',
                'Company (EN)' => $user->company_name ? (json_decode($user->company_name, true)['en'] ?? '') : '',
                'Company (AR)' => $user->company_name ? (json_decode($user->company_name, true)['ar'] ?? '') : '',
                'Contact (EN)' => $user->contact_name ? (json_decode($user->contact_name, true)['en'] ?? '') : '',
                'Contact (AR)' => $user->contact_name ? (json_decode($user->contact_name, true)['ar'] ?? '') : '',
                'Contact Position (EN)' => $user->contact_position ? (json_decode($user->contact_position, true)['en'] ?? '') : '',
                'Contact Position (AR)' => $user->contact_position ? (json_decode($user->contact_position, true)['ar'] ?? '') : '',
                'Role (EN)' => $user->role_name ? (json_decode($user->role_name, true)['en'] ?? '') : '',
                'Role (AR)' => $user->role_name ? (json_decode($user->role_name, true)['ar'] ?? '') : '',
                'Created At' => $user->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $user->updated_at?->format('Y-m-d H:i:s'),
                'Created By' => $user->created_by_id ? json_decode($user?->created_by_contact_name) : '',
                'Updated By' => $user->updated_by_id ? json_decode($user?->created_by_contact_name) : '',

            ];
        });

        parent::__construct($mapped, $fileName ?? 'users.xlsx');
    }
}
