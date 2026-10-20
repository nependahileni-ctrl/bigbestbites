<?php
require_once 'db.php'; // or dp.php depending on what you named it

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if fields exist and are not empty
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $message = trim($_POST['message']);

        if (!empty($name) && !empty($email) && !empty($message)) {
            $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $message);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Thank you for your feedback!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error: Could not save feedback.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing form data.']);
    }
}
?>