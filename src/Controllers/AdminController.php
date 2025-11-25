<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Db;
use Throwable;

class AdminController
{
    // --- Métodos de View/Renderização ---

    /**
     * Renderiza uma view específica da área administrativa.
     * @param string $view_name Nome do arquivo PHP da view (ex: 'admin_login').
     * @param array $data Dados a serem passados para a view (ex: $data['error']).
     */
    private function renderView(string $view_name, array $data = []): void
    {
        ob_start();
        extract($data); // Torna as chaves do array $data em variáveis locais (ex: $error, $rows)
        require __DIR__ . "/../Views/{$view_name}.php";
        echo ob_get_clean();
    }

    // --- Ações do Controller ---

    /**
     * Exibe o formulário de login e processa a submissão POST.
     * Rota: /admin/login
     */
    public function login(): void
    {
        Auth::startSession();
        $error = '';
        
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $u = trim($_POST['username'] ?? '');
            $p = trim($_POST['password'] ?? '');

            if ($u !== '' && $p !== '' && Auth::login($u, $p)) {
                // Redireciona via Front Controller
                header('Location: /admin/patients'); 
                exit;
            }
            $error = 'Usuário ou senha inválidos.';
        }

        $this->renderView('admin_login', ['error' => $error]);
    }

    /**
     * Processa o logout.
     * Rota: /admin/logout
     */
    public function logout(): void
    {
        Auth::startSession();
        Auth::logout();
        // Redireciona para a rota de login via Front Controller
        header('Location: /admin/login');
        exit;
    }

    /**
     * Exibe a listagem de pacientes (requer login).
     * Rota: /admin/patients
     */
    public function showPatients(): void
    {
        Auth::startSession();
        Auth::requireLogin(); // Verifica se o usuário está logado
        
        try {
            $pdo = Db::conn();
            $st = $pdo->query('SELECT id, name, birth_date, phone, cellphone, email FROM patients ORDER BY id DESC LIMIT 100');
            $rows = $st->fetchAll();
            $this->renderView('admin_patients', ['rows' => $rows]);
        } catch (Throwable $e) {
            // Em um sistema real, você registraria isso. Aqui, apenas mostraremos um erro.
            $this->renderView('admin_error', ['message' => 'Erro ao carregar dados: ' . $e->getMessage()]);
        }
    }
}