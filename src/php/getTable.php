<?php
header('Content-Type: application/json');

try {
    $db = new PDO("mysql:host=db;dbname=TestInterview", "root", "example");
    $stmt = $db->query("SELECT * FROM calculation ORDER BY created_at DESC");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $results
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}