<?php

namespace App\Contracts;

interface StorageGatewayInterface
{
    public function store($data);
}
