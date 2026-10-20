<?php
header('Content-Type: application/json');
require_once 'db.php';

// Read JSON payload sent from JS fetch()
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input) {
    $total = $input['total'] ?? 0;
    $cartItems = $input['cart'] ?? [];

    if (empty($cartItems) || $total <= 0) {
        echo json_encode(["success" => false, "message" => "Your cart is empty."]);
        exit;
    }

    // Convert items array to JSON string for storage
    $orderDetailsJson = json_encode($cartItems);
    $customerName = "Guest Customer"; 

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, total_amount, order_details) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $customerName, $total, $orderDetailsJson);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true, 
            "message" => "Order successfully placed!", 
            "order_id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to process order."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request format."]);
}
?>