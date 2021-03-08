<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
{

    use RefreshDatabase;

    protected $user, $type, $condition, $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    /** @test */
    public function it_allows_guest_user_to_view_a_single_job()
    {
        $user = User::factory()->create();

        $job = Job::factory()->create(['user_id' => $user->id]);

        $this->getJson(
            "/v1/jobs/{$job->id}",
            [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company,
                    'company_logo' => $job->company_logo,
                    'location' => $job->location,
                    'category' => $job->category,
                    'salary' => $job->salary,
                    'description' => $job->description,
                    'benefits' => $job->benefits,
                    'type' => $job->type,
                    'work_condition' => $job->work_condition,
                    'created_at' => $job->created_at->toJson(),
                    'updated_at' => $job->updated_at->toJson(),
                ]
            ]);
    }

    /** @test */
    public function it_allows_guest_user_to_view_all_jobs()
    {
        $user = User::factory()->create();

        $jobs = [];

        foreach ([1, 2, 3, 4, 5] as $indx) {
            $jobs[] = Job::factory()->create(['user_id' => $user->id]);

            sleep(1);
        }

        $this->getJson(
            '/v1/jobs',
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
                    'first' => 'http://find-jobs.test.com/v1/jobs?page=1',
                    'last' => 'http://find-jobs.test.com/v1/jobs?page=1',
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
                            'url' => 'http://find-jobs.test.com/v1/jobs?page=1',
                            'label' => '1',
                            'active' => true
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false
                        ]
                    ],
                    'path' => 'http://find-jobs.test.com/v1/jobs',
                    'per_page' => 15,
                    'to' => 5,
                    'total' => 5
                ]
            ]);
    }

    /** @test */
    public function it_allows_guest_user_to_search_through_jobs_by_keyword_query()
    {
        $user = User::factory()->create();

        Job::factory()->count(2)->create([
            'title' => 'Frontend Developer',
            'user_id' => $user->id
        ]);

        $backends = [];

        foreach ([1, 2, 3] as $indx) {
            $backends[] = Job::factory()->create([
                'title' => 'Backend Developer',
                'user_id' => $user->id
            ]);

            sleep(1);
        }

        $this->getJson(
            '/v1/jobs?q=backend',
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
                    'first' => 'http://find-jobs.test.com/v1/jobs?page=1',
                    'last' => 'http://find-jobs.test.com/v1/jobs?page=1',
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
                            'url' => 'http://find-jobs.test.com/v1/jobs?page=1',
                            'label' => '1',
                            'active' => true
                        ],
                        [
                            'url' => null,
                            'label' => 'Next &raquo;',
                            'active' => false
                        ]
                    ],
                    'path' => 'http://find-jobs.test.com/v1/jobs',
                    'per_page' => 15,
                    'to' => 3,
                    'total' => 3
                ]
            ]);
    }
}
