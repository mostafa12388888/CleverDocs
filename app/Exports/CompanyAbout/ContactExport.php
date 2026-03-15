<?php

namespace App\Exports\CompanyAbout;

use App\Exports\BaseExport;

class ContactExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($contact) {
            return [
                'Name (EN)' => $contact->name ? (json_decode($contact->name, true)['en'] ?? '') : '',
                'Name (AR)' => $contact->name ? (json_decode($contact->name, true)['ar'] ?? '') : '',
                'Position (EN)' => $contact->position ? (json_decode($contact->position, true)['en'] ?? '') : '',
                'Position (AR)' => $contact->position ? (json_decode($contact->position, true)['ar'] ?? '') : '',
                'Email' => $contact->contact_email,
                'Address (EN)' => $contact->address ? (json_decode($contact->address, true)['en'] ?? '') : '',
                'Address (AR)' => $contact->address ? (json_decode($contact->address, true)['ar'] ?? '') : '',
                'Phone 1' => $contact->phone1,
                'Phone 2' => $contact->phone2,
                'User Name' => $contact->user?->name ?? '',
                'User Email' => $contact->user?->email ?? '',
                'Is Key Contact' => $contact->is_key_contact ? 'Yes' : 'No',
                'Created By' => $contact->createdBy?->name ?? '',
                'Updated By' => $contact->updatedBy?->name ?? '',
                'Created At' => $contact->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $contact->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'contacts.xlsx');
    }
}
