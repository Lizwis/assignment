<?php

namespace App\Services\Storage;

use App\Contracts\StorageGatewayInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DatabaseStorageGateway implements StorageGatewayInterface
{
    public function store($data)
    {
        // Code to store data in database

        DB::table('log')->insert([
            'request' => json_encode($data['request']),
            'response' => $data['response'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
