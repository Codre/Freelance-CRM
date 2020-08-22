<?php

namespace App\Services\TaskFiles;

use App\Models\TaskFile;
use App\Services\TaskFiles\Handlers\UploadFileHandler;
use App\Services\TaskFiles\Repositories\TaskFilesRepositoryInterface;
use Illuminate\Http\UploadedFile;

/**
 * Class TaskFilesService
 *
 * @package App\Services\TaskFiles
 */
class TaskFilesService
{

    /**
     * @var UploadFileHandler
     */
    private $uploadFileHandler;
    /**
     * @var TaskFilesRepositoryInterface
     */
    private $repository;

    /**
     * TaskFilesService constructor.
     *
     * @param TaskFilesRepositoryInterface $repository
     * @param UploadFileHandler            $uploadFileHandler
     */
    public function __construct(
        TaskFilesRepositoryInterface $repository,
        UploadFileHandler $uploadFileHandler
    ) {
        $this->uploadFileHandler = $uploadFileHandler;
        $this->repository = $repository;
    }

    /**
     * Загрузить файл
     *
     * @param UploadedFile $file
     * @param int          $taskId
     *
     * @return TaskFile
     */
    public function uploadFile(UploadedFile $file, int $taskId): TaskFile
    {
        return $this->uploadFileHandler->handle($file, $taskId);
    }

    /**
     * Удалить файл
     *
     * @param TaskFile $file
     *
     * @return bool|null
     */
    public function deleteFile(TaskFile $file)
    {
        return $this->repository->delete($file);
    }
}
