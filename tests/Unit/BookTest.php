<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Tests\TestCase;

class BookTest extends TestCase
{
    /** @test */
    public function it_can_create_a_book()
    {
        $author = Author::create([
            'name' => 'Machado de Assis',
            'birthdate' => '1839-06-21',
            'nationality' => 'Brasileiro'
        ]);

        $bookData = [
            'title' => 'Dom Casmurro',
            'isbn' => '9788535910663',
            'publication_date' => '1899-01-01',
            'author_id' => $author->id
        ];

        $book = Book::create($bookData);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals($bookData['title'], $book->title);
        $this->assertEquals($bookData['isbn'], $book->isbn);
        $this->assertEquals($bookData['publication_date'], $book->publication_date);
        $this->assertEquals($author->id, $book->author_id);
    }

    /** @test */
    public function it_belongs_to_an_author()
    {
        $author = Author::create([
            'name' => 'Clarice Lispector',
            'birthdate' => '1920-12-10',
            'nationality' => 'Brasileira'
        ]);

        $book = Book::create([
            'title' => 'A Hora da Estrela',
            'isbn' => '9788535910670',
            'publication_date' => '1977-01-01',
            'author_id' => $author->id
        ]);

        $this->assertInstanceOf(Author::class, $book->author);
        $this->assertEquals($author->id, $book->author->id);
        $this->assertEquals($author->name, $book->author->name);
    }
} 