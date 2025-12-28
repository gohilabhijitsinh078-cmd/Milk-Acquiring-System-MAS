<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>this is Reviews</title>
    <style>
        body{
    display:flex;
    justify-content: center;
    align-items: center;
    background:#edc6b1;
    color:#333;
}
        .we{
            text-align:center;
            justify-content:center;
            width: 100%;
            max-width: 450px;
            padding: 30px;
            background:#0a4d68; 
            border-radius: 10px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 1.7);
            color:#edc6b1;
        }
    </style>
</head>
<body>
    
    <div class="we">
        <?php

            if(isset($_POST['give'])){
                $sug=nl2br($_POST['review']);
                echo "Your review is : <br>";
                echo "<font color=blue><b>$sug</b></font>";
            }

            echo "<br>"
        ?>
    </div>
    <br><br><br>
    <p>Return to the <a href="index.php">Home Page</a></p>
</body>
</html>