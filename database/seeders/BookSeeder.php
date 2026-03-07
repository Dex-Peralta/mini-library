<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove books without cover images
        Book::whereNull('cover_image')->delete();
        
        // Create Authors first
        $authors = [
            ['name' => 'Jane Austen'],
            ['name' => 'George Orwell'],
            ['name' => 'J.K. Rowling'],
            ['name' => 'F. Scott Fitzgerald'],
            ['name' => 'Harper Lee'],
            ['name' => 'J.R.R. Tolkien'],
            ['name' => 'Agatha Christie'],
            ['name' => 'Stephen King'],
            ['name' => 'Paulo Coelho'],
            ['name' => 'Dan Brown'],
            ['name' => 'Gabriel García Márquez'],
            ['name' => 'Ernest Hemingway'],
            ['name' => 'Mark Twain'],
            ['name' => 'Charles Dickens'],
            ['name' => 'Leo Tolstoy'],
            ['name' => 'Victor Hugo'],
            ['name' => 'Oscar Wilde'],
        ];

        foreach ($authors as $authorData) {
            Author::firstOrCreate(['name' => $authorData['name']]);
        }

        // Create Books with cover images (15+ books)
        $books = [
            [
                'title' => 'Pride and Prejudice',
                'description' => 'A romantic novel of manners that follows the character development of Elizabeth Bennet, the protagonist of the book.',
                'year_published' => 1813,
                'genre' => 'Romance',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8235557-L.jpg',
                'authors' => ['Jane Austen']
            ],
            [
                'title' => '1984',
                'description' => 'A dystopian social science fiction novel that follows the life of Winston Smith, a low-ranking member of ruling party.',
                'year_published' => 1949,
                'genre' => 'Science Fiction',
                'inventory_count' => 3,
                'cover_image' => 'https://covers.openlibrary.org/b/id/7222246-L.jpg',
                'authors' => ['George Orwell']
            ],
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'description' => 'The first novel in the Harry Potter series, following a young wizard\'s journey.',
                'year_published' => 1997,
                'genre' => 'Fantasy',
                'inventory_count' => 8,
                'cover_image' => 'https://covers.openlibrary.org/b/id/10521270-L.jpg',
                'authors' => ['J.K. Rowling']
            ],
            [
                'title' => 'The Great Gatsby',
                'description' => 'A tragic love story on Long Island in the 1920s, about the impossible love between a man and a woman.',
                'year_published' => 1925,
                'genre' => 'Classic',
                'inventory_count' => 4,
                'cover_image' => 'https://covers.openlibrary.org/b/id/7222339-L.jpg',
                'authors' => ['F. Scott Fitzgerald']
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'description' => 'A gripping, heart-wrenching, and wholly remarkable tale of coming-of-age in a South poisoned by virulent prejudice.',
                'year_published' => 1960,
                'genre' => 'Classic',
                'inventory_count' => 6,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8231799-L.jpg',
                'authors' => ['Harper Lee']
            ],
            [
                'title' => 'The Lord of the Rings',
                'description' => 'An epic high-fantasy novel that tells the story of the quest to destroy the One Ring.',
                'year_published' => 1954,
                'genre' => 'Fantasy',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/9255566-L.jpg',
                'authors' => ['J.R.R. Tolkien']
            ],
            [
                'title' => 'Murder on the Orient Express',
                'description' => 'A detective novel featuring Hercule Poirot investigating a murder on the famous train.',
                'year_published' => 1934,
                'genre' => 'Mystery',
                'inventory_count' => 4,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8231357-L.jpg',
                'authors' => ['Agatha Christie']
            ],
            [
                'title' => 'The Shining',
                'description' => 'A horror novel about a family trapped in an isolated hotel for the winter.',
                'year_published' => 1977,
                'genre' => 'Horror',
                'inventory_count' => 3,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8338390-L.jpg',
                'authors' => ['Stephen King']
            ],
            [
                'title' => 'The Alchemist',
                'description' => 'A philosophical book that tells the story of a young Andalusian shepherd on a journey to find treasure.',
                'year_published' => 1988,
                'genre' => 'Fiction',
                'inventory_count' => 7,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8739161-L.jpg',
                'authors' => ['Paulo Coelho']
            ],
            [
                'title' => 'The Da Vinci Code',
                'description' => 'A mystery thriller novel that follows symbologist Robert Langdon as he investigates a murder.',
                'year_published' => 2003,
                'genre' => 'Mystery',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8246166-L.jpg',
                'authors' => ['Dan Brown']
            ],
            [
                'title' => 'One Hundred Years of Solitude',
                'description' => 'The story of the Buendía family over seven generations in the fictional town of Macondo.',
                'year_published' => 1967,
                'genre' => 'Magical Realism',
                'inventory_count' => 4,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8232989-L.jpg',
                'authors' => ['Gabriel García Márquez']
            ],
            [
                'title' => 'The Old Man and the Sea',
                'description' => 'The story of an aging Cuban fisherman who struggles with a giant marlin far out in the Gulf Stream.',
                'year_published' => 1952,
                'genre' => 'Fiction',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/7884772-L.jpg',
                'authors' => ['Ernest Hemingway']
            ],
            [
                'title' => 'The Adventures of Huckleberry Finn',
                'description' => 'A novel about a young boy\'s adventures along the Mississippi River.',
                'year_published' => 1884,
                'genre' => 'Adventure',
                'inventory_count' => 6,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8336857-L.jpg',
                'authors' => ['Mark Twain']
            ],
            [
                'title' => 'A Tale of Two Cities',
                'description' => 'A historical novel set in London and Paris before and during the French Revolution.',
                'year_published' => 1859,
                'genre' => 'Historical Fiction',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8225280-L.jpg',
                'authors' => ['Charles Dickens']
            ],
            [
                'title' => 'War and Peace',
                'description' => 'A literary work mixed with chapters on history and philosophy regarding the Napoleonic era.',
                'year_published' => 1869,
                'genre' => 'Historical Fiction',
                'inventory_count' => 3,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8231758-L.jpg',
                'authors' => ['Leo Tolstoy']
            ],
            [
                'title' => 'Les Misérables',
                'description' => 'A French historical novel that follows the lives and interactions of several characters over a twenty-year period.',
                'year_published' => 1862,
                'genre' => 'Historical Fiction',
                'inventory_count' => 4,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8232366-L.jpg',
                'authors' => ['Victor Hugo']
            ],
            [
                'title' => 'The Picture of Dorian Gray',
                'description' => 'A philosophical novel about a young man who sells his soul for eternal youth and beauty.',
                'year_published' => 1890,
                'genre' => 'Gothic Fiction',
                'inventory_count' => 5,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8282726-L.jpg',
                'authors' => ['Oscar Wilde']
            ],
            [
                'title' => 'Animal Farm',
                'description' => 'An allegorical novella reflecting events leading up to the Russian Revolution and the Stalinist era.',
                'year_published' => 1945,
                'genre' => 'Political Satire',
                'inventory_count' => 6,
                'cover_image' => 'https://covers.openlibrary.org/b/id/8234990-L.jpg',
                'authors' => ['George Orwell']
            ],
        ];

        foreach ($books as $bookData) {
            $authorNames = $bookData['authors'];
            unset($bookData['authors']);

            $book = Book::firstOrCreate(
                ['title' => $bookData['title']],
                $bookData
            );

            // Attach authors
            foreach ($authorNames as $authorName) {
                $author = Author::where('name', $authorName)->first();
                if ($author && !$book->authors->contains($author->id)) {
                    $book->authors()->attach($author->id);
                }
            }
        }

        $this->command->info('Books seeded successfully with cover images! Total: ' . count($books) . ' books');
    }
}
