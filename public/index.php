<?php

// require_once '../app/Controllers/UserController.php';
// require_once '../app/Controllers/User1Controller.php';

// $controller = $_GET['controller'] ?? 'user';
// $action = $_GET['action'] ?? 'list';

// if ($controller === 'user') {
//     $userController = new UserController();
//     if ($action === 'list') {
//         $userController->listUsers();
//     } elseif ($action === 'create') {
//         $userController->createUser($_POST);
//     } elseif ($action === 'edit') {
//         $userController->editUser($_GET['id']);
//     } elseif ($action === 'update') {
//         $userController->updateUser($_GET['id'], $_POST);
//     } elseif ($action === 'delete') {
//         $userController->deleteUser($_GET['id']);
//     }
// } elseif ($controller === 'user1') {
//     $user1Controller = new User1Controller();
//     if ($action === 'list') {
//         $user1Controller->listUsers();
//     } elseif ($action === 'create') {
//         $user1Controller->createUser($_POST);
//     } elseif ($action === 'edit') {
//         $user1Controller->editUser($_GET['id']);
//     } elseif ($action === 'update') {
//         $user1Controller->updateUser($_GET['id'], $_POST);
//     } elseif ($action === 'delete') {
//         $user1Controller->deleteUser($_GET['id']);
//     }
// }



//Second Sample
// require_once '../app/Controllers/LoginController.php';

// session_start();

// // Handles logout if requested
// if (isset($_GET['action']) && $_GET['action'] === 'logout') {
//     session_unset(); // Clear session variables
//     session_destroy(); // Destroy the session
//     header('Location: index.php'); 
//     exit();
// }

// $controllerName = $_GET['controller'] ?? 'login';
// $action = $_GET['action'] ?? 'showLoginForm';

// $controller = null;

// if ($controllerName === 'login') {
//     $controller = new LoginController();
// }

// if ($controller && method_exists($controller, $action)) {

//     $controller->$action();
// } else {
//     echo "404 - Page Not Found";
// }



//Real:

require_once '../app/Controllers/LoginController.php';

$controllerName = $_GET['controller'] ?? 'login';
$action = $_GET['action'] ?? 'showLoginForm';

$controller = null;

if ($controllerName === 'login') {
    $controller = new LoginController();
}

if ($controller && method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "404 - Page Not Found";
}



// require_once __DIR__ . '/../app/Controllers/AssignmentController.php';

// $controller = new AssignmentController();
// $rollNo = 123; 

// if (isset($_GET['action'])) {
//     switch ($_GET['action']) {
//         case 'create':
//             $controller->createAssignment($rollNo);
//             break;
//         case 'edit':
//             $id = $_GET['id'];
//             $controller->editAssignment($id);
//             break;
//         case 'delete':
//             $id = $_GET['id'];
//             $controller->deleteAssignment($id);
//             break;
//         default:
//             $controller->listAssignments($rollNo);
//             break;
//     }
// } else {
//     $controller->listAssignments($rollNo);
// }