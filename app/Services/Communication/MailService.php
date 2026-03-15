<?php

namespace App\Services\Communication;

use App\Http\Filters\Filter;
use App\Mail\ManualUserMail;
use App\Repository\Communication\MailRepository;
use App\Repository\MainRepository;
use App\Services\CompanyAbout\ContactService;
use App\Services\MainService;
use Illuminate\Support\Facades\Mail;

class MailService extends MainService
{

    /**
     * @var MailRepository
     */

    protected MainRepository $repository;
    /**
     * @param MailRepository $repository
     */

    public function __construct(MailRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    public function index(int $page, int $perPage, ?string $type, ?Filter $filter = null): mixed
    {
        return  $this->repository->index($page, $perPage, $type, $filter);
    }

    /**
     * sendManualMail
     *
     * @param  mixed $data
     * @param  mixed $type
     * @param  mixed $typeName
     * @return void
     */
    public function sendManualMail(array $data, string $type = '', ?string $typeName = ''): void
    {
        $contactService = app(ContactService::class);

        $toContactEmail = $contactService->findAllByWhereIn('id', $data['toContactIds'])
            ->pluck('contact_email')
            ->filter();

        $ccContactEmail = $contactService->findAllByWhereIn('id', $data['ccContactIds'] ?? [])
            ->pluck('contact_email')
            ->filter();
        $contactName = (auth()->user()->contact_name['en']['first'] ?? '') . (auth()->user()->contact_name['en']['last'] ?? '') ?: config('mail.from.address');
        $typeName = $typeName ?? 'CLeverDocs';
        $bodyWithLink = str_replace(
            '[[submission-link]]',
            "<a  href=\"https://cleverdocs.netlify.app\"> $typeName </a>",
            $data['body']
        );
        $data['body'] = $bodyWithLink;
        $email = new ManualUserMail(
            $bodyWithLink,
            $data['priority'],
            auth()->user()->contact->contact_email ?? config('mail.from.name'),
            $contactName
        );
        Mail::to($toContactEmail)
            ->cc($ccContactEmail ?? [])
            ->send($email);
        $this->_storeEmail($data, $type);
    }
    /**
     * _storeEmail
     *
     * @param  mixed $dataEmails
     * @param  mixed $type
     * @return void
     */
    public function _storeEmail($dataEmails, string $type): void
    {
        $email = $this->repository->add([
            'type_id' => $dataEmails['typeId'],
            'type' => $type ?? '',
            'priority' => $dataEmails['priority'],
            'body' => json_encode($dataEmails["body"]),
            "created_by" => auth()->id()
        ]);

        $syncData = [];

        foreach ($dataEmails['toContactIds'] ?? [] as $toId)
            $syncData[$toId] = ['contact_type' => 'to'];
        $email->recipients()->attach($syncData);
        $syncData = [];
        foreach ($dataEmails['ccContactIds'] ?? [] as $ccId) {
            $syncData[$ccId] = ['contact_type' => 'cc'];
        }

        $email->recipients()->attach($syncData);
    }
}
