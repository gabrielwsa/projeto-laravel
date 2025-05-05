<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    /** @test */
    public function it_can_list_authors()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar alguns autores no banco de dados
        Author::create([
            'name' => 'Fernando Pessoa',
            'birthdate' => '1888-06-13',
            'nationality' => 'Português'
        ]);

        Author::create([
            'name' => 'Carlos Drummond de Andrade',
            'birthdate' => '1902-10-31',
            'nationality' => 'Brasileiro'
        ]);

        // Fazer uma requisição GET para a API de autores
        $response = $this->getJson('/api/authors');

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verifica se os dados retornados estão na estrutura correta - neste caso vem como {"authors": [array de autores]}
        $this->assertArrayHasKey('authors', $response->json());
        $this->assertCount(2, $response->json('authors'));
    }

    /** @test */
    public function it_can_create_an_author()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        $authorData = [
            'name' => 'Cecília Meireles',
            'birthdate' => '1901-11-07',
            'nationality' => 'Brasileira'
        ];

        // Fazer uma requisição POST para criar um autor
        $response = $this->postJson('/api/authors', $authorData);

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verifica se a resposta tem o formato esperado
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('author', $response->json());
        
        // Verificar se o autor foi criado no banco de dados
        $this->assertDatabaseHas('authors', $authorData);
    }

    /** @test */
    public function it_can_show_an_author()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor no banco de dados
        $author = Author::create([
            'name' => 'Lygia Fagundes Telles',
            'birthdate' => '1923-04-19',
            'nationality' => 'Brasileira'
        ]);

        // Fazer uma requisição GET para mostrar o autor
        $response = $this->getJson("/api/authors/{$author->id}");

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se retorna a estrutura esperada
        $this->assertArrayHasKey('author', $response->json());
    }

    /** @test */
    public function it_can_update_an_author()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor no banco de dados
        $author = Author::create([
            'name' => 'Rachel de Queiroz',
            'birthdate' => '1910-11-17',
            'nationality' => 'Brasileira'
        ]);

        $updateData = [
            'name' => 'Rachel de Queiroz (Atualizado)',
            'birthdate' => '1910-11-17',
            'nationality' => 'Brasileira'
        ];

        // Fazer uma requisição PUT para atualizar o autor
        $response = $this->putJson("/api/authors/{$author->id}", $updateData);

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a resposta tem a estrutura esperada
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('author', $response->json());

        // Verificar se o autor foi atualizado no banco de dados
        $this->assertDatabaseHas('authors', $updateData);
    }

    /** @test */
    public function it_can_delete_an_author()
    {
        // Autenticar o usuário
        $this->autenticarUsuario();
        
        // Criar um autor no banco de dados
        $author = Author::create([
            'name' => 'Graciliano Ramos',
            'birthdate' => '1892-10-27',
            'nationality' => 'Brasileiro'
        ]);

        // Fazer uma requisição DELETE para remover o autor
        $response = $this->deleteJson("/api/authors/{$author->id}");

        // Verificar se a resposta é bem-sucedida
        $response->assertStatus(200);
        
        // Verificar se a mensagem de sucesso existe
        $this->assertArrayHasKey('message', $response->json());

        // Verificar se o autor foi removido do banco de dados
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
} 