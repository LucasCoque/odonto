<?php

    namespace App\Helpers;

    class ValidationHelper{

        public static function h($string){   
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }

    public static function validaCpf(string $cpf): bool {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
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


