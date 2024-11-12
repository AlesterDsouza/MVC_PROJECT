<?php
// session_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../Views/user_list1.php");
    exit();
}

// Get rollNo from session or URL
$rollNo = isset($_GET['rollNo']) ? $_GET['rollNo'] : (isset($_SESSION['rollNo']) ? $_SESSION['rollNo'] : null);

if (!$rollNo) {
    echo "<script>alert('Roll No is missing. Redirecting to home page.');</script>";
    echo "<script>window.location.href='user_list1.php';</script>"; // Redirect to home page if rollNo is missing
    exit;
}

// Store rollNo in session if not already set
$_SESSION['rollNo'] = $rollNo;

require_once __DIR__ . '/../Models/Assignment.php';

$userObj = new Assignment();

// Handle search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$limit = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_users = $userObj->countAssignments($search);  // Get the total count of assignments
$total_pages = ceil($total_users / $limit);   // Calculate total pages for pagination

// Fetch only the assignments for the logged-in user's roll number
$assignments = $userObj->fetchAssignments($search, $limit, $offset, $rollNo);  // Fetch assignments for the current rollNo
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignments</title>
    <style>
         /* General Styling */
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Header Section */
        .header {
            width: 100%;
            padding: 20px;
            background-color: #3498db;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .header a {
            color: #fff;
            background-color: #2980b9;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .header a:hover {
            background-color: #1f6e97;
        }

        /* Table Section */
        .table-container {
            width: 90%;
            margin-top: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        td {
            color: #333;
            font-size: 14px;
        }

        /* Actions Links */
        .action-link {
            color: #e74c3c;
            font-weight: bold;
            margin-right: 8px;
        }

        .action-link:hover {
            color: #c0392b;
            text-decoration: underline;
        }

        .action-link.edit {
            color: #2ecc71;
        }

        .action-link.edit:hover {
            color: #27ae60;
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
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h2>Assignments for Roll No: <?php echo htmlspecialchars($rollNo); ?></h2>
        <a href="../Controllers/AssignmentController.php?action=create&rollNo=<?php echo htmlspecialchars($rollNo); ?>" class="create-btn">Create Assignment</a>
    </div>
    
    <!-- Table Section -->
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($assignments as $assignment): ?>
            <tr>
                <td><?php echo htmlspecialchars($assignment['id']); ?></td>
                <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                <td><?php echo htmlspecialchars($assignment['description']); ?></td>
                <td><?php echo htmlspecialchars($assignment['due_date']); ?></td>
                <td>
                    <a href="../Views/edit_assignment.php?action=edit&id=<?php echo $assignment['id']; ?>&rollNo=<?php echo $_GET['rollNo']; ?>" class="action-link edit">Edit</a>
                    <a href="../Controllers/AssignmentController.php?action=delete&id=<?php echo $assignment['id']; ?>" class="action-link">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <!-- Pagination Section -->
        <div class="pagination">
            <!-- Implement pagination logic -->
        </div>

        <div class="logout-btn">
            <form action="../Views/user_list1.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
