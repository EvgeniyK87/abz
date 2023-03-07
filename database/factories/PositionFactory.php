<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $positions = array( 
            'Back-end developer', 
            'Cloud/software architect', 
            'Cloud/software developer', 
            'Cloud/software applications engineer', 
            'Cloud system administrator', 
            'Cloud system engineer', 
            'DevOps engineer', 
            'Front-end developer', 
            'Full-stack developer', 
            'Java developer', 
            'Platform engineer', 
            'Release manager', 
            'Reliability engineer', 
            'Software engineer', 
            'Software quality assurance analyst', 
            'UI (user interface) designer', 
            'UX (user experience) designer', 
            'Web developer', 
            'Computer systems manager', 
            'Network architect', 
            'Systems analyst', 
            'IT coordinator', 
            'Network administrator', 
            'Network engineer', 
            'Service desk analyst', 
            'System administrator (also known as sysadmin)', 
            'Wireless network engineer', 
            'Cloud infrastructure architect', 
            'Enterprise architect', 
            'IT systems architect', 
            'Solutions architect', 
            'Technical architect', 
            'Big data engineer/architect', 
            'Business intelligence specialist/analyst', 
            'Business systems analyst', 
            'Data analyst', 
            'Data analytics developer', 
            'Data modeling analyst', 
            'Data scientist', 
            'Data warehouse manager', 
            'Data warehouse programming specialist', 
            'Intelligence specialist'
        );

        return [
            'name' => $this->faker->unique->randomElement($positions)
        ];
    }
}
