<?php

namespace App\Services;

use App\Contracts\StorageGatewayInterface;

class ApiLogger
{
    private $storageGateway;

    public function __construct(StorageGatewayInterface $storageGateway)
    {
        $this->storageGateway = $storageGateway;
    }

    public function log($request, $response)
    {
        $data = [
            'request' => $request,
            'response' => $response,
        ];

        $this->storageGateway->store($data);
    }
}
