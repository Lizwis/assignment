<?php

namespace App\Services\Storage;

use App\Contracts\StorageGatewayInterface;

class FileStorageGateway implements StorageGatewayInterface
{
    private $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('logs/api.log');
    }

    public function store($data)
    {
        $handle = fopen($this->filePath, 'a');
        fwrite($handle, json_encode($data) . PHP_EOL);
        fclose($handle);
    }
}
