<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Search Page</title>
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
        
        <main>
            <section class="checkoutSection" style="border: 1px solid white">
                <form method="post">
                    <h1 style="text-align:center">Search Order</h1>
                    <label for="username"><b>User Name</b></label>
                    <input type="text" id="userName" placeholder="Enter your Username" name="userName" required>
                    
                    <label for="password"><b>Order ID</b></label>
                    <input type="text" id="orderID" placeholder="Enter the Order ID" name="orderID" required>
                    
                    <button type="submit" name="searchButton">Search</button>
                </form>
            </section>
            <section class="outputSection">
                <h1>Results:</h1>
                <?php
                    require "connection.php";

                    if (isset($_POST['searchButton'])) {
                        $order_id = $_POST['orderID'];
                        $user_name = $_POST['userName'];
                        $statement = $pdo->prepare("SELECT * FROM Users WHERE Login_Id = :username");
                        $statement->bindParam(':username', $user_name);
                        $statement->execute();
                        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $row) {
                            $user_id = $row['User_Id'];
                        }
                        
                        $statement = $pdo->prepare("SELECT * FROM Orders WHERE Order_Id = :orderID AND User_Id = :userID");
                        $statement->bindParam(':orderID', $order_id);
                        $statement->bindParam(':userID', $user_id);
                        $statement->execute();
                        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($results as $row) {
                            echo "<p><strong>Order ID: </strong>" . $row['Order_Id'] . "</p>";
                            echo "<p><strong>Username: </strong>" . $user_name . "</p>";
                            echo "<p><strong>User ID: </strong>" . $row['User_Id'] . "</p>";
                            echo "<p><strong>Receipt ID: </strong>" . $row['Receipt_Id'] . "</p>";
                            echo "<p><strong>Date Ordered: </strong>" . $row['Date_Issued'] . "</p>";
                            echo "<p><strong>Delivery: </strong>" . $row['Date_Received'] . "</p>";
                            echo "<p><strong>Total: </strong>" . "$" . $row['Total_Price'] . "</p>";
                        }
                    }
                ?>
            </section>
        </main>
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