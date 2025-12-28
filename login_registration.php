<?php
session_start();
require_once 'confg.php';

  if(isset($_POST['register'])){
        $name=$_POST['name'];
        $mo_no=$_POST['mo-no'];
        $Upass= password_hash($_POST['password'],PASSWORD_DEFAULT);
        $email=$_POST['email'];

    $ScheckEmail=$conn->query("SELECT email_id FROM user_info WHERE email_id='$email'");
        if ($ScheckEmail->num_rows >0) {
            $_SESSION['registratiob_error']='Email is already regitered';
            $_SESSION['active_form']='register';
        }
        else{
            $conn->query("INSERT INTO user_info(username, mob_num, user_pass, email_id) VALUES ('$name','$mo_no','$Upass','$email')");
        }

        header("Location: re.php");
        exit();
    }
//login user ........................................................................


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM user_info WHERE email_id = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['user_pass'])) {
            // Set session variables
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: users.php");
            } elseif ($user['role'] === 'user') {
                header("Location: index.php");
            } else {
                // Optional: handle unexpected roles
                $_SESSION['login_error'] = 'Unauthorized role access.';
                header("Location: re.php");
            }
            exit();
        }
    }

    // If login fails
    $_SESSION['login_error'] = 'Incorrect Email or Password :)';
    $_SESSION['active_form'] = 'login';
    header("Location: users.php");
    exit();
}

?>
