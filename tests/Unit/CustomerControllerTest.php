<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class CustomerControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_customers()
    {
        // Act
        $response = $this->getJson('api/customers');

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
                [
                     'full_name' => 'Claude Horton',
                     'email'     => 'claude.horton@example.com',
                     'country'   => 'Australia',
                 ],
                 [
                     'full_name' => 'Ryan Ortiz',
                     'email'     => 'ryan.ortiz@example.com',
                     'country'   => 'Australia',
                 ]
             ]);
    }

    /** @test */
    public function it_returns_a_single_customer()
    {
        // Act
        $customer = 5;
        $response = $this->getJson("api/customers/$customer");
        // Assert
        $response->assertStatus(200);
        $response->assertJson([
                     'full_name' => 'Erin Bowman',
                     'email'     => 'erin.bowman@example.com',
                     'gender'    => 'female',
                     'country'   => 'Australia',
                     'city'      => 'Nowra',
                     'phone'     => '09-4357-5306'
                 ]);
            
    }

    /** @test */
    public function it_returns_404_when_customer_not_found()
    {
        // Act
        $response = $this->getJson('/customers/999');

        // Assert
        $response->assertStatus(404);
    }
}
