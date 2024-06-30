<?php
    session_start();
    // if (isset($_COOKIE['user'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: http://localhost/phpFiles630/A1630_SPA/index.html#!/login');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Home Page</title>
    </head>
    <body>
        <header>
            <div style="align-items: center; display: flex; margin: 0 30px;">
                <img src="images/sneakerStudio2.png" style="width:300px; height:auto;">
            </div>
        </header>
        
        <nav>
            <ul style="align-items: center; justify-content: center;">
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html">Home</a></li>
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/aboutus">About Us</a></li>
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/contact">Contact</a></li>
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/inventory">Shopping Cart</a></li>
                <li><a href="form_payee.php">Pay Bill</a></li>
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/typeServices">Types of Services</a></li>
                <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/reviews">Reviews</a></li>
                <li class="dropdown">
                    <a href="#">Sign In &#9662;</a>
                    <ul class="dropdown-menu">
                        <li><a href="http://localhost/phpFiles630/A1630_SPA/index.html#!/login">Member Login</a></li>
                        <li><a href="adminLogin.php">Admin Login</a></li>
                    </ul>
                </li>
                <li><a href="signup.html">Sign Up</a></li>
                <li class="dropdown">
                    <a href="#"><img src="images/db.png" alt=""></a>
                    <ul class="dropdown-menu">
                      <li><a href="insert.php">Insert</a></li>
                      <li><a href="delete.php">Delete</a></li>
                      <li><a href="select.php">Select</a></li>
                      <li><a href="update.php">Update</a></li>
                    </ul>
                </li>
                <li><a href="search.php"><img src="images/search.png" alt=""></a></li> 
            </ul>
        </nav>

        <form action="<?=$_SERVER['PHP_SELF']?>">
            Amount to pay <input type="text" name="payable">
            <p id="overPay"></p>
            <button type="submit">Pay</button>
        </form>
        <form>
            <p id="balance"></p>
        </form>
    </body>
    <?php
        require "connection.php";

        $user_id = $_COOKIE['user_id'];
        $name_id = $_COOKIE['name_id'];
        $balance = $_GET['payable'];

        $card_number = $_POST['card_number'];
        $security_code = $_POST['security_code'];
        $expiry_date = $_POST['expiry_date'];
        
        if ($card_number != "") {
            $statement = $pdo->prepare("SELECT salt FROM Users WHERE Login_Id = ?" );
            $statement->execute([$username]);
            $results = $statement->fetch();
            $salt = $results[0];
            // salt

            $card_number = md5($card_number.$salt);
            $security_code = md5($security_code.$salt);
            $expiry_date =  md5($expiry_date.$salt);
            $statement_card = $pdo->prepare(
                "INSERT INTO cards (card_number, security_code, expiry_date, balance_take, User_Id)
                VALUES('$card_number','$security_code','$expiry_date','-5','$user_id');");
            $statement_card->execute();
        }
    
        // to get salt 
        if ($balance != 0){
            $statement_card = $pdo->prepare(
            "UPDATE cards SET balance_take = ? WHERE User_Id = ? AND balance_take = -5");
            $statement_card->execute([$balance,$user_id]);
        }

        $statement_get_balance = $pdo->prepare("SELECT Balance FROM Users WHERE User_Id = '$user_id'");
        $statement_get_balance->execute();
        $user_balance = $statement_get_balance->fetch();
        $user_balance_final = $user_balance[0];

        if ($user_balance_final > 0 ) {
            echo "<script>document.getElementById('balance').innerHTML = 'Balance to Pay: $' + $user_balance_final.toFixed(2);</script>";
            $new_balance = $user_balance_final - $balance;
            if ($balance >= 0 && $new_balance >= 0) {
                $statement_update_balance = $pdo->prepare("UPDATE Users set Balance = '$new_balance' WHERE User_Id = '$user_id'");
                $statement_update_balance->execute();
        
                $statement_get_balance = $pdo->prepare("SELECT Balance FROM Users WHERE User_Id = '$user_id'");
                $statement_get_balance->execute();
                $user_balance = $statement_get_balance->fetch();
                $user_balance_final = $user_balance[0];
                echo "<script>document.getElementById('balance').innerHTML = 'Balance to Pay: $' + $user_balance_final.toFixed(2);</script>";
                echo "<script>document.getElementById('overPay').innerHTML = '';</script>";  
            } else if ($new_balance < 0) {
                echo "<script>document.getElementById('overPay').innerHTML = 'Please do not exceed how much owe.';</script>";
                echo "<script>document.getElementById('overPay').style.color = 'red';</script>";
            }
        } else {
            echo "<script>document.getElementById('balance').innerHTML = 'Balance to Pay: $0.00';</script>";
        }
    ?>
    <footer>
        <p>&copy; 2023 Smart Customer Service. All rights reserved.</p>
        <p id="browser"></p>
        <script>
            var userAgent = navigator.userAgent;
        
            if (userAgent.match(/chrome/i)){
                document.getElementById("browser").innerHTML = "Browser: Google Chrome";
            } else if (userAgent.match(/Firefox/i)){
                document.getElementById("browser").innerHTML = "Browser: Firefox";
            } else if (userAgent.match(/Trident|EI|Internet Explorer/i)){
                document.getElementById("browser").innerHTML = "Browser: Internet Explorer";
            } else {
                document.getElementById("browser").innerHTML = "Browser: Unknown";
            }
        </script>
    </footer>
</html>