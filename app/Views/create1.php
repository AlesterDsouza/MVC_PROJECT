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
        <h2 class="text-center">Create New Student</h2>
        <form action="../Controllers/User1Controller.php?action=create1" method="post" enctype="multipart/form-data" autocomplete="off" id="createForm">
            <div class="form-group">
                <label for="FirstName">FirstName</label>
                <input type="text" class="form-control" id="FirstName" name="FirstName" required>
                <div id="first-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="LastName">LastName</label>
                <input type="text" class="form-control" id="LastName" name="LastName" required>
                <div id="last-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="RollNo">RollNo</label>
                <input type="text" class="form-control" id="RollNo" name="RollNo" required maxlength="3">
                <div id="roll-no-error" class="error-message"></div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Add Student</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>

<script>

var vfirstName = false;
var vlastName = false;
var vrollNo = false;

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
}

function restrictNumericInput(event) {
    const value = event.target.value;
    event.target.value = value.replace(/[^0-9]/g, ''); // Allow only numbers for roll number
    validateRollNo(event.target);
}

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
        submitBtn.disabled = false; // Enable submit button
    } else {
        submitBtn.disabled = true; // Disable submit button
    }
}


</script>
</body>
</html>
