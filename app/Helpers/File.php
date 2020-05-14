<?php

namespace App\Helpers;

class File
{
    // some files must keep their extension, for example MP3
    public static function store($file, $folder)
    {
        if (empty($file)) return null;

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = md5($file . microtime()) . '.' . $extension;
        $storedFile = $file->storeAs($folder, $filename);

        return $storedFile;
    }
}