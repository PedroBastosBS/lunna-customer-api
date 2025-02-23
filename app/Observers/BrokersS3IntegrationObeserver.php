<?php

namespace App\Observers;

use App\Models\Broker;
use App\Models\User;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;

class BrokersS3IntegrationObeserver
{
    //
    public function created(Broker $broker): void
    {
        $brokers = User::from('users as u')
                ->join('brokers as b', 'b.user_id', 'u.id')
                ->select(['u.name', 'u.email', 'u.phone'])
                ->get();

        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);

        try {
            $s3->putObject([
                'Bucket' => 'lunna-advertiser-users-bucket',
                'Key'    => 'UserAdvertiserList.json',
                'Body'   => json_encode($brokers, JSON_PRETTY_PRINT),
                'ContentType' => 'application/json'
            ]);
        } catch (AwsException $e) {
            Log::error('Erro ao atualizar lista de corretores no S3: ' . $e->getMessage());
        }
    }
}
