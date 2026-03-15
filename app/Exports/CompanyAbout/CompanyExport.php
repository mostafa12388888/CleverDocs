<?php

namespace App\Exports\CompanyAbout;

use App\Exports\BaseExport;

class CompanyExport extends BaseExport
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
        $mapped = collect($collection)->map(function ($company) {
            $keyContact = $company->keyContact->first();
            return [
                'Name (EN)' => $company->name['en'] ?? '',
                'Name (AR)' => $company->name['ar'] ?? '',
                'Field' => $company->field?->title ?? '',
                'Field ID' => $company->field?->id ?? '',
                'Email' => $company->email,
                'Phone 1' => $company->phone1,
                'Phone 2' => $company->phone2,
                'Address (EN)' => $company->address ? (json_decode($company->address, true)['en'] ?? '') : '',
                'Address (AR)' => $company->address ? (json_decode($company->address, true)['ar'] ?? '') : '',
                'Tax No' => $company->tax,
                'Tax %' => $company->tax_percentage,
                'VAT No' => $company->vat,
                'VAT %' => $company->vat_percentage,
                'Registration No' => $company->registration,
                'Key Contact Name (EN)' => $keyContact?->name['en'] ?? '',
                'Key Contact Name (AR)' => $keyContact?->name['ar'] ?? '',
                'Key Contact Phone' => $keyContact?->phone ?? '',
                'Created By' => $company->createdBy?->name ?? '',
                'Updated By' => $company->updatedBy?->name ?? '',
                'Created At' => $company->created_at?->format('Y-m-d H:i:s'),
                'Updated At' => $company->updated_at?->format('Y-m-d H:i:s'),
            ];
        });

        parent::__construct($mapped, $fileName ?? 'companies.xlsx');
    }
}
