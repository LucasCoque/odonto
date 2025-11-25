<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Health;
use App\Db;
use App\Controllers\PatientController;
use App\Models\PatientsModel;

// --- Funções Auxiliares (mantidas aqui para endpoints de API) ---

function json_out($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// --- Roteamento Principal ---

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Endpoints de API (permanecem aqui no Front Controller)
if ($method === 'GET' && $path === '/health') {
    json_out(Health::status() + ['ts' => gmdate('c')]);
}

if ($method === 'GET' && $path === '/db-check') {
    try {
        $pdo = Db::conn();
        $one = $pdo->query('SELECT 1 AS ok')->fetch();
        json_out(['db' => 'ok', 'result' => $one]);
    } catch (Throwable $e) {
        json_out(['db' => 'error', 'message' => $e->getMessage()], 500);
    }
}

// Inicialização do Controller (Injeção de Dependência simples)
$patientModel = new PatientModel();
$patientController = new PatientController($patientModel);

// Rota: GET / (Mostrar formulário)
if ($method === 'GET' && $path === '/') {
    $patientController->showForm();
    exit;
}

// Rota: POST /patients (Processar cadastro)
if ($method === 'POST' && $path === '/patients') {
    $patientController->store();
    exit;
}

// 404
http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo "Not Found";