<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Autenticar um usuário para os testes de API
     */
    protected function autenticarUsuario()
    {
        $user = User::create([
            'name' => 'Usuário de Teste',
            'email' => 'teste@exemplo.com',
            'password' => bcrypt('senha123'),
        ]);

        Sanctum::actingAs($user);
        
        return $user;
    }
}
