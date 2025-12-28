<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Dairies milk</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        .footer .box-container{
            display: flex;
            width: 100%;
            justify-content: center;
            margin: auto;
            font-size:;
        }
        .footer{
            background: var(--primary);
            padding: 1.5vh 5vw;
            
        }
        .footer .box-container .box h3{
            font-size: 2vw;
            margin-bottom: 2vh;
            text-align: center;
            padding: 2vw 0;
            color: var(--main-color);
        }

        .footer .box-container .box a{
            display: block;
            font-size: 1.3rem;
            color:var(--white);
        }

        .footer .box-container .box a:hover{
            padding-right: 2rem;  
            color:var(--main-color);
        }
        .footer .box-container{
            text-align: center;
        }
        .list{
            padding: 0;
        }
        .bottom-bar{
            background: var(--main-color);
            text-align: center;
            padding: 1vh 25vw;
            font-size:1vw;
        }

        table{
            text-align: center;
            justify-content: center;
            display: flex;  
            width: 100%;  
        }
        
        th{
            background:#0a4d68;
            color:var(--main-color);
        }
        tr:nth-child(even){background:#f2f2f2}
        textarea{
            border:solid;
        }
        .dairies{
            text-align: center;
            justify-content: center;
        }
        .reviews{
            text-align: center;
            justify-content: center;
        }
        h3:hover{
            text-decoration: underline;
            transition-duration: 2s;
        }

    </style>
</head>

<body>
    <!--header starts-->
    <header class="header">

        <a href="#" class="logo">Get Dairies milk</a>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About Us</a>
            <a href="#dairies">Dairies</a>
            <a href="#reviews">Reviews</a>
            <a href="re.php">Log-out</a>
        </nav>

    </header>
    <!--header ends-->

    <!--home starts-->
    <section class="home" id="home">
        <div class="container">
            <h2>Welcome to place to find about the best milk in the city</h2>
            <a href="Hread.php" class="btn">Read more</a>
        </div>


    </section>
    <!--home ends-->

    <!--about us starts-->
    <section class="about" id="about">
    <h1 class="heading" style="width: 100vw; display: flex; justify-content: center; align-items: center; background:#0a4d68">
        About Us
    </h1>
    <div class="row" style="display: flex; align-items: center; gap: 20px; max-width: 90vw; margin: auto;">
        <!-- Image on the Left -->
        <div class="image" style="width: 35vw;">
            <img src="2.jpg" alt="Fresh Milk" style="width: 100%; height: auto; border-radius: 10px;">
        </div>

        <!-- Content on the Right -->
        <div class="content" style="width: 65vw; text-align: left;">
            <h3>Our vision is to be the best platform for finding fresh milk in your city.</h3>
            <p>We make it easy for you to locate fresh milk from trusted sources in your area. 
                Whether you're looking for organic options or local dairy farms, we connect you 
                with the best choices available.</p>
            <a href="Aread.php" class="btn">Read More</a>
        </div>
    </div>
</section>



    <!--about us ends-->

    <!--dairies starts-->

    <section class="dairies" id="dairies">
        <h1 class="heading" style="background:#0a4d68; width: 100vw; display: flex; justify-content: center; align-items: center; "> get dairies</h1>
        <br>
        <p><h3>This is table to see the details about Dairies the provide Milk</h3></p>
        <div class="d-info">
        <table >
            <tr>
                <th>Dairy-id</th>
                <th>Dairy-name</th>
                <th>Dairy-number</th>
                <th>Milk-price</th>
                <th>Milk-type</th>
            </tr>
            <?php
            $conn=mysqli_connect("localhost","root","","mas");
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
                        </tr>";
                }
                echo "</table>";

            }
            else{
                echo "No dairy are Recorded";
            }
            $conn-> close();


            ?>
        </table>
        </div>
    </section>
    <!--dairies ends-->

    <!--review starts-->
    <section class="reviews" id="reviews">
        <br>
        <h1 class="heading" style="background:#0a4d68; width: 100vw; display: flex; justify-content: center; align-items: center;">client's review</h1>
            <form text-align="center" action="view.php" method="POST" name="input">

             <textarea name="review" id="review" cols="40" rows="10" plceholder="Give Your review"></textarea>
                <button class="btn" name="give" id="give">Submit</button>

            </form>
            <p></p>
    </section>

    <!--review ends-->

    <!--footer starts-->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>quick links</h3>
                <ul class="list">
               <li><a href="#home" >Home</a></li>
               <li><a href="#about" >About Us</a></li>
               <li><a href="#dairies">Dairies</a></li>
               <li><a href="#reviews">Reviews</a></li>
               <li><a href="re.php">Log-out</a></li>
                </ul>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#">8780961109</a>
                <a href="#">9723797878</a>
                <a href="#">parikshitgohil836@gmail.com</a>
                <a href="#">gohilabhijitsinh078@gmail.com</a>
            </div>
            <div class="box">
                <h3>follow us on insta</h3>
                <a href="#">gohil_parikshitsinh_</a>
                <a href="#">ab_gohil_78</a>
            </div>
        </div>
        <div class="bottom-bar">
            <h3>&copy: 2025 Parikshitsinh and Abhijitsinh. All rights are reserve</h3>
        </div>
    </section>

    <!--footer ends-->

    <script src="insc.js"></script>
</body>

</html>