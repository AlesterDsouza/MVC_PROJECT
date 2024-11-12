<?php

require_once __DIR__ . '/../Models/User.php';

$user = new User(); // Instantiate the User class

if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $existingUser = $user->find($id);
} else {
    $existingUser = null; // Ensure $existingUser is defined
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body onload="validateAllFields()">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Edit User</h2>
            <form action="../Controllers/UserController.php?action=edit&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="editUserForm">

                <!-- Hidden input for ID -->
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">

                <div class="form-group">
                    <label for="UserName">UserName:</label>
                    <input type="text" class="form-control" id="UserName" name="UserName" 
                           value="<?php echo htmlspecialchars($existingUser['UserName']); ?>" 
                           required autocomplete="off" oninput="validateUsername()">
                    <div id="username-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" id="Password" name="Password" 
                           required autocomplete="off" oninput="validatePassword()">
                    <div id="password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="ConfirmPassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" 
                           required autocomplete="off" oninput="validateConfirmPassword()">
                    <div id="confirm-password-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation for Username, Password, and Confirm Password
        function validateUsername() {
            const username = document.getElementById('UserName').value;
            // Restrict input to only alphabets
            document.getElementById('UserName').value = username.replace(/[^a-zA-Z]/g, '');
            
            if (username === '') {
                document.getElementById('username-error').textContent = 'Username is required';
            } else {
                document.getElementById('username-error').textContent = '';
            }
            checkSubmitButton();
        }

        function validatePassword() {
            const password = document.getElementById('Password').value;
            // Restrict input to only numbers
            document.getElementById('Password').value = password.replace(/[^0-9]/g, '');

            if (password.length < 6) {
                document.getElementById('password-error').textContent = 'Password must be at least 6 characters long';
            } else {
                document.getElementById('password-error').textContent = '';
            }
            checkSubmitButton();
        }

        function validateConfirmPassword() {
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;
            if (password !== confirmPassword) {
                document.getElementById('confirm-password-error').textContent = 'Passwords do not match';
            } else {
                document.getElementById('confirm-password-error').textContent = '';
            }
            checkSubmitButton();
        }

        function checkSubmitButton() {
            const username = document.getElementById('UserName').value;
            const password = document.getElementById('Password').value;
            const confirmPassword = document.getElementById('ConfirmPassword').value;

            const submitBtn = document.getElementById('submitBtn');

            // Enable the button only if all fields are filled and passwords match
            submitBtn.disabled = !(username && password.length >= 6 && password === confirmPassword);
        }

        // Run all validations on page load
        function validateAllFields() {
            validateUsername();
            validatePassword();
            validateConfirmPassword();
        }
    </script>
</body>
</html>
