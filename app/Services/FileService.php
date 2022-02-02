<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public const SIGN_UP_STATE_FILE_NAME = 'chances.json';

    public static function saveToFile($array): bool
    {
        Storage::put(self::SIGN_UP_STATE_FILE_NAME, json_encode($array));
        return true;
    }

    public static function getFromFile(): ?array
    {
        if (Storage::disk('local')->exists(self::SIGN_UP_STATE_FILE_NAME)) {
            return json_decode(Storage::get(self::SIGN_UP_STATE_FILE_NAME), true);
        }
        return null;
    }
}