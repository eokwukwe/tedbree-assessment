<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    /** @test */
    public function it_validates_that_name_is_provided_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => '',
                'email' => 'john@mail.com',
                'password' => 'password'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_name_is_a_string_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 12345,
                'email' => 'john@mail.com',
                'password' => 'password'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => [
                        "The name must be a string.",
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_email_is_provided_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => '',
                'password' => 'password'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => [
                        "The email field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_email_format_is_valid_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => 'man.com',
                'password' => 'password'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => [
                        "The email must be a valid email address."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_email_is_unique_valid_when_registering_a_new_user()
    {
        $user = User::factory()->create();

        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => $user->email,
                'password' => 'password'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "email" => [
                        "The email has already been taken."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_password_is_provided_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => 'mail@mail.com',
                'password' => ''
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_password_is_a_string_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => 'mail@mail.com',
                'password' => 12345678
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => [
                        "The password must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_password_is_a_string_of_atleat_eight_characters_when_registering_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => 'mail@mail.com',
                'password' => 'onetwo'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => [
                        "The password must be at least 8 characters."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_registers_a_new_user()
    {
        $this->postJson(
            '/v1/register',
            [
                'name' => 'tedbree',
                'email' => 'mail@mail.com',
                'password' => 'onetwothree'
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'tedbree',
            'email' => 'mail@mail.com',
        ]);
    }
}
