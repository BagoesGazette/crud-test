<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
        $category = [
            'name'          => $this->faker()->name(),
            'is_publish'    => 1
        ];
        $response = $this->postJson('/api/category', $category);
        $response->assertStatus(200);
    }
}
