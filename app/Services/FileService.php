<?php

namespace App\Services;

use App\Http\Requests\DownloadRequest;
use App\Http\Resources\FileMessagesCollection;
use App\Models\Message;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service for download data as file.
 */
class FileService
{
    protected const FILE_NAME = 'missions';
    
    /**
     * Get callback for stream download.
     *
     * @param string $fileType Type of the file
     * @param Collection $data Messages data
     *
     * @return Closure
     */
    public function getCallback(string $fileType, Collection $data): Closure
    {
        return function () use ($fileType, $data) {
            $handle = fopen('php://output', 'w');
            
            switch ($fileType) {
                case DownloadRequest::FILE_TYPE_CSV:
                    $this->addDataInCsv($handle, $data);
                    break;
                case DownloadRequest::FILE_TYPE_TXT:
                    $this->addDataInTxt($handle, $data);
                    break;
                case DownloadRequest::FILE_TYPE_JSON:
                default:
                    $this->addDataInJson($handle, $data);
                    break;
            }
            
            fclose($handle);
        };
    }
    
    /**
     * Add data in file as CSV.
     *
     * @param resource $handle The file pointer
     * @param Collection|Message[] $data Message collection
     *
     * @return void
     */
    protected function addDataInCsv(&$handle, Collection $data): void
    {
        fputcsv($handle, $this->getTitle());
        
        $data->each(function (Message $message) use (&$handle) {
            fputcsv(
                $handle,
                $this->getMessageAsArray($message)
            );
        });
    }
    
    /**
     * Get title.
     *
     * @return string[]|array
     */
    protected function getTitle(): array
    {
        return ['Message ID', 'Message', 'User ID', 'User Full Name', 'Created At', 'Updated At'];
    }
    
    /**
     * Get message.
     *
     * @param Message $message Message object
     *
     * @return array
     */
    protected function getMessageAsArray(Message $message): array
    {
        return [
            $message->id,
            $message->message,
            $message->userId,
            $message->user->firstName . ' ' . $message->user->lastName,
            $message->createdAt,
            $message->updatedAt,
        ];
    }
    
    /**
     * Add data in file as TXT.
     *
     * @param resource $handle The file pointer
     * @param Collection|Message[] $data Message collection
     *
     * @return void
     */
    protected function addDataInTxt(&$handle, Collection $data): void
    {
        fwrite($handle, implode("\t", $this->getTitle()) . "\n");
        $data->each(function (Message $message) use (&$handle) {
            fwrite($handle, implode("\t", $this->getMessageAsArray($message)) . "\n");
        });
    }
    
    /**
     * Add data in file as JSON.
     *
     * @param resource $handle The file pointer
     * @param Collection|Message[] $data Message collection
     *
     * @return void
     */
    protected function addDataInJson(&$handle, Collection $data): void
    {
        fwrite($handle, $this->getDataAsResource($data)->toJson());
    }
    
    /**
     * Get data as resource.
     *
     * @param Collection $data
     *
     * @return FileMessagesCollection
     */
    protected function getDataAsResource(Collection $data): FileMessagesCollection
    {
        return new FileMessagesCollection($data);
    }
    
    /**
     * Get file type.
     *
     * @param DownloadRequest $request Download request
     *
     * @return string
     */
    public function getFileType(DownloadRequest $request): string
    {
        return $request->type ?? DownloadRequest::FILE_TYPE_JSON;
    }
    
    /**
     * Get file name.
     *
     * @param string $fileType Type of the file name
     *
     * @return string
     */
    public function getFileName(string $fileType): string
    {
        $fileName = self::FILE_NAME;
        $fileName .= Carbon::now()->format('Y-m-d');
        $fileName .= '.' . $fileType;
        
        return $fileName;
    }
    
    /**
     * Get headers for response.
     *
     * @param string $fileType Type of the file name
     *
     * @return string[]
     */
    public function getHeaders(string $fileType): array
    {
        switch ($fileType) {
            case DownloadRequest::FILE_TYPE_CSV:
                $contentType = 'text/csv';
                break;
            case DownloadRequest::FILE_TYPE_TXT:
                $contentType = 'text/plain';
                break;
            case DownloadRequest::FILE_TYPE_JSON:
            default:
                $contentType = 'application/json';
        }
        
        return ['Content-Type' => $contentType];
    }
}
