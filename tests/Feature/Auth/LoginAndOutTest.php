<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginAndOutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    /** @test */
    public function it_validates_that_email_is_provided_when_logging_user_in()
    {
        $this->postJson(
            '/v1/login',
            [
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
    public function it_validates_that_email_format_is_valid_when_logging_user_in()
    {
        $this->postJson(
            '/v1/login',
            [
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
    public function it_validates_that_password_is_provided_when_logging_user_in()
    {
        $this->postJson(
            '/v1/login',
            [
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
    public function it_validatess_that_login_credentials_are_correct_when_logging_user_in()
    {
        $user = User::factory()->create();

        $this->postJson(
            '/v1/login',
            [
                'email' => $user->email,
                'password' => 'incorrect'
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
                        "Invalid login credentials."
                    ]
                ]
            ]);
    }


    /** @test */
    public function it_logs_in_a_user_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('testpassword')
        ]);

        $this->postJson(
            '/v1/login',
            [
                'email' => $user->email,
                'password' => 'testpassword',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(201);
    }

    /** @test */
    public function it_fetches_the_authenticated_user()
    {
        $user = User::factory()->create();

        $nameForAvatar = $user->prepareNameForAvatar();

        $avatar = "https://ui-avatars.com/api/?name={$nameForAvatar}";

        $this->actingAs($user);

        $this->getJson(
            '/v1/user',
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $avatar,
                    'created_at' => $user->created_at->toJson(),
                    'updated_at' => $user->updated_at->toJson(),
                ]
            ]);
    }

    /** @test */
    public function it_logs_out_authenticated_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->postJson(
            '/v1/logout',
            [],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                "status" => "success",
                "message" => "Successfully logged out user."
            ]);
    }
}
