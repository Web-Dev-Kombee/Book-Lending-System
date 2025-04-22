<?php

// database/factories/BookFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $totalCopies = $this->faker->numberBetween(3, 20);
        $availableCopies = $this->faker->numberBetween(0, $totalCopies);

        // Example of book-related descriptions
        $descriptions = [
            "This captivating story follows the journey of a young protagonist who faces challenges and learns valuable life lessons along the way.",
            "A heartwarming tale of friendship, love, and loss. The novel takes you through a world of emotions, with unforgettable characters.",
            "Set in a dystopian future, this novel explores themes of oppression, survival, and the fight for freedom in a world on the brink of collapse.",
            "A thrilling mystery that will keep you on the edge of your seat. A detective must unravel the truth behind a string of mysterious disappearances.",
            "In this science fiction epic, humanity's survival is at stake. With intense battles, technological marvels, and complex characters, the fate of the universe hangs in the balance.",
            "This historical fiction novel takes you back to a pivotal time in history, where heroes were made, and lives were forever changed.",
        ];

        // Randomly pick a book description
        $description = $this->faker->randomElement($descriptions);

        return [
            'title' => $this->faker->catchPhrase(), // More book-like title
            'author' => $this->faker->name(), // Looks like real author names
            'isbn' => $this->faker->unique()->isbn13(),
            'total_copies' => $totalCopies,
            'available_copies' => $availableCopies,
            'description' => $description, // Book-related description
            'cover_image' => 'covers/book-' . $this->faker->numberBetween(1, 10) . '.jpg', // Assuming you have some dummy images
            'is_active' => $this->faker->boolean(90), // 90% chance it's active
        ];
    }
}
