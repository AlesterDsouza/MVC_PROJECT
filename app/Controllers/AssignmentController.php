<?php


require_once __DIR__ . '/../Models/Assignment.php';

class AssignmentController {
    private $assignmentModel;

    public function __construct() {
        $this->assignmentModel = new Assignment();
    }

    public function listAssignments($rollNo) {
        $assignments = $this->assignmentModel->getAssignmentsByRollNo($rollNo);
        require_once __DIR__ . '/../Views/assignment_list.php';
    }

    public function createAssignment($rollNo) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            $this->assignmentModel->createAssignment($rollNo, $title, $description, $dueDate);

            header("Location: ../Controllers/AssignmentController.php?action=list&rollNo=$rollNo");
        } else {
            require_once __DIR__ . '/../Views/create_assignment.php';
        }
    }



    public function editAssignment($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            $this->assignmentModel->updateAssignment($id, $title, $description, $dueDate);
            header("Location: ../Views/assignment_list.php");
        } else {
            $assignment = $this->assignmentModel->findAssignmentById($id);
            require_once __DIR__ . '/../Views/edit_assignment.php';
        }
    }

    public function deleteAssignment($id) {
        $this->assignmentModel->deleteAssignment($id);
        header("Location: ../Views/assignment_list.php");
    }
}

$controller = new AssignmentController();
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'list') $controller->listAssignments($_GET['rollNo']);
    if ($action == 'create') $controller->createAssignment($_GET['rollNo']);
    if ($action == 'edit') $controller->editAssignment($_GET['id']);
    if ($action == 'delete') $controller->deleteAssignment($_GET['id']);
}


?>


