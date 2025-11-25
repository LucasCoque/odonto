<?php

    namespace App\Helpers;

    class ValidationHelper{

        public static function h($string){   
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }

     public static function validaCpf(string $cpf): bool
    {
        // 1. Remove caracteres não numéricos (garante que só dígitos fiquem).
        // Isso atende ao seu requisito de validação de CPF "sem letras, espaço em branco 
        // ou qualquer outro tipo de caracter" ao limpar a entrada.
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // 2. Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // 3. Verifica se todos os dígitos são iguais (ex: 111.111.111-11) - Inválido
        // O ponto de interrogação ? torna o quantificador preguiçoso
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        // --- Lógica de cálculo dos Dígitos Verificadores (DV) ---

        // 4. Calcula o primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int)$cpf[$i] * (10 - $i);
        }
        $primeiroDigitoVerificador = (($soma % 11) < 2) ? 0 : 11 - ($soma % 11);

        // 5. Verifica o primeiro dígito
        if ((int)$cpf[9] != $primeiroDigitoVerificador) {
            return false;
        }

        // 6. Calcula o segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int)$cpf[$i] * (11 - $i);
        }
        $segundoDigitoVerificador = (($soma % 11) < 2) ? 0 : 11 - ($soma % 11);

        // 7. Verifica o segundo dígito
        if ((int)$cpf[10] != $segundoDigitoVerificador) {
            return false;
        }

        // 8. Se passou em todas as verificações, o CPF é válido
        return true;
    }


        public static function validaCelular($celular){
            // Elimina possivel mascara
            $celular = preg_replace( '/[^0-9]/is', '', $celular );

            // Verifica se o numero de digitos informados é igual a 11 
            if (strlen($celular) != 11) {
                return false;
            }
            return true;
        }
    

    public function validaTelefone($telefone){
        // Elimina possivel mascara
        $telefone = preg_replace( '/[^0-9]/is', '', $telefone );

        // Verifica se o numero de digitos informados é igual a 10 
        if (strlen($telefone) != 10) {
            return false;
        }
        return true;
    }

    public function validaEmail($email){
        // Verifica se o email é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function validaDataNascimento($data){
        // Verifica se a data está no formato YYYY-MM-DD
        $d = DateTime::createFromFormat('Y-m-d', $data);
        if (!($d && $d->format('Y-m-d') === $data)) {
            return false;
        }
        return true;
    }
    public function validaNome($nome){
        // Verifica se o nome não está vazio e tem pelo menos 3 caracteres
        if (empty($nome) || strlen($nome) < 3) {
            return false;
        }
        return true;
    }
}

?>


