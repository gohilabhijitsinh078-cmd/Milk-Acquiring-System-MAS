<?php
session_start();
require_once 'confg.php'; // Database connection

// Initialize variable
$id = "";

// Handle Delete form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    try {
        // Check if 'id' is set and not empty
        if (!isset($_POST['id']) || empty(trim($_POST['id']))) {
            throw new Exception("Dairy ID is required for deletion.");
        }

        $id = intval($_POST['id']);
        if ($id <= 0) {
            throw new Exception("Invalid Dairy ID provided.");
        }

        // Check if the ID exists
        $check_stmt = $conn->prepare("SELECT dir_id FROM milk_storage WHERE dir_id = ?");
        if (!$check_stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows === 0) {
            $check_stmt->close();
            throw new Exception("No record found with ID $id.");
        }
        $check_stmt->close();

        // Delete the record
        $delete_stmt = $conn->prepare("DELETE FROM milk_storage WHERE dir_id = ?");
        if (!$delete_stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            $_SESSION['success_message'] = "Dairy with ID $id deleted successfully!";
        } else {
            throw new Exception("Failed to delete dairy. Please try again.");
        }
        $delete_stmt->close();

        // Redirect to clear POST data and refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
}
?>

<!-- HTML PART -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Dairy Record</title>
    <link rel="stylesheet" href="style3.css">
    <style>
        a { color: #0055ff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        p { color: rgb(0, 0, 0); }
        .message { padding: 10px; margin-bottom: 10px; border-radius: 5px; font-weight: bold; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .container { padding: 20px; max-width: 500px; margin: auto; }
        .form-box { border: 1px solid #ccc; padding: 20px; border-radius: 10px; background: #f9f9f9; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-box" id="delete-form">

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="message success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="message error">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Delete Form -->
        <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this dairy?');">
            <h2>Delete Dairy Info</h2>

            <input type="number" name="id" value="<?php echo htmlspecialchars($id); ?>" placeholder="Enter Dairy ID" required min="1"><br><br>

            <button type="submit" name="delete">Delete Dairy</button><br><br>
        </form>

        <p><a href="users.php">Go Back to Dairy List</a></p>
        <p><a href="update_dairy.php">Update Dairy Info</a></p>

    </div>
</div>

</body>
</html>
