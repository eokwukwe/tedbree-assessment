<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected $job;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();

        $this->job = Job::factory()->create();

        Storage::fake('public');
    }

    /** @test */
    public function it_validates_that_first_name_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => '',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'first_name' => [
                        'The first name field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_first_name_is_a_string_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 12345,
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'first_name' => [
                        'The first name must be a string.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_last_name_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => '',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'last_name' => [
                        'The last name field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_last_name_is_a_string_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 12345,
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'last_name' => [
                        'The last name must be a string.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_email_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => '',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'The email field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_email_is_valid_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'manboy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_against_duplicate_application()
    {
        JobApplication::factory()->create([
            'first_name' => 'man',
            'last_name' => 'boy',
            'email' => 'man@boy.com',
            'location' => 'makanda',
            'phone' => '09091231234',
            'cv' => 'http://my-cv.pdf',
            'job_id' => $this->job->id
        ]);

        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'You have already applied for this job.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_location_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => '',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'location' => [
                        'The location field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_location_is_a_string_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 12344,
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'location' => [
                        'The location must be a string.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_phone_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'phone' => [
                        'The phone field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_phone_is_a_string_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => 12345678,
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'phone' => [
                        'The phone must be a string.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_phone_is_valid_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '090912341234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'phone' => [
                        'The phone format is invalid.'
                    ]
                ]
            ]);
    }


    /** @test */
    public function it_validates_that_cv_is_provided_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => '',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'cv' => [
                        'The cv field is required.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_cv_size_is_not_more_than_2mb_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 3000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'cv' => [
                        'The cv may not be greater than 2MB.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_cv_has_allowed_mime_type_when_submitting_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.docx', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'cv' => [
                        'The cv must be a file of type: jpeg, jpg, png, pdf.'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_successfully_submits_a_job_application()
    {
        $this->postJson(
            "/v1/jobs/{$this->job->id}/apply",
            [
                'first_name' => 'man',
                'last_name' => 'boy',
                'email' => 'man@boy.com',
                'location' => 'makanda',
                'phone' => '09091231234',
                'cv' => UploadedFile::fake()->create('avatar.jpg', 1000),
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Application Successfully Submitted!'
            ]);
    }

    /** @test */
    public function it_allows_user_to_view_the_applications_for_owned_job()
    {
        $user = User::factory()->create();

        $job = Job::factory()->create(['user_id' => $user->id]);

        $applications = JobApplication::factory()
            ->count(3)
            ->create(['job_id' => $job->id]);

        $this->actingAs($user);

        $this->getJson(
            "v1/my/jobs/{$job->id}/applications",
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'job_id' => $applications[0]->job_id,
                        'first_name' => $applications[0]->first_name,
                        'last_name' => $applications[0]->last_name,
                        'email' => $applications[0]->email,
                        'location' => $applications[0]->location,
                        'phone' => $applications[0]->phone,
                        'cv' => $applications[0]->cv,
                    ],
                    [
                        'job_id' => $applications[1]->job_id,
                        'first_name' => $applications[1]->first_name,
                        'last_name' => $applications[1]->last_name,
                        'email' => $applications[1]->email,
                        'location' => $applications[1]->location,
                        'phone' => $applications[1]->phone,
                        'cv' => $applications[1]->cv,
                    ],
                    [
                        'job_id' => $applications[2]->job_id,
                        'first_name' => $applications[2]->first_name,
                        'last_name' => $applications[2]->last_name,
                        'email' => $applications[2]->email,
                        'location' => $applications[2]->location,
                        'phone' => $applications[2]->phone,
                        'cv' => $applications[2]->cv,
                    ],
                ],
                'links' => [
                    'first' => "http://find-jobs.test.com/v1/my/jobs/{$job->id}/applications?page=1",
                    'last' => "http://find-jobs.test.com/v1/my/jobs/{$job->id}/applications?page=1",
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'links' => [
                        [
                            'url' => null,
                            'label' => '&laquo; Previous',
                            'active' => false
                        ],
                        [
                            'url' => "http://find-jobs.test.com/v1/my/jobs/{$job->id}/applications?page=1",
                            'label' => '1',
                            'active' => true
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false
                        ]
                    ],
                    'path' => "http://find-jobs.test.com/v1/my/jobs/{$job->id}/applications",
                    'per_page' => 15,
                    'to' => 3,
                    'total' => 3
                ]
            ]);
    }
}
