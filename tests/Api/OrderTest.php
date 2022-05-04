<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class OrderTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/orders');
        self::assertResponseIsSuccessful();
    }

    public function testGetItem(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/orders/1');
        self::assertResponseIsSuccessful();
    }

    public function testPatchItem(): void
    {
        $client = static::createClient();

        $client->request('PATCH', '/api/orders/1', [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'validated' => true
            ]
        ]);
        self::assertResponseIsSuccessful();
    }
}
