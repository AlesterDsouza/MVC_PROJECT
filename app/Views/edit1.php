<?php
session_start();
require_once __DIR__ . '/../Models/User1.php'; // Include the User model

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../public/login.php");
    exit();
}

$userObj = new User1();

// Check if the 'id' parameter exists in the URL
if (isset($_GET['action']) && $_GET['action'] === 'edit1' && isset($_GET['id'])) {
    $id = $_GET['id'];  // Get the user ID from the URL

    // Fetch user data from the database based on the user ID
    $existingUser = $userObj->find1($id);

    // Check if user data is retrieved
    if (!$existingUser) {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user ID provided.";
    exit();
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
            <h2 class="text-center">Edit Student</h2>
            <form action="../Controllers/User1Controller.php?action=edit1&id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="editUserForm">

                <!-- Hidden input for ID -->
                <input type="hidden" name="ID" value="<?php echo $existingUser['ID']; ?>">

                <div class="form-group">
                    <label for="FirstName">First Name:</label>
                    <input type="text" class="form-control" id="FirstName" name="FirstName" 
                           value="<?php echo htmlspecialchars($existingUser['FirstName']); ?>" 
                           required autocomplete="off" oninput="validateFirstName()">
                    <div id="first-name-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="LastName">Last Name:</label>
                    <input type="text" class="form-control" id="LastName" name="LastName" 
                           value="<?php echo htmlspecialchars($existingUser['LastName']); ?>" 
                           required autocomplete="off" oninput="validateLastName()">
                    <div id="last-name-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label for="RollNo">Roll No:</label>
                    <input type="text" class="form-control" id="RollNo" name="RollNo" 
                           value="<?php echo htmlspecialchars($existingUser['RollNo']); ?>" 
                           required autocomplete="off" oninput="validateRollNo()">
                    <div id="roll-no-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitBtn" disabled>Update User</button>
                </div>
            </form>
        </div>
    </div>

    <script>

var vfirstName = false;
var vlastName = false;
var vrollNo = false;

// var vFirstName = false;
// var vLastName = false;
// var vrollNo = false;

// Get the submit button
document.addEventListener('DOMContentLoaded', function() {
    var submitBtn = document.getElementById('submitBtn');
    checkSubmitButton();
});

// Restrict input to alphabets for FirstName and LastName
document.getElementById('FirstName').addEventListener('input', restrictNameInput);
document.getElementById('LastName').addEventListener('input', restrictNameInput);
document.getElementById('RollNo').addEventListener('input', restrictNumericInput);

function restrictNameInput(event) {
    const value = event.target.value;
    event.target.value = value.replace(/[^a-zA-Z ]/g, ''); // Allow only alphabets and spaces
    validateName(event.target);
    // validateFirstName(event.target);
}



function restrictNumericInput(event) {
    const value = event.target.value;
    event.target.value = value.replace(/[^0-9]/g, ''); // Allow only numbers for roll number
    validateRollNo(event.target);
}

// // Validate first name
// function validateFirstName() {
//     var firstName = document.getElementById('FirstName').value;

//     if (firstName.length === 0) {
//         firstNameError.innerHTML = 'First name is required';
//         firstNameError.style.color= 'red';
//         firstNameError.classList.remove('success');
//         firstNameError.classList.add('error');
//         vFirstName = false;
//     } else if (firstName.length < 3) {
//         firstNameError.innerHTML = 'First name must be at least 3 characters long';
//         firstNameError.style.color= 'red';
//         firstNameError.classList.remove('success');
//         firstNameError.classList.add('error');
//         vFirstName = false;
//     } else {
//         firstNameError.innerHTML = 'Valid First Name';
//         firstNameError.style.color= 'green';
//         firstNameError.classList.remove('error');
//         firstNameError.classList.add('success');
//         vFirstName = true;
//     }
//     checkSubmitButton();
// }

// // Validate last name
// function validateLastName() {
//     var lastName = document.getElementById('LastName').value;

//     if (lastName.length === 0) {
//         lastNameError.innerHTML = 'Last name is required';
//         lastNameError.style.color= 'red';
//         lastNameError.classList.remove('success');
//         lastNameError.classList.add('error');
//         vLastName = false;
//     } else if (lastName.length < 3) {
//         lastNameError.innerHTML = 'Last name must be at least 3 characters long';
//         lastNameError.style.color= 'red';
//         lastNameError.classList.remove('success');
//         lastNameError.classList.add('error');
//         vLastName = false;
//     } else {
//         lastNameError.innerHTML = 'Valid Last Name';
//         lastNameError.style.color= 'green';
//         lastNameError.classList.remove('error');
//         lastNameError.classList.add('success');
//         vLastName = true;
//     }
//     checkSubmitButton();
// }

function validateName(input) {
    var errorElement = input.id === 'FirstName' ? 'first-name-error' : 'last-name-error';
    var name = input.value;

    if (name.length === 0) {
        document.getElementById(errorElement).innerHTML = 'Name is required';
        if (input.id === 'FirstName') {
            vfirstName = false;
        } else {
            vlastName = false;
        }
    } else {
        document.getElementById(errorElement).innerHTML = 'Valid name';
        if (input.id === 'FirstName') {
            vfirstName = true;
        } else {
            vlastName = true;
        }
    }
    checkSubmitButton();
}

function validateRollNo(input) {
    var rollNo = input.value;
    var errorElement = 'roll-no-error';

    if (rollNo.length === 0) {
        document.getElementById(errorElement).innerHTML = 'Roll number is required';
        vrollNo = false;
    } else if (rollNo.length !== 3) {
        document.getElementById(errorElement).innerHTML = 'Roll number must be 3 digits';
        vrollNo = false;
    } else {
        document.getElementById(errorElement).innerHTML = 'Valid roll number';
        vrollNo = true;
    }
    checkSubmitButton();
}

function checkSubmitButton() {
    var submitBtn = document.getElementById('submitBtn');
    if (vfirstName && vlastName && vrollNo) {
        // if (vFirstName && vLastName && vrollNo) {
        submitBtn.disabled = false; // Enable submit button
    } else {
        submitBtn.disabled = true; // Disable submit button
    }
}


        // Validate all fields when the page loads
        function validateAllFields() {
            validateName();
            // validateFirstName()
            // validateLastName()
            validateRollNo();
        }


        // // Client-side validation for FirstName, LastName, and RollNo
        // function validateFirstName() {
        //     const firstname = document.getElementById('FirstName').value;
        //     const regex = /^[a-zA-Z]+$/; // Only alphabets allowed
        //     if (!regex.test(firstname)) {
        //         document.getElementById('first-name-error').textContent = 'First Name must contain only alphabets';
        //     } else {
        //         document.getElementById('first-name-error').textContent = '';
        //     }
        //     checkSubmitButton();
        // }

        // function validateLastName() {
        //     const lastname = document.getElementById('LastName').value;
        //     const regex = /^[a-zA-Z]+$/; // Only alphabets allowed
        //     if (!regex.test(lastname)) {
        //         document.getElementById('last-name-error').textContent = 'Last Name must contain only alphabets';
        //     } else {
        //         document.getElementById('last-name-error').textContent = '';
        //     }
        //     checkSubmitButton();
        // }

        // function validateRollNo() {
        //     const rollNoInput = document.getElementById('RollNo');
        //     let rollNo = rollNoInput.value;
            
        //     rollNo = rollNo.replace(/\D/g, ''); // Remove non-digit characters
        //     if (rollNo.length > 3) {
        //         rollNo = rollNo.slice(0, 3); // Limit input to 3 digits
        //     }
        //     rollNoInput.value = rollNo; // Update input value

        //     if (rollNo.length === 0) {
        //         document.getElementById('roll-no-error').textContent = 'Roll No is required';
        //     } else if (rollNo.length !== 3) {
        //         document.getElementById('roll-no-error').textContent = 'Roll No must be exactly 3 digits';
        //     } else {
        //         document.getElementById('roll-no-error').textContent = '';
        //     }

        //     checkSubmitButton();
        // }

        // function checkSubmitButton() {
        //     const firstname = document.getElementById('FirstName').value;
        //     const lastname = document.getElementById('LastName').value;
        //     const rollNo = document.getElementById('RollNo').value;

        //     const submitBtn = document.getElementById('submitBtn');

        //     // Enable the button only if all fields are valid
        //     submitBtn.disabled = !(firstname && lastname && rollNo.length === 3);
        // }

        // // Run all validations on page load
        // function validateAllFields() {
        //     validateFirstName();
        //     validateLastName();
        //     validateRollNo();
        // }
    </script>
</body>
</html>
