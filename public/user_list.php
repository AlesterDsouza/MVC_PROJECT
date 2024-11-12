
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Admins</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Updated font family */
    background-color: #f9f9f9; /* Changed background color */
    margin: 0;
    padding: 40px; /* Increased padding */
}

.container {
    max-width: 800px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333; /* Changed color */
    font-size: 24px; /* Set font size */
    margin-bottom: 20px; /* Added margin bottom */
}

.btn {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #218838;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #007bff;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

.actions-column {
    text-align: center;
}

.action-link {
    color: #007bff;
    text-decoration: none;
}

.action-link:hover {
    text-decoration: underline;
}

img {
    border-radius: 50%;
    border: 1px solid #ccc;
}

.form-container {
    max-width: 500px; /* Set maximum width */
    margin: 0 auto; /* Centered alignment */
    background-color: #ffffff; /* Background color */
    padding: 20px 30px; /* Inner padding */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
    text-align: center; /* Centered text */
}

.form-group {
    margin-bottom: 15px; /* Spacing below each group */
    text-align: left; /* Align text left */
}

.form-group label {
    display: block; /* Block display */
    font-weight: bold; /* Bold text */
    margin-bottom: 5px; /* Spacing below label */
    color: #333; /* Color of label */
}

.form-group input, .form-group textarea {
    width: 100%; /* Full width */
    padding: 10px; /* Inner padding */
    border-radius: 5px; /* Rounded corners */
    border: 1px solid #ddd; /* Border */
    font-size: 16px; /* Font size */
    transition: border-color 0.3s; /* Transition effect */
}

.form-group input:focus, .form-group textarea:focus {
    border-color: #5cb85c; /* Border color on focus */
}

button {
    width: 100%; /* Full width */
    padding: 12px; /* Inner padding */
    background-color: #5cb85c; /* Button color */
    color: white; /* Text color */
    font-size: 18px; /* Font size */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer on hover */
    transition: background-color 0.3s; /* Transition effect */
}

button:hover {
    background-color: #4cae4c; /* Darker color on hover */
}

button:disabled {
    background-color: #ccc; /* Color when disabled */
    cursor: not-allowed; /* Not allowed cursor */
}

.error-message {
    color: red; /* Error message color */
    font-size: 14px; /* Font size */
    margin-top: 5px; /* Spacing above */
}

.success-message {
    color: green; /* Success message color */
    font-size: 14px; /* Font size */
    margin-top: 5px; /* Spacing above */
}

.error {
    color: red;
    font-weight: bold;
}

.success {
    color: green;
    font-weight: bold;
}
</style>
        
</head>
<body>
    <div class="container">
        <h2>List of Admins</h2>
        
        <a href="create.php" class="btn">Create User</a>
        <!-- <form method="POST">
            <button type="submit" name="logout" class="btn">Logout</button>
        </form> -->
        <a href="index.php" class="btn">Logout</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>UserName</th>
                    <th>Password</th>
                    <th class="actions-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['ID']); ?></td>
                        <td><?php echo htmlspecialchars($user['UserName']); ?></td>
            
                        <td><?php echo htmlspecialchars(base64_decode($user['Password'])); ?></td>
                        <td class="actions-column">
                            <a href="edit.php?id=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to edit this user?');">Edit</a>
                            <a href="../Controllers/UserController.php?action=delete&id=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            <a href="../Controllers/UserController.php?action=edit&id=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to edit this user');">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

