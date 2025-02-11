<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE tasks SET title=?, description=?, due_date=?, priority=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['priority'], $_POST['id']])) {
        echo "Task updated successfully!";
    } else {
        echo "Failed to update task.";
    }
}
?>