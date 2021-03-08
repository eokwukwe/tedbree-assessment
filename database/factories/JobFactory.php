<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Type;
use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = Type::factory()->create();

        $condition = Condition::factory()->create();

        $category = Category::factory()->create();
        $user = User::factory()->create();

        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->realText(100),
            'location' => $this->faker->city,
            'company' => $this->faker->company,
            'benefits' => $this->faker->catchPhrase,
            'salary' => '₦300,000 per month',
            'type' => $type->name,
            'category' => $category->name,
            'work_condition' => $condition->name,
            'user_id' => $user->id
        ];
    }
}
