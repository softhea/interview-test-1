<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $strengths = ['PHP', 'Laravel', 'Angular', 'React', 'Python', 'Vue.js', 'TailwindCSS', 'Wordpress'];
        shuffle($strengths);

        $softSkills = ['Diplomacy', 'Team player', 'Leadership', 'Sales experience', 'Presentation abilities', 'Public speaking', 'Conflict management'];
        shuffle($softSkills);

        static $userId = 2;

        return [
            'user_id' => $userId++,
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'description' => $this->faker->text,
            'strengths' => json_encode(array_slice($strengths, 0, 4)),
            'soft_skills' => json_encode(array_slice($softSkills, 0, 4)),
        ];
    }
}
