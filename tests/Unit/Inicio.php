<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class Inicio extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
       // $this->assertTrue(true);
    }
}
