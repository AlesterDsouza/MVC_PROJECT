<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assignment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create Assignment</h2>
        <form action="../Controllers/AssignmentController.php?action=create&rollNo=<?php echo $_GET['rollNo']; ?>" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required oninput="validateTitle()">
                <div id="title-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required oninput="validateDescription()"></textarea>
                <div id="description-error" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Create Assignment</button>
        </form>
    </div>
</div>

<script>
    // Title validation - allow only alphabets and spaces
    function validateTitle() {
        const title = document.getElementById('title').value;
        const errorMsg = document.getElementById('title-error');
        
        // Allow only letters and spaces
        document.getElementById('title').value = title.replace(/[^a-zA-Z ]/g, '');
        
        if (title === '') {
            errorMsg.textContent = 'Title is required';
        } else if (!/^[a-zA-Z ]+$/.test(title)) {
            errorMsg.textContent = 'Only alphabets are allowed in the title';
        } else {
            errorMsg.textContent = '';
        }

        checkSubmitButton();
    }

    // Description validation - restrict numbers and alphabets
    function validateDescription() {
        const description = document.getElementById('description').value;
        const errorMsg = document.getElementById('description-error');

        document.getElementById('description').value = description.replace(/[^a-zA-Z ]/g, '');
        // document.getElementById('description').value = description.replace(/[^a-zA-Z0-9.,!? ]/g, '');

        if (description === '') {
            errorMsg.textContent = 'Description is required';
        } else if (!/^[a-zA-Z ]+$/.test(description)) {
        // else if (/[^a-zA-Z0-9.,!? ]/.test(description)) {
            errorMsg.textContent = 'Description can only contain alphabets, numbers, and some punctuation';
        } else {
            errorMsg.textContent = '';
        }

        checkSubmitButton();
    }

    function checkSubmitButton() {
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;
        const dueDate = document.getElementById('due_date').value;
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.disabled = !(title && description && dueDate);
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Assignment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2 class="text-center">Create Assignment</h2>
        <form action="../Controllers/AssignmentController.php?action=create2" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <label for="Title">Title:</label>
                <input type="text" class="form-control" id="Title" name="title" required>
                <div id="title-name-error" class="error-message"></div>
            </div>



            <div class="form-group">
                <label for="LastName">Description:</label>
                <input type="text" class="form-control" id="LastName" name="LastName" required>
                <div id="last-name-error" class="error-message"></div>
            </div>

            <div class="form-group">
                <label for="RollNo">Due Date:</label>
                <input type="date" class="form-control" id="RollNo" name="RollNo" required>
                <div id="roll-no-error" class="error-message"></div>
            </div>


            <button type="submit" name="submit" class="btn btn-primary w-100">Add Student</button>

          
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>
<script>
    // Call validateImage on page load to check the image validation state
    window.onload = validateImage;
</script> -->
<!-- </body>
</html> -->



<!-- 
<!DOCTYPE html>
<html>
<head>
    <title>Create Assignment</title>
</head>
<body>
    <h1>Create Assignment</h1>
    <form method="POST" action="">
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Description:</label>
        <textarea name="description" required></textarea><br>
        <label>Due Date:</label>
        <input type="date" name="due_date" required><br>
        <button type="submit">Create</button>
    </form>
</body>
</html> -->




<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Assignment</title>
</head>
<body>
    <h2>Create Assignment</h2>
    <form action="../Controllers/AssignmentController.php?action=create&rollNo=<?php echo $_GET['rollNo']; ?>" method="POST">
        <label>Title:</label><input type="text" name="title" required><br>
        <label>Description:</label><textarea name="description" required></textarea><br>
        <label>Due Date:</label><input type="date" name="due_date" required><br>
        <button type="submit">Create Assignment</button>
    </form>
</body>
</html> -->








