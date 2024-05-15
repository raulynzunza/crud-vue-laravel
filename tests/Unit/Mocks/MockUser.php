<?php

namespace Tests\Unit\Mocks;

use Illuminate\Support\Facades\Hash;

class MockUser
{
    /**
     * Get mock user data.
     *
     * @return array
     */
    public function getMockUser()
    {
        return [
            'name' => 'John',
            'email' => 'john@email.com',
            'password' => Hash::make('password'),
            'phone_number' => '5555555555',
            'city' => 'New York',
        ];
    }
}
