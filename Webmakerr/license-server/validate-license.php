<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$licenseFile = __DIR__.'/license.json';

$response = static function (array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
};

if (! is_file($licenseFile)) {
    $response([
        'status'  => 'error',
        'message' => 'License store is missing.',
        'license_status' => 'invalid',
    ], 500);
}

$rawData = file_get_contents('php://input');
$decodedInput = [];

if ($rawData !== false && $rawData !== '') {
    $decoded = json_decode($rawData, true);

    if (is_array($decoded)) {
        $decodedInput = $decoded;
    }
}

$licenseKey = '';

$possibleSources = [
    $decodedInput['license_key'] ?? null,
    $_POST['license_key'] ?? null,
    $_POST['key'] ?? null,
    $_GET['license_key'] ?? null,
    $_GET['key'] ?? null,
];

foreach ($possibleSources as $value) {
    if (is_string($value) && trim($value) !== '') {
        $licenseKey = trim($value);
        break;
    }
}

if ($licenseKey === '') {
    $response([
        'status'  => 'error',
        'message' => 'Please supply a license key to validate.',
        'license_status' => 'invalid',
    ], 400);
}

$fileContents = file_get_contents($licenseFile);

if ($fileContents === false) {
    $response([
        'status'  => 'error',
        'message' => 'Unable to read the license store.',
        'license_status' => 'invalid',
    ], 500);
}

$data = json_decode($fileContents, true);

if (! is_array($data) || ! isset($data['licenses']) || ! is_array($data['licenses'])) {
    $response([
        'status'  => 'error',
        'message' => 'License store is malformed.',
        'license_status' => 'invalid',
    ], 500);
}

$normalizedLicenses = array_map(static fn ($value) => is_string($value) ? trim($value) : '', $data['licenses']);
$normalizedLicenses = array_filter($normalizedLicenses, static fn ($value) => $value !== '');

if (in_array($licenseKey, $normalizedLicenses, true)) {
    $response([
        'status'         => 'success',
        'message'        => 'License activated successfully',
        'license_status' => 'active',
    ]);
}

$response([
    'status'         => 'error',
    'message'        => 'Invalid license key',
    'license_status' => 'invalid',
], 400);
