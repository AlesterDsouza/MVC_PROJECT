



<?php

// Start the session
session_start();

require_once __DIR__ . '/../Models/User1.php';

// Check if the user is logged in; if not, redirect to login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../public/login.php");
    exit();
}

$userObj = new User1();
$users = $userObj->fetchUsers();

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_users = $userObj->countUsers($search);  // Total user count
$total_pages = ceil($total_users / $limit);   // Total pages for pagination
$users = $userObj->fetchUsers($search, $limit, $offset);  // Fetch the users based on search and pagination

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

         /* General Styles */
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }

        /* Header Buttons */
        .header-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header-buttons a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .header-buttons a:hover {
            background-color: #0056b3;
        }

        /* Search Box and Filters */
        .search-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-container input {
            padding: 10px;
            width: 70%;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-right: 10px;
        }

        .search-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
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

        /* Pagination Styles */
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        /* CSV Upload Section */
        .csv-upload {
            margin-top: 40px;
            text-align: center;
        }

        .csv-upload form {
            display: inline-block;
            margin-bottom: 20px;
        }

        .csv-upload input[type="file"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .csv-upload button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .csv-upload button:hover {
            background-color: #218838;
        }

        .csv-upload a {
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }

        .csv-upload a:hover {
            text-decoration: underline;
        }

        /* Logout Button */
        .logout-btn {
            text-align: right;
            margin-top: 20px;
        }

        .logout-btn button {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-btn button:hover {
            background-color: #c82333;
        }
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 40px;
        }
        /* Additional styling */
        .error-message, .success-message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            color: white;
            border-radius: 4px;
        }
        .error-message { background-color: #dc3545; }
        .success-message { background-color: #28a745; }
    </style>
</head>
<body>

<div class="container">

    <!-- Display messages -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error-message">
            <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php elseif (isset($_SESSION['success_message'])): ?>
        <div class="success-message">
            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <div class="header-buttons">
        <a href="create1.php">Create New Student</a>
    </div>

    <h2>Student List</h2>

    <!-- Search and Filter -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by First Name or Last Name" value="<?php echo htmlspecialchars($search); ?>" autocomplete="off">
            <button type="submit"><i class="fas fa-search"></i> Search</button>
        </form>
    </div>

    <!-- User List Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>RollNo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['ID']); ?></td>
                        <td><?php echo htmlspecialchars($user['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($user['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($user['RollNo']); ?></td>
                        <td class="actions-column">
                            <a href="../Controllers/AssignmentController.php?action=list&rollNo=<?php echo $user['RollNo']; ?>">Assign</a>
                            <a href="../Views/edit1.php?action=edit1&id=<?php echo $user['ID']; ?>" class="action-link">Edit</a> |
                            <a href="../Controllers/User1Controller.php?action=delete1&id=<?php echo $user['ID']; ?>" class="action-link" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Previous</a>
        <?php endif; ?>

        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
        <?php endif; ?>
    </div>

    <!-- CSV Upload Section -->
    <div class="csv-upload">
        <h3>Import Users via CSV</h3>
        <form action="../Controllers/User1Controller.php?action=importCsv" method="POST" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit">Upload CSV</button>
        </form>
        <br>
        <a href="../files/sample_data.csv" download>Download Sample CSV</a>
    </div>

</div>

</body>
</html>
<?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>" <?php if ($i == $page) echo 'style="font-weight: bold;"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>">Next</a>
        <?php endif; ?>
    </div>

    <!-- CSV Upload Section -->
    <!-- <div class="csv-upload">
        <h3>Import Users via CSV</h3>
        <form action="../Controllers/User1Controller.php?action=importCsv" method="POST" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit">Upload CSV</button>
        </form>
        <br>
        <a href="../files/sample_data.csv" download>Download Sample CSV</a>
    </div>

</div> -->

</body>
</html>



