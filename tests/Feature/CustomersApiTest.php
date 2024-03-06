<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomersApiTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory(1)->create()[0];

        $this->createUsers();

        $this->fakeData = [
            'first_name' => fake()->firstName,
            'last_name'  => fake()->lastName,
        ];
    }


    public function test_that_user_can_create_new_client()
    {
        $attributes = [
            'first_name' => fake()->firstName,
            'last_name'  => fake()->lastName,
        ];

        $response = $this->actingAs($this->user)->postJson(route('customers.create'), $attributes);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
        $response->assertJsonFragment([
            'message' => 'Customer has been created!'
        ]);

        $this->assertDatabaseHas(Customer::class, ['id' => $this->customer->id]);

    }

    public function test_that_admin_can_create_new_client()
    {
        $attributes = [
            'first_name' => fake()->firstName,
            'last_name'  => fake()->lastName,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('customers.create'), $attributes);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
        $response->assertJsonFragment([
            'message' => 'Customer has been created!'
        ]);

        $this->assertDatabaseHas(Customer::class, ['id' => $this->customer->id]);

    }

    public function test_first_name_is_required_during_create()
    {
        $this->fakeData['first_name'] = null;
        $response = $this->actingAs($this->user)->postJson(route('customers.create'), $this->fakeData);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['first_name']);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name'
            ]
        ]);
        $response->assertJsonFragment([
            'message' => 'The first name field is required.'
        ]);
    }

    public function test_last_name_is_required_during_create()
    {
        $this->fakeData['last_name'] = null;
        $response = $this->actingAs($this->user)->postJson(route('customers.create'), $this->fakeData);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['last_name']);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'last_name'
            ]
        ]);
        $response->assertJsonFragment([
            'message' => 'The last name field is required.'
        ]);
    }

    public function test_first_name_can_not_be_number_during_create()
    {
        $this->fakeData['first_name'] = 123;
        $response = $this->actingAs($this->user)->postJson(route('customers.create'), $this->fakeData);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['first_name']);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'first_name'
            ]
        ]);
        $response->assertJsonFragment([
            'message' => 'The first name field must be a string.'
        ]);
    }

    public function test_last_name_can_not_be_number_during_create()
    {
        $this->fakeData['last_name'] = 123;
        $response = $this->actingAs($this->user)->postJson(route('customers.create'), $this->fakeData);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['last_name']);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'last_name'
            ]
        ]);
        $response->assertJsonFragment([
            'message' => 'The last name field must be a string.'
        ]);
    }

    public function test_user_cannot_delete_customer()
    {
        $response = $this->actingAs($this->user)->deleteJson(route('customers.destroy', ['id' => $this->customer->id]));
        $response->assertforbidden();
    }

    public function test_admin_can_delete_customer()
    {
        $response = $this->actingAs($this->admin)->deleteJson(route('customers.destroy', ['id' => $this->customer->id]));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            // 'deleted'
        ]);
        $response->assertJsonFragment([
            'message' => 'Customer has been deleted!'
        ]);
        $this->assertSoftDeleted(Customer::class, ['id' => $this->customer->id]);
    }

    public function test_admin_can_display_customers()
    {
        $response = $this->actingAs($this->admin)->getJson(route('customers.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',

                ]
            ]
        ]);
    }

    public function test_user_can_display_customers()
    {
        $response = $this->actingAs($this->user)->getJson(route('customers.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',

                ]
            ]
        ]);
    }
}
