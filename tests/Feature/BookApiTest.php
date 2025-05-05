<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_books()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor
        $author = Author::create([
            'name' => 'Jorge Amado',
            'birthdate' => '1912-08-10',
            'nationality' => 'Brasileiro'
        ]);

        // Criar alguns livros
        Book::create([
            'title' => 'Capitães da Areia',
            'isbn' => '9788535911091',
            'publication_date' => '1937-01-01',
            'author_id' => $author->id
        ]);

        Book::create([
            'title' => 'Gabriela, Cravo e Canela',
            'isbn' => '9788535911107',
            'publication_date' => '1958-01-01',
            'author_id' => $author->id
        ]);

        // Fazer uma requisição GET para a API de livros
        $response = $this->getJson('/api/books');

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a resposta tem a estrutura esperada
        $this->assertArrayHasKey('books', $response->json());
        $this->assertCount(2, $response->json('books'));
    }

    /** @test */
    public function it_can_create_a_book()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor
        $author = Author::create([
            'name' => 'Érico Veríssimo',
            'birthdate' => '1905-12-17',
            'nationality' => 'Brasileiro'
        ]);

        $bookData = [
            'title' => 'O Tempo e o Vento',
            'isbn' => '9788535911114',
            'publication_date' => '1949-01-01',
            'author_id' => $author->id
        ];

        // Fazer uma requisição POST para criar um livro
        $response = $this->postJson('/api/books', $bookData);

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a resposta tem a estrutura esperada
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('book', $response->json());

        // Verificar se o livro foi criado no banco de dados
        $this->assertDatabaseHas('books', $bookData);
    }

    /** @test */
    public function it_can_show_a_book()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor
        $author = Author::create([
            'name' => 'Lima Barreto',
            'birthdate' => '1881-05-13',
            'nationality' => 'Brasileiro'
        ]);

        // Criar um livro
        $book = Book::create([
            'title' => 'Triste Fim de Policarpo Quaresma',
            'isbn' => '9788535911121',
            'publication_date' => '1915-01-01',
            'author_id' => $author->id
        ]);

        // Fazer uma requisição GET para mostrar o livro
        $response = $this->getJson("/api/books/{$book->id}");

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se retorna a estrutura esperada
        $this->assertArrayHasKey('book', $response->json());
        $this->assertArrayHasKey('author', $response->json());
    }

    /** @test */
    public function it_can_update_a_book()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor
        $author = Author::create([
            'name' => 'Mário de Andrade',
            'birthdate' => '1893-10-09',
            'nationality' => 'Brasileiro'
        ]);

        // Criar um livro
        $book = Book::create([
            'title' => 'Macunaíma',
            'isbn' => '9788535911138',
            'publication_date' => '1928-01-01',
            'author_id' => $author->id
        ]);

        $updateData = [
            'title' => 'Macunaíma: O Herói sem Nenhum Caráter',
            'isbn' => '9788535911138',
            'publication_date' => '1928-01-01',
            'author_id' => $author->id
        ];

        // Fazer uma requisição PUT para atualizar o livro
        $response = $this->putJson("/api/books/{$book->id}", $updateData);

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a resposta tem a estrutura esperada
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('book', $response->json());

        // Verificar se o livro foi atualizado no banco de dados
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $updateData['title']
        ]);
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor
        $author = Author::create([
            'name' => 'José de Alencar',
            'birthdate' => '1829-05-01',
            'nationality' => 'Brasileiro'
        ]);

        // Criar um livro
        $book = Book::create([
            'title' => 'Iracema',
            'isbn' => '9788535911145',
            'publication_date' => '1865-01-01',
            'author_id' => $author->id
        ]);

        // Fazer uma requisição DELETE para remover o livro
        $response = $this->deleteJson("/api/books/{$book->id}");

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a mensagem de sucesso existe
        $this->assertArrayHasKey('message', $response->json());

        // Verificar se o livro foi removido do banco de dados
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
} 