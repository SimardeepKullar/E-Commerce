<!DOCTYPE html>
<html>
    <head>
        <?php
            session_start();
            // if (isset($_COOKIE['user'])) {
            if (!isset($_SESSION['user'])) {
                header('Location: http://localhost/phpFiles630/A1630_SPA/index.html#!/login');
            }
        ?>
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
    
        <form method="POST" action="Pay_up.php">
            Name on Credit Card <input type="text" name="name" placeholder="John Dee" required><br>
            Credit Card Number <input type="text" name="card_number" placeholder="xxxx-xxxx-xxxxx" required><br>
            Security Number <input type="text" name="security_code" placeholder="xxx" required><br>
            Expiry Date <input type="text" name="expiry_date" placeholder="dd/mm/year" required><br>
            <button type="submit" value="Submit">Submit</button>
        </form>
    </body>
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