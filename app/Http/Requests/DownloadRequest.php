<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request for download messages.
 *
 * @property string $type Type of file for download
 */
class DownloadRequest extends FormRequest
{
    public const TYPE = 'type';
    
    public const FILE_TYPE_TXT = 'txt';
    public const FILE_TYPE_JSON = 'json';
    public const FILE_TYPE_CSV = 'csv';
    
    public const FILE_TYPES = [self::FILE_TYPE_TXT, self::FILE_TYPE_JSON, self::FILE_TYPE_CSV];
    
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            self::TYPE => ['nullable','string', Rule::in(self::FILE_TYPES)]
        ];
    }
}
