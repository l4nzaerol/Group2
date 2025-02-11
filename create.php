<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO tasks (title, description, due_date, priority) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['priority']])) {
        echo "Task created successfully!";
    } else {
        echo "Failed to create task.";
    }
}
?>
