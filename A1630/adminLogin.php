<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admin Sign In</title>
      <link href="style.css" rel="stylesheet" type="text/css">
      <link rel="icon" href="images/favicon.png">
  </head>
  <body>
    <header>
            <div style="align-items: center; display: flex; margin: 0 30px;">
                <img src="images/sneakerStudio2.png" style="width:300px; height:auto;">
            </div>
        </header>
        
        
        <nav>
            <ul style="align-items: center; justify-content: center;">
                <li><a href="home.html">Home</a></li>
                <li><a href="aboutus.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
                <!-- <li><a href="systemlogo.html">System Logo</a></li> -->
                <li><a href="inventory.php">Shopping Cart</a></li>
                <li><a href="form_payee.php">Pay Bill</a></li>
                <li><a href="typeServices.html">Types of Services</a></li>
                <li><a href="reviews.php">Reviews</a></li>
                <li class="dropdown">
                    <a href="#">Sign In &#9662;</a>
                    <ul class="dropdown-menu">
                        <li><a href="login.php">Member Login</a></li>
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
      <section class="loginSection">
            <form method="post">
                <h1 style="text-align:center">Admin Login page</h1>
                <label for="username"><b>Username</b></label>
                <input type="text" id="username" placeholder="Enter your username" name="username" required>
            
                <label for="password"><b>Password</b></label>
                <input type="text" id="password" placeholder="Enter your password" name="password" required>
                <label id="wrongPass" style="color:red"></label>
            
                <button type="submit">Login</button>
                <button onclick="window.location.href='signup.html'">Sign Up</button>
            </form>
            <?php 
                include "connection.php";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Check if all required fields are filled
                
                    // Validate input fields
                    
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                
                    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                        echo "<p style='text-align: center; color:red' >username</p>";
                        return false;
                    } else {
                        // All fields are valid. Proceed to store the data in database
                        // Database connection code here
                        // Store the data in the database
                        $statement = $pdo->prepare("SELECT salt FROM Admin_Users WHERE Login_Id = ?" );
                        $statement->execute([$username]);
                        $results = $statement->fetch();

                        if ($results != null ){
                            $reSalt = $results[0];
                            echo "salt:  ". $reSalt. "<br>";
                            echo "md5:  ". md5($password.$reSalt) . "<br>";
                            $statement = $pdo->prepare("SELECT * FROM Admin_Users WHERE passwords = ? AND Login_Id = ?" );

                            $statement->execute([md5($password.$reSalt), $username]);
                            echo "after";
                            $results = $statement->fetch();
                            echo "sooooo on";
                        }

                        if($results == null ) {
                            echo '<script>document.getElementById("wrongPass").innerHTML = "Invalid Username or Password. Try Again.<br><br>"</script>';
                        }
                        else {
                          setcookie('admin', $username, time() + (3600));
                          setcookie('name_id', $username, time() + (3600));
                          setcookie('user', $username, time() + (3600));
                        
                        
                /*
                        
                        $statement = $pdo->prepare("SELECT * FROM Users WHERE passwords = ? OR Login_Id = ?" );
                        $statement->execute([$password, $username]);
                        $results = $statement->fetch();
                        if($results == null ) {
                        echo "<p style='color:red ; text-align:center'; >* wrong password or username try Again *</p>";
                        }
                        else {
                        $statement = $pdo->prepare("SELECT User_Id, Name, address FROM Users WHERE Login_Id = ?" );
                        $statement->execute([$username]);
                        $results = $statement->fetch();
                        setcookie('user_id', $results[0], time() + (3600));
                
                        setcookie('name_id', $results[1], time() + (3600));
                
                
                        setcookie('address', $results[2], time() + (3600));
                        echo "done";
                        */
                        
                        header("Location: http://localhost/phpFiles630/A1630/home.html");
                        }
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
                }
                else if (userAgent.match(/Firefox/i)){
                    document.getElementById("browser").innerHTML = "Browser: Firefox";
                }
                else if (userAgent.match(/Trident|EI|Internet Explorer/i)){
                    document.getElementById("browser").innerHTML = "Browser: Internet Explorer";
                }
                else {
                    document.getElementById("browser").innerHTML = "Browser: Unknown";
                }
            </script>
        </footer>
</html>