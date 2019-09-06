<?php

namespace Tests\Feature;

use App\User;
use App\Orders;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTest extends TestCase

{
    use WithFaker,RefreshDatabase;

    public function testsOrdersAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'pizza' => 'PizzaINN',
            'size' => 'Large',
            'quantity'=>2,
            'location'=> 'Nairobi',
            'toppings' => 'onions'
        ];

        $this->json('POST', '/api/orders', $payload, $headers)
            ->assertStatus(201)
            ->assertJson(['id' => 1, 'pizza' => 'PizzaINN', 'size' => 'Large',
                            'quantity'=>2,'location'=>'Nairobi','toppings'=>'onions']);
    }

    public function testsOrdersAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $order = factory(Orders::class)->create([
            'pizza' => 'PizzaINN',
            'size' => 'Large',
            'quantity'=>2,
            'location'=> 'Nairobi',
            'toppings' => 'onions'
        ]);

        $payload = [
            'pizza' => 'Peppinos',
            'size' => 'Small',
            'quantity'=>3,
            'location'=> 'Nairobi-CBD',
            'toppings' => 'extra-cheese'
        ];

        $response = $this->json('PUT', '/api/orders/' . $order->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 2,
                'pizza' => 'Peppinos',
                'size' => 'Small',
                'quantity'=>3,
                'location'=> 'Nairobi-CBD',
                'toppings' => 'extra-cheese'
            ]);
    }

    public function testsOrdersAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $order = factory(Orders::class)->create([
            'pizza' => 'PizzaINN',
            'size' => 'Large',
            'quantity'=>2,
            'location'=> 'Nairobi',
            'toppings' => 'onions'
        ]);

        $this->json('DELETE', '/api/orders/' . $order->id, [], $headers)
            ->assertStatus(204);
    }

    public function testOrdersAreListedCorrectly()
    {
        factory(Orders::class)->create([
            'pizza' => 'PizzaINN',
            'size' => 'Large',
            'quantity'=>2,
            'location'=> 'Nairobi',
            'toppings' => 'onions'
        ]);

        factory(Orders::class)->create([
            'pizza' => 'PizzaINN-2',
            'size' => 'Large-2',
            'quantity'=>4,
            'location'=> 'Nairobi-2',
            'toppings' => 'onions-2'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/orders', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                ['pizza' => 'PizzaINN',
                'size' => 'Large',
                'quantity'=>2,
                'location'=> 'Nairobi',
                'toppings' => 'onions' ],
                ['pizza' => 'PizzaINN-2',
                'size' => 'Large-2',
                'quantity'=>4,
                'location'=> 'Nairobi-2',
                'toppings' => 'onions-2' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'pizza', 'size', 'quantity','location','toppings','created_at', 'updated_at'],
            ]);
    }
}
