<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

use Tests\TestCase;
use Tests\Unit\Mocks\MockUser;

class LoginTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic unit test example.
     */

    public function test_login_with_valid_credentials()
    {

        $mockUser = new MockUser();

        $user = User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Logged in successfully',
            'token' => true,
        ]);
    }

    public function test_login_with_invalid_password()
    {
        $mockUser = new MockUser();
        $user = User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'john@email.com',
            'password' => 'error',
        ]);

        $response->assertStatus(400);

        $response->assertJson(['message' => 'password is incorrect']);
    }

    public function test_login_with_invalid_email()
    {
        $mockUser = new MockUser();
        $user = User::factory()->create($mockUser->getMockUser());

        $response = $this->post('api/login', [
            'email' => 'error@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'user does not exist with that email']);
    }
}
