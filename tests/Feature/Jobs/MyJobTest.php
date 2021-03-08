<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use App\Models\Type;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyJobTest extends TestCase
{

    use RefreshDatabase;

    protected $user, $type, $condition, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();

        $this->user = User::factory()->create();

        $this->type = Type::factory()->create();

        $this->condition = Condition::factory()->create();

        $this->category = Category::factory()->create();
    }

    /** @test */
    public function it_validates_that_title_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => '',
                'description' => 'this is a job of jobs',
                'location' => 'Yaba, Lagos',
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "title" => [
                        "The title field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_title_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 123456,
                'description' => 'this is a job of jobs',
                'location' => 'Yaba, Lagos',
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "title" => [
                        "The title must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_description_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => '',
                'location' => 'Yaba, Lagos',
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "description" => [
                        "The description field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_description_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 12345,
                'location' => 'Yaba, Lagos',
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "description" => [
                        "The description must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_location_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => '',
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',

                ]
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "location" => [
                        "The location field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_location_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 112345,
                'company' => 'Tedbree Technologies',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "location" => [
                        "The location must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_company_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => '',
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "company" => [
                        "The company field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_company_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 12345,
                'benefits' => 'health insurance',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "company" => [
                        "The company must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_benefits_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => '',
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "benefits" => [
                        "The benefits field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_benefits_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 12345,
                'salary' => '₦300,000 per month',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "benefits" => [
                        "The benefits must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_salary_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => '',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "salary" => [
                        "The salary field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_salary_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 12345,
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "salary" => [
                        "The salary must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_type_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => '',
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "type" => [
                        "The type field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_type_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => 12345,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "type" => [
                        "The type must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_the_selected_type_exits_in_the_database_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => 'sometype',
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "type" => [
                        "The selected type does not exist."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_category_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => '',
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "category" => [
                        "The category field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_category_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => 123456,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "category" => [
                        "The category must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_the_selected_category_exits_in_the_database_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => 'category',
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "category" => [
                        "The selected category does not exist."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_work_condition_is_provided_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the job that is job',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => '',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "work_condition" => [
                        "The work condition field is required."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_work_condition_is_a_string_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => 123456,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',

            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "work_condition" => [
                        "The work condition must be a string."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_validates_that_the_selected_work_condition_exits_in_the_database_when_creating_a_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => 'condition',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "work_condition" => [
                        "The selected work condition does not exist."
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_allows_registered_user_to_creates_a_new_job()
    {
        $this->actingAs($this->user);

        $this->postJson(
            '/v1/my/jobs',
            [
                'title' => 'frontend developer',
                'description' => 'the jon tha t os slsld',
                'location' => 'somewhere',
                'company' => 'company',
                'benefits' => 'benefit',
                'salary' => 'salary',
                'type' => $this->type->name,
                'category' => $this->category->name,
                'work_condition' => $this->condition->name,
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(201);

        $this->assertDatabaseHas('jobs', [
            'title' => 'frontend developer',
            'description' => 'the jon tha t os slsld',
            'location' => 'somewhere',
            'company' => 'company',
            'benefits' => 'benefit',
            'salary' => 'salary',
            'type' => $this->type->name,
            'category' => $this->category->name,
            'work_condition' => $this->condition->name,
        ]);
    }

    /** @test */
    public function it_allows_registered_user_to_update_their_job()
    {
        $job = Job::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $this->putJson(
            "/v1/my/jobs/{$job->id}",
            [
                'title' => 'frontend developer updated',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200);

        $this->assertDatabaseHas('jobs', [
            'title' => 'frontend developer updated',
            'description' => $job->description,
            'location' => $job->location,
            'company' => $job->company,
            'benefits' => $job->benefits,
            'salary' => $job->salary,
            'type' => $job->type,
            'category' => $job->category,
            'work_condition' => $job->work_condition,
        ]);
    }

    /** @test */
    public function it_denies_registered_user_to_update_another_user_job()
    {
        $newUser = User::factory()->create();

        $job = Job::factory()->create(['user_id' => $newUser->id]);

        $this->actingAs($this->user);

        $this->putJson(
            "/v1/my/jobs/{$job->id}",
            [
                'title' => 'frontend developer updated',
            ],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(403)
            ->assertJson([
                'status' => 'failure',
                'message' => 'This action is unauthorized.'
            ]);
    }

    /** @test */
    public function it_allows_registered_user_to_delete_their_job()
    {
        $job = Job::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);

        $this->deleteJson(
            "/v1/my/jobs/{$job->id}",
            [],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200);

        $this->assertDatabaseMissing('jobs', [
            'title' => $job->title,
            'description' => $job->description,
            'location' => $job->location,
            'company' => $job->company,
            'benefits' => $job->benefits,
            'salary' => $job->salary,
            'type' => $job->type,
            'category' => $job->category,
            'work_condition' => $job->work_condition,
        ]);
    }

    /** @test */
    public function it_denies_registered_user_to_delete_another_user_job()
    {
        $newUser = User::factory()->create();

        $job = Job::factory()->create(['user_id' => $newUser->id]);

        $this->actingAs($this->user);

        $this->deleteJson(
            "/v1/my/jobs/{$job->id}",
            [],
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(403)
            ->assertJson([
                'status' => 'failure',
                'message' => 'This action is unauthorized.'
            ]);
    }

    /** @test */
    public function it_allows_users_to_view_all_their_created_jobs()
    {
        $this->actingAs($this->user);

        $jobs = [];

        foreach ([1, 2, 3, 4, 5] as $indx) {
            $jobs[] = Job::factory()->create(['user_id' => $this->user->id]);

            sleep(1);
        }

        $this->getJson(
            '/v1/my/jobs',
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $jobs[4]->id,
                        'title' => $jobs[4]->title,
                        'company' => $jobs[4]->company,
                        'company_logo' => $jobs[4]->company_logo,
                        'location' => $jobs[4]->location,
                        'category' => $jobs[4]->category,
                        'salary' => $jobs[4]->salary,
                        'description' => $jobs[4]->description,
                        'benefits' => $jobs[4]->benefits,
                        'type' => $jobs[4]->type,
                        'work_condition' => $jobs[4]->work_condition,
                        'created_at' => $jobs[4]->created_at->toJson(),
                        'updated_at' => $jobs[4]->updated_at->toJson(),
                    ],
                    [
                        'id' => $jobs[3]->id,
                        'title' => $jobs[3]->title,
                        'company' => $jobs[3]->company,
                        'company_logo' => $jobs[3]->company_logo,
                        'location' => $jobs[3]->location,
                        'category' => $jobs[3]->category,
                        'salary' => $jobs[3]->salary,
                        'description' => $jobs[3]->description,
                        'benefits' => $jobs[3]->benefits,
                        'type' => $jobs[3]->type,
                        'work_condition' => $jobs[3]->work_condition,
                        'created_at' => $jobs[3]->created_at->toJson(),
                        'updated_at' => $jobs[3]->updated_at->toJson(),
                    ],
                    [
                        'id' => $jobs[2]->id,
                        'title' => $jobs[2]->title,
                        'company' => $jobs[2]->company,
                        'company_logo' => $jobs[2]->company_logo,
                        'location' => $jobs[2]->location,
                        'category' => $jobs[2]->category,
                        'salary' => $jobs[2]->salary,
                        'description' => $jobs[2]->description,
                        'benefits' => $jobs[2]->benefits,
                        'type' => $jobs[2]->type,
                        'work_condition' => $jobs[2]->work_condition,
                        'created_at' => $jobs[2]->created_at->toJson(),
                        'updated_at' => $jobs[2]->updated_at->toJson(),
                    ],
                    [
                        'id' => $jobs[1]->id,
                        'title' => $jobs[1]->title,
                        'company' => $jobs[1]->company,
                        'company_logo' => $jobs[1]->company_logo,
                        'location' => $jobs[1]->location,
                        'category' => $jobs[1]->category,
                        'salary' => $jobs[1]->salary,
                        'description' => $jobs[1]->description,
                        'benefits' => $jobs[1]->benefits,
                        'type' => $jobs[1]->type,
                        'work_condition' => $jobs[1]->work_condition,
                        'created_at' => $jobs[1]->created_at->toJson(),
                        'updated_at' => $jobs[1]->updated_at->toJson(),
                    ],
                    [
                        'id' => $jobs[0]->id,
                        'title' => $jobs[0]->title,
                        'company' => $jobs[0]->company,
                        'company_logo' => $jobs[0]->company_logo,
                        'location' => $jobs[0]->location,
                        'category' => $jobs[0]->category,
                        'salary' => $jobs[0]->salary,
                        'description' => $jobs[0]->description,
                        'benefits' => $jobs[0]->benefits,
                        'type' => $jobs[0]->type,
                        'work_condition' => $jobs[0]->work_condition,
                        'created_at' => $jobs[0]->created_at->toJson(),
                        'updated_at' => $jobs[0]->updated_at->toJson(),
                    ],
                ],
                'links' => [
                    'first' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
                    'last' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
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
                            'url' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
                            'label' => '1',
                            'active' => true
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false
                        ]
                    ],
                    'path' => 'http://find-jobs.test.com/v1/my/jobs',
                    'per_page' => 15,
                    'to' => 5,
                    'total' => 5
                ]
            ]);
    }

    /** @test */
    public function it_allows_users_to_search_their_jobs_by_keyword_query()
    {
        $this->actingAs($this->user);

        Job::factory()->count(2)->create([
            'title' => 'Frontend Developer',
            'user_id' => $this->user->id
        ]);

        $backends = [];

        foreach ([1, 2, 3] as $indx) {
            $backends[] = Job::factory()->create([
                'title' => 'Backend Developer',
                'user_id' => $this->user->id
            ]);

            sleep(1);
        }

        $this->getJson(
            '/v1/my/jobs?q=backend',
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $backends[2]->id,
                        'title' => $backends[2]->title,
                        'company' => $backends[2]->company,
                        'company_logo' => $backends[2]->company_logo,
                        'location' => $backends[2]->location,
                        'category' => $backends[2]->category,
                        'salary' => $backends[2]->salary,
                        'description' => $backends[2]->description,
                        'benefits' => $backends[2]->benefits,
                        'type' => $backends[2]->type,
                        'work_condition' => $backends[2]->work_condition,
                        'created_at' => $backends[2]->created_at->toJson(),
                        'updated_at' => $backends[2]->updated_at->toJson(),
                    ],
                    [
                        'id' => $backends[1]->id,
                        'title' => $backends[1]->title,
                        'company' => $backends[1]->company,
                        'company_logo' => $backends[1]->company_logo,
                        'location' => $backends[1]->location,
                        'category' => $backends[1]->category,
                        'salary' => $backends[1]->salary,
                        'description' => $backends[1]->description,
                        'benefits' => $backends[1]->benefits,
                        'type' => $backends[1]->type,
                        'work_condition' => $backends[1]->work_condition,
                        'created_at' => $backends[1]->created_at->toJson(),
                        'updated_at' => $backends[1]->updated_at->toJson(),
                    ],
                    [
                        'id' => $backends[0]->id,
                        'title' => $backends[0]->title,
                        'company' => $backends[0]->company,
                        'company_logo' => $backends[0]->company_logo,
                        'location' => $backends[0]->location,
                        'category' => $backends[0]->category,
                        'salary' => $backends[0]->salary,
                        'description' => $backends[0]->description,
                        'benefits' => $backends[0]->benefits,
                        'type' => $backends[0]->type,
                        'work_condition' => $backends[0]->work_condition,
                        'created_at' => $backends[0]->created_at->toJson(),
                        'updated_at' => $backends[0]->updated_at->toJson(),
                    ],
                ],
                'links' => [
                    'first' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
                    'last' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
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
                            'url' => 'http://find-jobs.test.com/v1/my/jobs?page=1',
                            'label' => '1',
                            'active' => true
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false
                        ]
                    ],
                    'path' => 'http://find-jobs.test.com/v1/my/jobs',
                    'per_page' => 15,
                    'to' => 3,
                    'total' => 3
                ]
            ]);
    }
}
