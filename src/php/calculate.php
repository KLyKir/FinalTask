<?php
header('Content-Type: application/json');
require 'classes/Calculator.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $number = filter_var($_POST['number'], FILTER_VALIDATE_INT);
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    if ($username && $number !== false && $number >= 0) {
        $calculator = new Calculator();
        $fibonacciResult = $calculator->calculate_fibonacci($number);

        try {
            $db = new PDO("mysql:host=db;dbname=TestInterview", "root", "example");

            $stmt = $db->prepare("INSERT INTO Calculation (username, number, fibonacci_result, ip_address)
                                  VALUES (:username, :number, :fibonacci_result, :ip_address)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':fibonacci_result', $fibonacciResult);
            $stmt->bindParam(':ip_address', $ipAddress);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'username' => $username,
                'number' => $number,
                'fibonacci_result' => $fibonacciResult,
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
