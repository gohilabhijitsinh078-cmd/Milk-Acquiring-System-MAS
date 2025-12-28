<?php

    session_start();
    $errors = [
        'login' => $_SESSION['login_error'] ?? '',
        'register' => $_SESSION['registratiob_error'] ?? ''
    ];
    $activeform = $_SESSION['active_form'] ?? 'login';
    
    Session_unset();
    
    function showError($error) {
        return !empty($error) ? "<p class='error-message'>$error</p>" : "";
    }
    
    function isActiveForm($formName, $activeform) {
        return $formName === $activeform ? 'active' : '';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in and Registration Form</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        .error-message{
            padding: 12px;
            background:rgb(255, 255, 255);
            font-size:16px;
            border-radius: 10px;
            color:rgb(255, 0, 0);
            text-align:center;
            margin-bottom:20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box <?= isActiveForm('login',$activeform); ?>" id="login-form">
            <form action="login_registration.php" method="post">
            <h2>Login Form</h2>
            <?= showError($errors['login']); ?>
            <input type="email" name="email" placeholder="Enter the Email" required><br>
            <input type="password" name="password" placeholder="Enter the Password" required><br>
           
            <button type="submit" name="login">Login</button><br>
            <p>Do you want to register? <a href="#" onclick="showform('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form-box <?= isActiveForm('register',$activeform); ?>" id="register-form">
            <form action="login_registration.php" method="post">
                <h2>Registration Form</h2>
                <?= showError($errors['register']); ?>
                <input type="text" name="name" placeholder="Enter the name" required><br>
                <input type="number" name="mo-no" placeholder="Enter the Number" required><br>
                <input type="text" name="email" placeholder="Enter the Email" required><br>
                <input type="password" name="password" placeholder="Enter the Password" required><br>
                <select name="role">
                <option value="">--Select Role--</option>
                <option value="">User</option>
                <option value="">Admin</option>
            </select><br>
                <button type="submit" name="register">Register</button><br>
                <p>Already have an account? <a href="#"onclick="showform('login-form')">Login</a></p>
            </form>
        </div>
    </div>
   
          
    <script src="script.js"></script>
</body>
</html>