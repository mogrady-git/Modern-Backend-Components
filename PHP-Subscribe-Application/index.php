<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription App | Full Stack PHP Subscriber Application</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
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
        <p><a href="production/index.php">Move to the Production Version</a></p>
    </div>
</body>

</html>