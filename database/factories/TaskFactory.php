<?php

namespace Database\Factories;

use App\Enums\Models\TaskStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        $this->statuses = TaskStatusEnum::cases();

        return [
            'description' =>  $this->faker->sentence(20),
            'status'      =>  $this->statuses[rand(0, count($this->statuses) -1)]
        ];
    }
}
