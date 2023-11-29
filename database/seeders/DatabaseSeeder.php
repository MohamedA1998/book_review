<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if( $this->command->confirm('Do You Wont To Refresh DataBase') ){
            $this->command->call('migrate:refresh') ;
            $this->command->info('DataBase Was Refreshed');
        }

        // \App\Models\User::factory(10)->create();

        // $book = Book::factory(25)->create();
        
        // Review::factory()->count(150)->make()->each(function( $review ) use($book){
        //     $review->book_id = $book->random()->id ;
        //     $review->save();
        // });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Book::factory()->count(33)->create()->each(function( $book ){

            Review::factory()->count( random_int(5 , 30) )->good()->for($book)->create();

        });

        Book::factory()->count(34)->create()->each(function( $book ){

            Review::factory()->count( random_int(5 , 30) )->average()->for($book)->create();
            
        });

        Book::factory()->count(33)->create()->each(function( $book ){

            Review::factory()->count( random_int(5 , 30) )->bad()->for($book)->create();
            
        });

    }
}
