<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Dairy Information</title>
    <style>
         table{
            text-align: left;
            justify-content: center;
            display: flex;  
            width: 100%;  
        }
        
        th{
            background:#0a4d68;
            color:#edc6b1;
        }
        tr:nth-child(even){background:#f4f4f4}
        h1{
            text-align:center;
            color: #edc6b1;
            background:#0a4d68;
        }
        h2{
            text-align:center;
            color:rgb(0, 0, 0);
        }
        body{
            background:#edc6b1;
        }
        .dairy{
           /* background:rgb(255, 0, 0);*/
           color:rgb(255, 0, 0);
            
        }
        .dairy:hover{
           /* background:rgb(255, 255, 255);*/
            color: #0055ff;
            transition-duration: 2s;
        }
        a{
            color: #0055ff;
            text-decoration: none;
        }
        a:hover{
            text-decoration: underline;
        }
        p{
            text-align: center;

        }
    </style>
</head>
<body>
<h1>Users info</h1>
<table>
            <tr>
                <th>user_id</th>
                <th>user_name</th>
                <th>user_number</th>
                <th>user_email</th>
            </tr>
            <?php
            $conn=mysqli_connect(
                "localhost",
                "root","",
                "mas"
            );
            if($conn->connect_error){
                die("Connection Failed:".$conn->connect_error);
            }
            $sql="SELECT * FROM user_info";
            $result=$conn-> query($sql);
            if($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()){
                    echo "<tr> 
                            <td>".$row["Userid"]."</td>
                            <td>".$row["username"]."</td>
                            <td>".$row["mob_num"]."</td>
                            <td>".$row["email_id"]."</td>
                        </tr>";
                }
                echo "</table>";

            }
            else{
                echo "0 result";
            }
            $conn-> close();


            ?>
        </table>
        <br><br>
        <h1>Dairies info</h1>
        <h2>Do you want to add new dairies<a href="insert.php" class="dairy"> New Dairy</a></h2>
        <table>
            <tr>
                <th>Dairy-id</th>
                <th>Dairy-name</th>
                <th>Dairy-number</th>
                <th>Milk-price</th>
                <th>Milk-type</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php

            $conn=mysqli_connect(
                "localhost",
                "root","",
                "mas"
             );
            if($conn->connect_error){
                die("Connection Failed:".$conn->connect_error);
            }
            $sql="SELECT * FROM milk_storage";
            $result=$conn-> query($sql);
            if($result-> num_rows > 0){
                while($row = $result-> fetch_assoc()){
                    echo "<tr> 
                             <td>".$row["dir_id"]."</td>
                            <td>".$row["dir_name"]."</td>
                            <td>".$row["dir_mo_no"]."</td>
                            <td>".$row["milk_pr"]."</td>
                            <td>".$row["milk_type"]."</td>
                            <td>
                                <a href=update.php>Edit</a>
                            </td>
                            <td>
                                <a href=delete.php>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";

            }
            else{
                echo "0 result";
            }
            $conn-> close();

            ?>
        </table>
        <p>Do you want to <a href="re.php">log-out</a></p>
</body>
</html>