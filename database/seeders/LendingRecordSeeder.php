<?php

// database/seeders/LendingRecordSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LendingRecord;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class LendingRecordSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        foreach ($users as $user) {
            foreach ($books->random(2) as $book) {
                LendingRecord::create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                    'borrowed_at' => now(),
                    'due_at' => Carbon::now()->addDays(14),
                    'returned_at' => null, // not returned yet
                ]);
            }
        }
    }
}
