<?php
declare(strict_types=1);

namespace App\Models;

use App\Db;
use PDO;
use Throwable;

class PatientModel
{
    /**
     * Salva os dados de um novo paciente no banco de dados.
     * @param array $data Dados do paciente.
     * @throws Throwable Se a inserção falhar.
     */
    public function save(array $data): void
    {
        $pdo = Db::conn(); // Conexão com o banco (assumindo que App\Db existe)
        
        $st = $pdo->prepare('INSERT INTO patients (name, birth_date, phone, cellphone, email, cpf) VALUES (:n,:b,:p,:c,:e,:cpf)');
        
        $st->execute([
            ':n'   => $data['name'] ?? null,
            ':b'   => $data['birth'] ?? null,
            ':p'   => $data['phone'] ?? null,
            ':c'   => $data['cell'] ?? null,
            ':e'   => $data['email'] ?? null,
            ':cpf' => $data['cpf'] ?? null,
        ]);
    }
}
