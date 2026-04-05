<?php
// membership-ajax-handler.php
// Robust testing handler for membership modal submissions.
// - Accepts form-data or JSON body
// - Handles OPTIONS for CORS during local testing
// - Sanitizes fields before logging (removes newlines and pipe chars)

// Allow cross-origin during local development (remove or lock this down in production)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'OPTIONS') {
    // Preflight request for CORS
    http_response_code(204);
    exit;
}

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Only POST allowed']);
    exit;
}

// Read input (support JSON payloads as well as form-data)
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$data = [];
if (stripos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $data = $decoded;
} else {
    $data = $_POST;
}

$inst = trim($data['instName'] ?? '');
$contact = trim($data['contactName'] ?? '');
$email = trim($data['contactEmail'] ?? '');
$phone = trim($data['contactPhone'] ?? '');
$plan = trim($data['plan'] ?? '');

$errors = [];
if ($inst === '') $errors[] = 'Institution name is required';
if ($contact === '') $errors[] = 'Contact name is required';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'errors' => $errors]);
    exit;
}

// Sanitize fields for log (remove CR/LF and pipe to keep single-line, pipe-delimited log safe)
$sanitize = function ($s) {
    $s = (string)$s;
    $s = str_replace(["\r", "\n", "|"], [' ', ' ', ' '], $s);
    $s = trim($s);
    return $s;
};

$plan_s = $sanitize($plan);
$inst_s = $sanitize($inst);
$contact_s = $sanitize($contact);
$email_s = $sanitize($email);
$phone_s = $sanitize($phone);

// For smoke-test: append submission to a log file (non-sensitive minimal info)
$logFile = __DIR__ . '/membership-submissions.log';
$logLine = date('Y-m-d H:i:s') . "\t" . implode('|', [$plan_s, $inst_s, $contact_s, $email_s, $phone_s]) . "\n";
@file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

// Respond with success and echo back a friendly message
echo json_encode(['ok' => true, 'message' => 'Application received', 'redirect' => 'membershipapplication.php?submitted=1']);
exit;

?>

