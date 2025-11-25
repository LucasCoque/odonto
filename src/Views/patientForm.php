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
        <link rel="stylesheet" href="style.css">
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