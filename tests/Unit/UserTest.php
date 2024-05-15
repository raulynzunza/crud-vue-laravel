<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Unit\Mocks\MockUser;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_users()
    {
        $mockUser = new MockUser();

        $user = User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $token = $response->json('token');

        $userList = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('api/users');

        $userList->assertStatus(200);
        $userList->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'email',
                'phone_number',
                'city',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_create_user()
    {

        $mockUser = new MockUser();

        User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post('api/users', [
            'name' => 'John',
            'email' => 'email@email.com',
            'password' => Hash::make('password'),
            'phone_number' => '5555555555',
            'city' => 'New York',
        ]);

        $response->assertStatus(201);
    }

    public function test_create_duplicate_user()
    {
        $mockUser = new MockUser();

        User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post('api/users', [
            'name' => 'John',
            'email' => 'email@email.com',
            'password' => Hash::make('password'),
            'phone_number' => '5555555555',
            'city' => 'New York',
        ]);

        $response->assertStatus(201);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post('api/users', [
            'name' => 'John',
            'email' => 'email@email.com',
            'password' => Hash::make('password'),
            'phone_number' => '5555555555',
            'city' => 'New York',
        ]);

        $response->assertStatus(400);

        $response->assertJson(['message' => 'The email has already been taken.']);
    }

    public function test_update_user()
    {
        $mockUser = new MockUser();

        $user = User::factory()->create($mockUser->getMockUser());
        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->put('api/users/' . $user['id'], [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make('password'),
            'phone_number' => '1111111111',
            'city' => $user['city'],
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'httpCode' => 200,
            'message' => 'User updated successfully'
        ]);
    }

    public function test_delete_user()
    {
        $mockUser = new MockUser();

        $user = User::factory()->create($mockUser->getMockUser());
        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $token = $response->json('token');

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->delete('api/users/' . $user['id']);

        $response->assertStatus(200);

        $response->assertJson(['httpCode' => 200, 'message' => 'User deleted successfully']);
    }
}
