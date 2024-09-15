<?php

namespace core\Modules\Customer\Create\Rules;

use app\services\FileUploadService;
use yii\web\UploadedFile;

class FileUploadRule
{
    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function apply(?UploadedFile $imageFile): ?string
    {
        if ($imageFile) {
            return $this->fileUploadService->upload($imageFile, 'customers/');
        }

        return null;
    }
}
