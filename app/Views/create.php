<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create New Admin</h2>
        <form action="../Controllers/UserController.php?action=create" method="post" enctype="multipart/form-data" autocomplete="off" id="createUserForm">
            <div class="form-group">
                <label for="UserName">UserName</label>
                <input type="text" class="form-control" id="UserName" name="UserName" required>
                <div id="username-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" required>
                <div id="password-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="ConfirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required>
                <div id="confirm-password-error" class="error-message"></div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Add User</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Validation for UserName (only alphabets)
document.getElementById('UserName').addEventListener('input', function(event) {
    const value = event.target.value;
    event.target.value = value.replace(/[^a-zA-Z]/g, '');
    const errorMessage = document.getElementById('username-error');
    if (value.match(/[^a-zA-Z]/)) {
        errorMessage.textContent = 'Only alphabets are allowed for username';
    } else {
        errorMessage.textContent = '';
    }
});

// Validation for Password (only numbers)
document.getElementById('Password').addEventListener('input', function(event) {
    const value = event.target.value;
    event.target.value = value.replace(/[^0-9]/g, '');
    const errorMessage = document.getElementById('password-error');
    if (value.match(/[^0-9]/)) {
        errorMessage.textContent = 'Only numbers are allowed for password';
    } else {
        errorMessage.textContent = '';
    }
});

// Confirm Password Validation
document.getElementById('createUserForm').addEventListener('submit', function(event) {
    const password = document.getElementById('Password').value;
    const confirmPassword = document.getElementById('ConfirmPassword').value;
    const confirmErrorMessage = document.getElementById('confirm-password-error');
    
    if (password !== confirmPassword) {
        event.preventDefault();
        confirmErrorMessage.textContent = 'Passwords do not match!';
    } else {
        confirmErrorMessage.textContent = '';
    }
});
</script>
</body>
</html>
