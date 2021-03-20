<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription App | Full Stack PHP Subscriber Application</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <?php
    $conn = mysqli_connect("localhost", "root", "root", '');
    if (!$conn)
        die("Connection error" . mysqli_error($conn));
    echo "<p style='color:white; background:green'>Connection successful...</p>";
    // Check if users Database Exists
    $db = mysqli_select_db($conn, "users");
    if (empty($db)) {
        echo "<p style='color:white; background:red'>Database was not found!</p>";

        // Create users Database
        $dbcr = "create database users";
        $check = mysqli_query($conn, $dbcr);
        if (!$check)
            echo "Database Create Error";
        else echo "<p style='color:white; background:green; font-weight:bold'>Database was created successfully!</p>";
    } else {
        echo "<p style='color:white; background:green; font-weight:bold'>Database already exists...!</p>";
        // Creates table user_info if not exist
        $table = "SELECT * FROM user_info";
        $checktable = mysqli_query($conn, $table);
        if (!$checktable) {
            echo "<p style='color:white; background:red'>The Table was not found, please create the Table...!</p>";
            // Creating the Table
            $createTBL = "CREATE TABLE user_info (
            id int(100) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            PRIMARY KEY(id)
            )";
            $ok = mysqli_query($conn, $createTBL);
        } else {
            echo "<p style='color:white; background:green; font-weight:bold'>Table already exists...!</p>";
        }
    };

    ?>
</head>

<body>
    <input type="checkbox" id="toggle">
    <label for="toggle" class="show-btn">Show Modal</label>
    <div class="wrapper">
        <label for="toggle">
            <i class="cancel-icon fas fa-times"></i>
        </label>
        <div class="icon"><i class="far fa-envelope"></i></div>
        <div class="content">
            <header>Become A Subscriber!</header>
            <p>Subscribe to our blog and get the latest updates straight to your inbox.</p>
        </div>
        <form action="index.php" method="POST">
            <?php
            $userEmail = ""; // First, leave email field blank
            if (isset($_POST['subscribe'])) { // When the Subscribe button is clicked
                $userEmail = $_POST['email']; // Get Email Input
                if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) { // Validate Email Input
                    // echo "Email is correct";
                    $subject = "Thanks for Subscribing to [My Subscriber Application] - Michael O'Grady";
                    $message = "Thanks for Subscribing to my Channel. You'll always recieve the latest updates from us. We won't share or sell your information to anyone.";
                    $sender = "From: mogrady.professional@gmail.com"; //This email is the email which you put while configuring XAMPP folder
                    if (mail($userEmail, $subject, $message, $sender)) { // PHP Function to send email
            ?>
                        <!-- Styling for Success Message if Email is Sent Correctly! -->
                        <div class="alert success-alert"><?php echo $userEmail ?><br>Thanks for Subscribing!</div>
                        <?php

                        $sql = "INSERT INTO user_info (name, email, password)
                        VALUES ('','$userEmail','')";

                        if (mysqli_query($conn, $sql)) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        };
                        $userEmail = ""; // Again, leave email field blank once email is sent
                    } else {
                        ?>
                        <!-- Styling an error message if the email can't be sent -->
                        <div class="alert error-alert">Failed while sending your email!</div>
                    <?php
                    }
                } else {
                    // echo "Invalid Email";
                    ?>
                    <!-- Styling for Invalid Email Alert -->
                    <div class="alert error-alert"><?php echo $userEmail ?> is not a valid email!</div>
            <?php
                }
            }
            ?>
            <div class="field">
                <input type="text" name="email" placeholder="Email Address" required value="<?php echo $userEmail ?>">
            </div>
            <div class="field btn">
                <div class="layer"></div>
                <button type="submit" name="subscribe">Subscribe</button>
            </div>
        </form>
        <div class="text">We do not share your information.</div>
    </div>
</body>

</html>