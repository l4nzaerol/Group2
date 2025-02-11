<?php
require 'db.php';

// Fetch tasks from the database
$sql = "SELECT * FROM tasks ORDER BY due_date ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Task Management System</h2>

        <!-- Add Task Form -->
        <div class="card p-4 mt-4">
            <h4>Add New Task</h4>
            <form id="taskForm">
                <div class="mb-3">
                    <label>Title:</label>
                    <input type="text" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description:</label>
                    <textarea id="description" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Due Date:</label>
                    <input type="date" id="due_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Priority:</label>
                    <select id="priority" class="form-select">
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Task</button>
            </form>
        </div>

        <!-- Task List -->
        <div class="mt-4">
            <h4>Task List</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="taskTable">
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']) ?></td>
                        <td><?= htmlspecialchars($task['description']) ?></td>
                        <td><?= htmlspecialchars($task['due_date']) ?></td>
                        <td><?= htmlspecialchars($task['priority']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editTask" data-id="<?= $task['id'] ?>" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-danger btn-sm deleteTask" data-id="<?= $task['id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm">
                        <input type="hidden" id="editTaskId">
                        <div class="mb-3">
                            <label>Title:</label>
                            <input type="text" id="editTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description:</label>
                            <textarea id="editDescription" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Due Date:</label>
                            <input type="date" id="editDueDate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Priority:</label>
                            <select id="editPriority" class="form-select">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Handle form submission for adding a task
            $("#taskForm").submit(function (event) {
                event.preventDefault();
                let formData = {
                    title: $("#title").val(),
                    description: $("#description").val(),
                    due_date: $("#due_date").val(),
                    priority: $("#priority").val()
                };

                $.post("create.php", formData, function (response) {
                    alert(response);
                    location.reload();
                });
            });

            // Open Edit Modal and Load Data
            $(".editTask").click(function () {
                let taskId = $(this).data("id");

                $.get("get.php", { id: taskId }, function (task) {
                    let data = JSON.parse(task);
                    $("#editTaskId").val(data.id);
                    $("#editTitle").val(data.title);
                    $("#editDescription").val(data.description);
                    $("#editDueDate").val(data.due_date);
                    $("#editPriority").val(data.priority);
                });
            });

            // Handle form submission for editing a task
            $("#editTaskForm").submit(function (event) {
                event.preventDefault();
                let formData = {
                    id: $("#editTaskId").val(),
                    title: $("#editTitle").val(),
                    description: $("#editDescription").val(),
                    due_date: $("#editDueDate").val(),
                    priority: $("#editPriority").val()
                };

                $.post("edit.php", formData, function (response) {
                    alert(response);
                    location.reload();
                });
            });

            // Handle delete button click
            $(".deleteTask").click(function () {
                if (confirm("Are you sure you want to delete this task?")) {
                    let taskId = $(this).data("id");

                    $.post("delete.php", { id: taskId }, function (response) {
                        alert(response);
                        location.reload();
                    });
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
