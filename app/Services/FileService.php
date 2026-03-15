<?php
namespace App\Services;

use App\Helpers\FileHelper;
use App\Repository\FileRepository;
use App\Repository\MainRepository;
use App\Units\FileUnit;
use Throwable;


class FileService extends MainService
{
    /**
     * @var FileRepository
     */
    protected MainRepository $repository;

    /**
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        parent::__construct($repository);
    }



    /**
     * @param mixed $data
     * @return mixed
     * @throws Throwable
     */
    public function handleUpload(array $data): mixed
    {
        list($uploadResults, $successCount, $failedCount) = $this->_filesUploads($data['files']);

        $results = $this->applyTransaction(function () use ($uploadResults) {

            $results = [];
            foreach ($uploadResults as $fileData) {

               if(($fileData['success'] ?? false)){
                   $results[] =  $this->add($fileData['unit']->toArray());
                } else {
                   $results[] =   (object)[ 'failedReason' => $fileData['failedReason'] ?? null ];
                }
            }

            return $results;
        });

        return (object)[
            'results' => $results,
            'successCount' => $successCount,
            'failedCount' => $failedCount
        ];
    }

    /**
     * @param $files
     * @return array
     */
    private function _filesUploads($files): array
    {
        $failedCount = 0;
        $results = [];
        $successCount = 0;

        foreach ($files as $file) {
            $filePath = FileHelper::uploadFile($file, 'public/uploads');
            if (!$filePath) {
                $failedCount++;
                $results[] = [
                    'success' => false,
                    'fileInfo' => json_encode($file),
                    'failedReason' => 'Failed to upload file.'
                ];
                continue;
            }

            $successCount++;
            $results[] = [
                'success' => true,
                'filePath' => $filePath,
                'fileInfo' => json_encode($file),
                'unit' => $this->_fileUnit($file, $filePath)
            ];
        }

        return array($results, $successCount, $failedCount);
    }


    /**
     * @param mixed $file
     * @param $filePath
     * @return FileUnit
     */
    private function _fileUnit(mixed $file, $filePath): FileUnit
    {
        return new FileUnit(
            $file,
            $filePath
        );

    }


}
