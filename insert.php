<?php  
session_start();  
require_once 'confg.php'; // Ensure database configuration file is correct

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['indir'])) {
    try {
        // Sanitize and validate inputs
        $dir_name = filter_var(trim($_POST['dir_name']), FILTER_SANITIZE_STRING);
        $dir_mo_no = filter_var(trim($_POST['dir_mo_no']), FILTER_SANITIZE_NUMBER_INT);
        $dir_mk_pr = filter_var(trim($_POST['mk_pr']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $dir_mk_ty = filter_var(trim($_POST['mk_ty']), FILTER_SANITIZE_STRING);

        // Check if any field is empty
        if (empty($dir_name) || empty($dir_mo_no) || empty($dir_mk_pr) || empty($dir_mk_ty)) {
            throw new Exception("All fields are required!");
        }

        // Validate phone number length (assuming it's a 10-digit number)
        if (strlen($dir_mo_no) !== 10) {
            throw new Exception("Invalid phone number! Must be 10 digits.");
        }

        // Check if the dairy is already registered
        $stmt = $conn->prepare("SELECT dir_name FROM milk_storage WHERE dir_name = ?");
        $stmt->bind_param("s", $dir_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new Exception("Dairy is already registered!");
        }
        $stmt->close();

        // Insert data into database
        $insert_stmt = $conn->prepare("INSERT INTO milk_storage (dir_name, dir_mo_no, milk_pr, milk_type) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss", $dir_name, $dir_mo_no, $dir_mk_pr, $dir_mk_ty);

        if ($insert_stmt->execute()) {
            $_SESSION['success_message'] = "Dairy registered successfully!";
        } else {
            throw new Exception("Failed to register dairy. Please try again.");
        }

        $insert_stmt->close();
    } catch (Exception $e) {
        $_SESSION['registration_error'] = $e->getMessage();
    } finally {
        $conn->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Registration</title>
    <link rel="stylesheet" href="style3.css">
    <style>
        a {
            color: #0055ff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        p {
            color: rgb(0, 0, 0);
        }
        .p {
            color: #ffffff;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box" id="input-form">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success">
                <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['registration_error'])): ?>
            <div class="message error">
                <?php 
                    echo $_SESSION['registration_error']; 
                    unset($_SESSION['registration_error']);
                ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <h2>Input Dairies Info</h2>
            <input type="text" name="dir_name" placeholder="Enter the Dairy name" required><br>
            <input type="number" name="dir_mo_no" placeholder="Enter the number" required><br>
            <input type="number" step="0.01" name="mk_pr" placeholder="Enter the milk price" required><br>
            <input type="text" name="mk_ty" placeholder="Enter the milk type" required><br>
            <button type="submit" name="indir">Insert Dairy</button><br>
            <p class="p">Do you want to <a href="re.php">Log-out</a>?</p>
        </form>
    </div>

    <p>Do you want to see<br><a href="users.php">users info and Dairy info</a></p>
</div>

</body>
</html>
