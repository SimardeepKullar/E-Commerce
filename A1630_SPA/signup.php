<?php
    require "connection.php";
    require "signup.html";

    function generateRandomSalt(){
        return base64_encode(random_bytes(12));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $City_Code = $_POST['City_Code'];

        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            echo "<p text-align: center;>Only letters allowed! retry</p>";
            return false;
        } elseif (!preg_match("/^[0-9]{10}$/", $tel)) {
            echo "<p text-align: center;>Invalid Telephone Number format!</p>";
            return false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p text-align: center;>Invalid Email Address!</p>";
            return false;
        } elseif (!preg_match("/^[a-zA-Z0-9_]{5,}$/", $username)) {
            echo "<p text-align: center;>Invalid Username format, must be 5 long numbers and letters only</p>";
            return false;
        } else {
            $statement = $pdo->prepare("SELECT * FROM Users WHERE Email = ? OR Login_Id = ?" );
            $statement->execute([$email, $username]);
            $results = $statement->fetch();
            if($results != null ) {
                echo "<p style='text-align:center ; color:red;'> Username or email is taken try again <p><br>";
            } else {
                $salt = generateRandomSalt();
                $sql = $pdo->prepare("INSERT INTO Users (Name, Tel_No, Email, Address, City_Code, Login_Id, Passwords, Balance, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $send = md5($password.$salt);
                $sql->execute([$name, $tel, $email, $address, $City_Code, $username, $send, 0, $salt]);
                echo "<p style='text-align:center;'> Account Created! Click \"Already have an account?\".<p><br>";
            }     
        }
    }
?>