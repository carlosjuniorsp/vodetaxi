<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Clients;

class ClientTest extends TestCase
{
    /**
     * Test a new Client
     */
    public function test_client_columns_is_correct(): void
    {
        $clients = new Clients();
        $expected = [
            'name',
            'email',
            'password',
            'city',
            'state',
            'address',
            'phone',
            'account_validation'
        ];

        $comparedArray = array_diff($expected, $clients->getFillable());
        $this->assertEquals(0, count($comparedArray));
    }
}
