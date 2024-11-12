<?php

// require_once '../app/Models/User1.php';
require_once __DIR__ . '/../Models/User1.php';

$controller = new User1Controller();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'create1') {
    $controller->createUser($_POST);
}

if (isset($_GET['action']) && $_GET['action'] === 'delete1') {
    $controller->deleteUser($_GET['id']);
}

if (isset($_GET['action']) && $_GET['action'] === 'edit1') {
 
    $controller->updateUser($_GET['id'],$_POST);
}

if (isset($_GET['action']) && $_GET['action'] === 'importCsv') {
    // echo 'Hello';
    // exit;
    $controller->importCsv();
}

    // if (isset($_GET['action']) && $_GET['action'] == 'importCsv') {
    // session_start();
    // $controller = new User1Controller();
    // $controller->importCsv();
    // }
    

class User1Controller {
    private $user1Model;

    public function __construct() {
        $this->user1Model = new User1();
        session_start();
    }

    public function listUsers() {
        // Redirect if not logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ../public/login.php');
            exit();
        }

        $search = $_GET['search'] ?? '';
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $total_users = $this->user1Model->countUsers($search);
        $total_pages = ceil($total_users / $limit);
        $users = $this->user1Model->fetchUsers($search, $limit, $offset);
        
        require_once '../app/Views/user_list1.php';
    }
 
    public function createUser($userData) {
        if ($this->user1Model->rollNoExists($userData['RollNo'])) {
            echo "Error: Roll number already exists!";
            return;
        }
        $this->user1Model->create1($userData['FirstName'], $userData['LastName'], $userData['RollNo']);
        
        header('Location: ../Views/user_list1.php');
    }

    // public function importCsv() {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    //         $file = $_FILES['csv_file'];

    //         if ($file['error'] == 0) {
    //             $fileName = $file['tmp_name'];
    //             $handle = fopen($fileName, 'r');

    //             // Skip the header row
    //             fgetcsv($handle);

    //             // Read and insert the data
    //             while (($data = fgetcsv($handle)) !== false) {
    //                 $firstName = $data[0];
    //                 $lastName = $data[1];
    //                 $rollNo = $data[2];

    //                 // Check if the roll number is valid (3 digits)
    //                 if (!preg_match('/^\d{1,3}$/', $rollNo)) {
    //                     echo "<div class='alert alert-danger'>Error: Roll number $rollNo is not valid. It must be 3 digits or less.</div>";
    //                     continue;
    //                 }

    //                 // Check if roll number already exists
    //                 if ($this->user1Model->rollNoExists($rollNo)) {
    //                     echo "<div class='alert alert-danger'>Error: Roll number $rollNo already exists! Please use a different one.</div>";
    //                     continue;
    //                 }

    //                 // Insert data if roll number is valid and does not exist
    //                 $this->user1Model->create1($firstName, $lastName, $rollNo);
    //             }

    //             fclose($handle);
    //             header('Location: ../Views/user_list1.php');
    //         } else {
    //             echo "Error uploading the file.";
    //         }
    //     }
    // }

    public function importCsv() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
            $file = $_FILES['csv_file'];
    
            // Check file type
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if ($fileType !== 'csv') {
                $_SESSION['error_message'] = "Invalid file format. Only CSV files are allowed.";
                header("Location: ../Views/user_list1.php");
                exit();
            }
    
            // Open and read CSV file
            if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
                // $expectedHeaders = ['ID', 'FirstName', 'LastName', 'RollNo'];
                $expectedHeaders = ['FirstName', 'LastName', 'RollNo'];
                $headerRow = fgetcsv($handle);
    
                // Check if CSV headers match the expected columns
                if ($headerRow !== $expectedHeaders) {
                    $_SESSION['error_message'] = "CSV headers do not match the required table format.";
                    fclose($handle);
                    header("Location: ../Views/user_list1.php");
                    exit();
                }
    
                // Process rows after the header
                while (($data = fgetcsv($handle)) !== false) {
                    // $id = $data[0];
                    // $firstName = $data[1];
                    // $lastName = $data[2];
                    // $rollNo = $data[3];

                    $firstName = $data[0];
                    $lastName = $data[1];
                    $rollNo = $data[2];

            


                    // Check if roll number already exists
                    if ($this->user1Model->rollNoExists($rollNo)) {
                        echo "<div class='alert alert-danger'>Error: Roll number $rollNo already exists! Please use a different one.</div>";
                        continue;
                        }
    
                        // // Insert data if roll number is valid and does not exist
                        // $this->user1Model->create1($firstName, $lastName, $rollNo);
                   
                    $this->user1Model->create1($firstName, $lastName, $rollNo);
                    
                }
    
                fclose($handle);
                $_SESSION['success_message'] = "CSV file imported successfully.";
                header("Location: ../Views/user_list1.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Unable to open CSV file.";
                header("Location: ../Views/user_list1.php");
                exit();
            }
        }
    }

    
    // if (isset($_GET['action']) && $_GET['action'] == 'importCsv') {
    // session_start();
    // $controller = new User1Controller();
    // $controller->importCsv();
    // }
    


    public function editUser($id){
        $user = $this->user1Model->find1($id);
        require_once '../app/Views/edit1.php';
    }

    public function updateUser($id, $userData) {
        $this->user1Model->update1($id, $userData['FirstName'], $userData['LastName'], $userData['RollNo']);
        header('Location: ../Views/user_list1.php');
        // header('Location: ../app/Views/user_list1.php');
    }

    public function deleteUser($id) {
        $this->user1Model->delete1($id);
        header('Location: ../Views/user_list1.php');
    }
}


