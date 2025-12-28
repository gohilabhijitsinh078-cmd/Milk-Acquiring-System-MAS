<?php  
session_start();  
require_once 'confg.php'; // Database connection

// Initialize variables
$dir_name = $dir_mo_no = $milk_pr = $milk_type = "";
$id = "";
$data_found = false; // Flag to check if data exists

// Function to sanitize input
function sanitize_input($data) {
    return filter_var(trim($data), FILTER_SANITIZE_STRING);
}

// Step 1: Handle Update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    try {
        $id = intval($_POST['id']);
        $new_dir_name = sanitize_input($_POST['dir_name']);
        $new_dir_mo_no = filter_var(trim($_POST['dir_mo_no']), FILTER_SANITIZE_NUMBER_INT);
        $new_milk_pr = filter_var(trim($_POST['mk_pr']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $new_milk_type = sanitize_input($_POST['mk_ty']);

        // Validations
        if (empty($new_dir_name) || empty($new_dir_mo_no) || empty($new_milk_pr) || empty($new_milk_type)) {
            throw new Exception("All fields are required!");
        }
        if (!preg_match('/^\d{10}$/', $new_dir_mo_no)) {
            throw new Exception("Phone number must be exactly 10 digits!");
        }

        // Prepare and execute update statement
        $update_stmt = $conn->prepare("UPDATE milk_storage SET dir_name = ?, dir_mo_no = ?, milk_pr = ?, milk_type = ? WHERE dir_id = ?");
        $update_stmt->bind_param("ssssi", $new_dir_name, $new_dir_mo_no, $new_milk_pr, $new_milk_type, $id);

        if ($update_stmt->execute()) {
            $_SESSION['success_message'] = "Dairy updated successfully!";
            $_SESSION['last_updated_id'] = $id; // Save ID for refetch
        } else {
            throw new Exception("Failed to update dairy.");
        }
        $update_stmt->close();
        header("Location: ".$_SERVER['PHP_SELF']); // Refresh page
        exit();

    } catch (Exception $e) {
        $_SESSION['registration_error'] = $e->getMessage();
    }
}

// Step 2: Fetch data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fetch'])) {
    $id = intval($_POST['id']);
} elseif (isset($_SESSION['last_updated_id'])) {
    $id = intval($_SESSION['last_updated_id']);
    unset($_SESSION['last_updated_id']); // Clear it after using
}

if (!empty($id)) {
    $stmt = $conn->prepare("SELECT dir_name, dir_mo_no, milk_pr, milk_type FROM milk_storage WHERE dir_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dir_name, $dir_mo_no, $milk_pr, $milk_type);
        $stmt->fetch();
        $data_found = true;
    } else {
        $_SESSION['registration_error'] = "No dairy found with ID $id!";
    }
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Dairy Info</title>
    <link rel="stylesheet" href="style3.css">
    <style>
        a { color: #0055ff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        p { color: rgb(0, 0, 0); }
        .p { color: #ffffff; }
        .message {
            padding: 10px; margin-bottom: 10px; border-radius: 5px;
            font-weight: bold;
        }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box" id="input-form">

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['registration_error'])): ?>
            <div class="message error">
                <?php echo $_SESSION['registration_error']; unset($_SESSION['registration_error']); ?>
            </div>
        <?php endif; ?>

        <!-- Fetch Form -->
        <form method="post" action="">
            <h2>Fetch Dairy Info</h2>
            <input type="number" name="id" value="<?php echo htmlspecialchars($id); ?>" placeholder="Enter Dairy ID" required><br>
            <button type="submit" name="fetch">Fetch Dairy</button><br><br>
        </form>

        <!-- Show Update Form only if data is found -->
        <?php if ($data_found): ?>
        <form method="post" action="">
            <h2>Update Dairy Info</h2>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <input type="text" name="dir_name" value="<?php echo htmlspecialchars($dir_name, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter Dairy Name" required><br>

            <input type="text" name="dir_mo_no" value="<?php echo htmlspecialchars($dir_mo_no, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter Mobile Number" required><br>

            <input type="text" name="mk_pr" value="<?php echo htmlspecialchars($milk_pr, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter Milk Price" required><br>

            <input type="text" name="mk_ty" value="<?php echo htmlspecialchars($milk_type, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Enter Milk Type" required><br>

            <button type="submit" name="update" onclick="return confirm('Are you sure you want to update this dairy info?')">Update Dairy</button><br>
        </form>
        <?php endif; ?>

        <p class="p">Do you want to <a href="users.php">Back to Dairy List</a>?</p>

    </div>
</div>

</body>
</html>
