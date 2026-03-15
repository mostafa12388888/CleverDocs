<?php

namespace App\Exports\CompanyAbout;

use App\Exports\BaseExport;

class PrivateInboxExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($inbox) {
            $contact = $inbox->user?->contact;

            return [
                'From Contact Name (EN)' => $contact?->name ? (json_decode($contact->name, true)['en'] ?? '') : '',
                'From Contact Name (AR)' => $contact?->name ? (json_decode($contact->name, true)['ar'] ?? '') : '',
                'From Contact Email' => $contact?->contact_email ?? '',
                'From Contact Phone 1' => $contact?->phone1 ?? '',
                'From Contact Position (EN)' => $contact?->position ? (json_decode($contact->position, true)['en'] ?? '') : '',
                'From Contact Position (AR)' => $contact?->position ? (json_decode($contact->position, true)['ar'] ?? '') : '',
                'Message' => $inbox->message,
                'Type' => $inbox->type,
                'Status' => $inbox->status,
                'Created At' => $inbox->created_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'private-inbox.xlsx');
    }
}