//Sample 1:

// public function importCsv() {
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
//         $file = $_FILES['csv_file'];

//         // Check file type
//         $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
//         if ($fileType !== 'csv') {
//             $_SESSION['error_message'] = "Invalid file format. Only CSV files are allowed.";
//             header("Location: ../Views/user_list1.php");
//             exit();
//         }

//         // Open and read CSV file
//         if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
//             $expectedHeaders = ['ID', 'FirstName', 'LastName', 'RollNo'];
//             $headerRow = fgetcsv($handle);

//             // Check if CSV headers match the expected columns
//             if ($headerRow !== $expectedHeaders) {
//                 $_SESSION['error_message'] = "CSV headers do not match the required table format.";
//                 fclose($handle);
//                 header("Location: ../Views/user_list1.php");
//                 exit();
//             }

//             // Process rows after the header
//             while (($data = fgetcsv($handle)) !== false) {
//                 $id = $data[0];
//                 $firstName = $data[1];
//                 $lastName = $data[2];
//                 $rollNo = $data[3];
//                 $this->userModel->create1($firstName, $lastName, $rollNo);
//             }

//             fclose($handle);
//             $_SESSION['success_message'] = "CSV file imported successfully.";
//             header("Location: ../Views/user_list1.php");
//             exit();
//         } else {
//             $_SESSION['error_message'] = "Unable to open CSV file.";
//             header("Location: ../Views/user_list1.php");
//             exit();
//         }
//     }
// }
// }

// if (isset($_GET['action']) && $_GET['action'] == 'importCsv') {
// session_start();
// $controller = new User1Controller();
// $controller->importCsv();
// }



//Sample 2:
// require_once __DIR__ . '/../Models/User1.php';

// // Check if this is the import CSV action
// if (isset($_GET['action']) && $_GET['action'] === 'importCsv') {
//     if (isset($_FILES['csv_file'])) {
//         $csvFile = $_FILES['csv_file']['tmp_name'];
//         $fileExtension = pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION);

//         // Check if file is a CSV
//         if ($fileExtension !== 'csv') {
//             $_SESSION['error'] = 'Please upload a CSV file.';
//             header("Location: ../Views/user_list1.php");
//             exit();
//         }

//         // Open the CSV file and validate headers
//         if (($handle = fopen($csvFile, "r")) !== FALSE) {
//             // Read the first row for headers
//             $header = fgetcsv($handle, 1000, ",");

//             // Define expected headers
//             $expectedHeaders = ['FirstName', 'LastName', 'RollNo'];
//             $mismatched = array_diff($expectedHeaders, $header);

//             // Check if headers match
//             if (!empty($mismatched)) {
//                 $_SESSION['error'] = 'CSV headers do not match expected format.';
//                 fclose($handle);
//                 header("Location: ../Views/user_list1.php");
//                 exit();
//             }

//             // Process rows (assume headers match)
//             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                 $firstName = $data[0];
//                 $lastName = $data[1];
//                 $rollNo = (int)$data[2];

//                 // Here you would call the create1 method to add each user
//                 $userObj = new User1();
//                 $userObj->create1($firstName, $lastName, $rollNo);
//             }

//             fclose($handle);
//             $_SESSION['success'] = 'CSV file uploaded and users imported successfully.';
//         } else {
//             $_SESSION['error'] = 'Failed to open the CSV file.';
//         }
//     } else {
//         $_SESSION['error'] = 'No file uploaded.';
//     }

//     header("Location: ../Views/user_list1.php");
//     exit();
// }


?>

