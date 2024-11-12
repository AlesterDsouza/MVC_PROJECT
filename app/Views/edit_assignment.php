<?php
session_start();
require_once __DIR__ . '/../Models/Assignment.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../public/login.php");
    exit();
}

$userObj = new Assignment();

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id']; 

    $existingUser = $userObj-> findAssignmentById($id);

    if (!$existingUser) {
        echo "Assignment not found.";
        exit();
    }
} else {
    echo "No assignment ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body onload="validateAllFields()">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit Assignment</h2>
            <form action="../Controllers/AssignmentController.php?action=edit&id=<?php echo $existingUser['id']; ?>" method="POST" id="editAssignmentForm">
                
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?php echo htmlspecialchars($existingUser['title']); ?>" 
                           required oninput="validateTitle()">
                    <div id="title-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" 
                              required oninput="validateDescription()"><?php echo htmlspecialchars($existingUser['description']); ?></textarea>
                    <div id="description-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="due_date">Due Date:</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" 
                           value="<?php echo htmlspecialchars($existingUser['due_date']); ?>" 
                           required oninput="validateDueDate()">
                    <div id="due-date-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update Assignment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Title validation - allow only alphabets and spaces
        function validateTitle() {
            const title = document.getElementById('title').value;
            const errorMsg = document.getElementById('title-error');
            
            // Allow only letters and spaces
            document.getElementById('title').value = title.replace(/[^a-zA-Z ]/g, '');
            
            if (title === '') {
                errorMsg.textContent = 'Title is required';
            } else if (!/^[a-zA-Z ]+$/.test(title)) {
                errorMsg.textContent = 'Only alphabets are allowed in the title';
            } else {
                errorMsg.textContent = '';
            }

            checkSubmitButton();
        }

        // Description validation - restrict numbers and alphabets
        function validateDescription() {
            const description = document.getElementById('description').value;
            const errorMsg = document.getElementById('description-error');

            // Allow only letters, spaces, and some common punctuation
            document.getElementById('description').value = description.replace(/[^a-zA-Z0-9.,!? ]/g, '');

            if (description === '') {
                errorMsg.textContent = 'Description is required';
            } else if (/[^a-zA-Z0-9.,!? ]/.test(description)) {
                errorMsg.textContent = 'Description can only contain alphabets, numbers, and some punctuation';
            } else {
                errorMsg.textContent = '';
            }

            checkSubmitButton();
        }

        // Due date validation (just check if it's not empty)
        function validateDueDate() {
            const dueDate = document.getElementById('due_date').value;
            const errorMsg = document.getElementById('due-date-error');
            
            if (dueDate === '') {
                errorMsg.textContent = 'Due Date is required';
            } else {
                errorMsg.textContent = '';
            }

            checkSubmitButton();
        }

        // Check if all fields are filled to enable the submit button
        function checkSubmitButton() {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const dueDate = document.getElementById('due_date').value;
            document.getElementById('submitBtn').disabled = !(title && description && dueDate);
        }

        // Validate all fields when the page loads
        function validateAllFields() {
            validateTitle();
            validateDescription();
            validateDueDate();
        }
    </script>

</body>
</html>
