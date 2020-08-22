<?php

namespace App\Services\TaskFiles\Handlers;

use App\Models\TaskFile;
use App\Services\TaskFiles\Repositories\TaskFilesRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadFileHandler
 *
 * @package App\Services\TaskFiles\Handlers
 */
class UploadFileHandler
{
    /**
     * @var TaskFilesRepositoryInterface
     */
    private $repository;

    /**
     * UploadFileHandler constructor.
     *
     * @param TaskFilesRepositoryInterface $repository
     */
    public function __construct(TaskFilesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UploadedFile $file
     * @param int          $taskId
     *
     * @return TaskFile
     */
    public function handle(UploadedFile $file, int $taskId): TaskFile
    {
        $filePath = TaskFile::FILE_PATH . "{$taskId}/";
        $fileNamePaths = explode('.', $file->getClientOriginalName());
        $ext = array_pop($fileNamePaths);
        $fileName = $file->getClientOriginalName();

        $n = 0;
        while (Storage::disk('local')->exists($filePath . $fileName)) {
            $n++;
            $fileName = join('.', $fileNamePaths) . " ({$n})." . $ext;
        }

        Storage::disk('local')->putFileAs(
            $filePath,
            $file,
            $fileName
        );

        return $this->repository->createFromArray([
            'task_id' => $taskId,
            'user_id' => \Auth::id(),
            'file'    => "{$taskId}/{$fileName}",
        ]);
    }
}
