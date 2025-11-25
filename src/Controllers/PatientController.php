<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\PatientModel;
use App\Helpers\ValidationHelper;
use Throwable;

class PatientController
{
    private PatientModel $model;

    public function __construct(PatientModel $model)
    {
        $this->model = $model;
    }

    /**
     * Renderiza o formulário de cadastro.
     * @param string $flash Mensagem de flash (alerta).
     * @param array $old_data Dados pré-preenchidos.
     */
    public function showForm(string $flash = '', array $old_data = []): void
    {
        // Usa ob_start/ob_get_clean para capturar o output da view
        ob_start();
        $data = $old_data;
        $flash = $flash;
        require __DIR__ . '/../Views/patientForm.php';
        echo ob_get_clean();
    }

    /**
     * Processa a submissão do formulário POST.
     */
    public function store(): void
    {
        $data = [
            'name'  => trim($_POST['name'] ?? ''),
            'birth' => trim($_POST['birth_date'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'cell'  => trim($_POST['cellphone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'cpf'   => trim($_POST['cpf'] ?? ''),
        ];

        $errors = $this->validate($data);

        if ($errors) {
            $msg = '<div class="alert error"><strong>Erro:</strong><ul><li>' .
                   implode('</li><li>', array_map('App\Helpers\ValidationHelper::h', $errors)) .
                   '</li></ul></div>';
            
            $this->showForm($msg, $data);
            return;
        }

        try {
            $this->model->save($data);
            $this->showForm('<div class="alert success">Paciente cadastrado com sucesso.</div>');
        } catch (Throwable $e) {
            $error_msg = '<div class="alert error"><strong>Erro ao salvar:</strong> ' . ValidationHelper::h($e->getMessage()) . '</div>';
            $this->showForm($error_msg, $data);
        }
    }

    /**
     * Executa as regras de validação.
     */
    private function validate(array $data): array
    {
        $err = [];
        
        $name = $data['name'];
        $email = $data['email'];
        $cpf = $data['cpf'];
        $phone = $data['phone'];
        $cell = $data['cell'];
        $birth = $data['birth'];

        // 1. Nome
        if (mb_strlen($name) < 3) $err[] = 'Nome deve ter ao menos 3 caracteres.';
        
        // 2. E-mail
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $err[] = 'E-mail inválido.';
        
        // 3. CPF
        if ($cpf !== '' && !ValidationHelper::validarCPF($cpf)) $err[] = 'CPF inválido.';
        
        // 4. Telefone
        $phone_clean = preg_replace('/\D/', '', $phone);
        if ($phone !== '' && !preg_match('/^\d{10,11}$/', $phone_clean)) $err[] = 'Telefone inválido.';
        
        // 5. Celular
        $cell_clean = preg_replace('/\D/', '', $cell);
        if ($cell !== '' && !preg_match('/^\d{10,11}$/', $cell_clean)) $err[] = 'Celular inválido.';
        
        // 6. Data de Nascimento
        if ($birth !== '') {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth)) {
                $err[] = 'Data de nascimento no formato incorreto (use YYYY-MM-DD).';
            } elseif (strtotime($birth) > time()) {
                $err[] = 'Data de nascimento não pode ser no futuro.';
            }
        }
        
        return $err;
    }
}
