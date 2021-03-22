<?php
session_start();
include_once "config.php";
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // email validation check
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // if email is valid...
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) { // if email already exists
            echo "$email - This email already exist!"; // alert for duplication email
        } else { // validation to check for upload file - also must include the enctype="multipart/form-data" attribute to the form element on the index.php page
            if (isset($_FILES['image'])) {  // $_FILES[] returns array with file: name, type, tmp_name
                $img_name = $_FILES['image']['name']; // get image name
                $img_type = $_FILES['image']['type']; // get image type
                $tmp_name = $_FILES['image']['tmp_name']; // temp name to save/move file to server
                // explode image and get last extension name
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode); //get the extension of the file

                $extensions = ["jpeg", "png", "jpg"]; //valid img extensions stored as array
                if (in_array($img_ext, $extensions) === true) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types) === true) {
                        $time = time();
                        //returns the current time as while uploading into our server it will be renamed with current time metadata
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) { //location where image file is stored; if successful
                            $ran_id = rand(time(), 100000000); //creates random id for user
                            $status = "Active now"; //when user signs up status becomes active
                            $encrypt_pass = md5($password);
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                            if ($insert_query) {
                                //insert all user data to database table
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                } else {
                                    echo "This email address not Exist!";
                                }
                            } else {
                                echo "Something went wrong. Please try again!";
                            }
                        }
                    } else {
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                } else {
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
