<?php
/**
 * View: patient_form.php
 * Exibe o formulário de cadastro de pacientes.
 * @param string $flash Mensagem de alerta (sucesso/erro).
 * @param array $data Dados antigos do formulário.
 */

// Extrai variáveis para uso direto no template, aplicando sanitização
$name = App\Helpers\ValidationHelper::h($data['name'] ?? '');
$birth = App\Helpers\ValidationHelper::h($data['birth'] ?? '');
$phone = App\Helpers\ValidationHelper::h($data['phone'] ?? '');
$cell = App\Helpers\ValidationHelper::h($data['cell'] ?? '');
$email = App\Helpers\ValidationHelper::h($data['email'] ?? '');
$cpf = App\Helpers\ValidationHelper::h($data['cpf'] ?? '');

?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Pacientes</title>
        <!-- Agora linkamos o CSS externo -->
        <style>
    body {
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        margin: 2rem;
        background-color: #fff;
        color: #1d1d1f;
    }
    .container {
        max-width: 640px;
        margin: 0 auto;
    }
    h1 {
        margin-bottom: 0.5rem;
        font-size: 2rem;
        font-weight: 600;
        letter-spacing: -0.02em;
    }
    p.desc {
        color: #555;
        margin-top: 0;
        font-size: 1rem;
    }
    form {
        display: grid;
        gap: 12px;
        margin-top: 16px;
    }
    label {
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
        font-size: 0.95rem;
    }
    input[type="text"],
    input[type="date"],
    input[type="email"],
    input[type="tel"],
    select {
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid #d2d2d7;
        background-color: #f5f5f7;
        font-size: 1rem;
        width: 100%;
        transition: 0.2s border-color ease;
    }
    input:focus,
    select:focus {
        outline: none;
        border-color: #0071e3;
        background-color: #fff;
    }
    button {
        margin-top: 10px;
        background-color: #0071e3;
        color: #fff;
        border: none;
        padding: 12px 18px;
        border-radius: 12px;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.2s background-color ease;
    }
    button:hover {
        background-color: #0360c7;
    }
    .error {
        color: #d70015;
        font-size: 0.9rem;
        margin-top: -8px;
        margin-bottom: 8px;
    }
    .success {
        color: #008009;
        font-size: 0.9rem;
        margin-top: -8px;
        margin-bottom: 8px;
    }
</style> 
    </head>
<body>
<div class="container">
    <h1>Cadastro de Pacientes</h1>
    <p class="desc">Preencha seus dados para contato e agendamento.</p>

    <?= $flash ?>

    <form method="post" action="/patients" novalidate>
        <div><label for="name">Nome completo *</label><input type="text" id="name" name="name" value="<?= $name ?>" required></div>
        <div><label for="cpf">CPF *</label><input type="text" id="cpf" name="cpf" value="<?= $cpf ?>" placeholder="Somente números"></div>
        <div><label for="birth_date">Data de nascimento</label><input type="date" id="birth_date" name="birth_date" value="<?= $birth ?>" placeholder="YYYY-MM-DD"></div>
        <div class="row">
            <div><label for="phone">Telefone (fixo)</label><input type="tel" id="phone" name="phone" value="<?= $phone ?>" placeholder="DDD + número"></div>
            <div><label for="cellphone">Celular</label><input type="tel" id="cellphone" name="cellphone" value="<?= $cell ?>" placeholder="DDD + número"></div>
        </div>
        <div><label for="email">E-mail</label><input type="email" id="email" name="email" value="<?= $email ?>" placeholder="voce@exemplo.com"></div>
        
        <div><button class="primary" type="submit">Enviar cadastro</button></div>
        
        <p class="muted"><small class="hint">Ao enviar, você concorda com o uso dos seus dados para contato e agendamento.</small></p>
    </form>
    
    <p class="muted">Endpoints: <code>/health</code> • <code>/db-check</code> • <code>POST /patients</code></p>
</div>
</body>
</html>
