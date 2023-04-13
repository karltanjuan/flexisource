<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImportCustomersTest extends TestCase
{

    /** @test */
    public function it_imports_customers()
    {
        Http::fake([
            'https://randomuser.me/api/*' => Http::response([
                'results' => [
                    [
                        'name' => [
                            'first' => 'John',
                            'last' => 'Doe',
                        ],
                        'email' => 'johndoe@example.com',
                        'login' => [
                            'password' => 'password',
                        ],
                        'gender' => 'male',
                        'phone' => '123-456-7890',
                        'nat' => 'au',
                        'location' => [
                            'street' => [
                                'name' => '123 Main St',
                            ],
                            'city' => 'Sydney',
                            'country' => 'Australia',
                        ],
                    ],
                ],
            ]),
        ]);

        $this->artisan('import:customers')->expectsOutput('Imported 1 customers.');

        $this->assertDatabaseHas('customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => md5('password'),
            'gender' => 'male',
            'phone' => '123-456-7890',
            'nationality' => 'au',
            'address' => '123 Main St',
            'city' => 'Sydney',
            'country' => 'Australia',
        ]);
    }
}
