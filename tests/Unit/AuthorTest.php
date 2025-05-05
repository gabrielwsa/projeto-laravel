<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    /** @test */
    public function it_can_create_an_author()
    {
        $authorData = [
            'name' => 'Gabriel García Márquez',
            'birthdate' => '1927-03-06',
            'nationality' => 'Colombiano'
        ];

        $author = Author::create($authorData);

        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals($authorData['name'], $author->name);
        $this->assertEquals($authorData['birthdate'], $author->birthdate);
        $this->assertEquals($authorData['nationality'], $author->nationality);
    }

    /** @test */
    public function it_has_many_books()
    {
        $author = Author::create([
            'name' => 'José Saramago',
            'birthdate' => '1922-11-16',
            'nationality' => 'Português'
        ]);

        Book::create([
            'title' => 'Ensaio sobre a Cegueira',
            'isbn' => '9788535904802',
            'publication_date' => '1995-01-01',
            'author_id' => $author->id
        ]);

        Book::create([
            'title' => 'O Ano da Morte de Ricardo Reis',
            'isbn' => '9788535904819',
            'publication_date' => '1984-01-01',
            'author_id' => $author->id
        ]);

        $this->assertCount(2, $author->books);
        $this->assertInstanceOf(Book::class, $author->books->first());
    }
} 