<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Reviews</title>
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
            <section class="review">
                <div class="container">
                    <h2 class="Reviews-title">Your Reviews</h2>

                    <div id="review-tables-wrapper">
                        <table id="review-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Review Type</th>
                                    <th>Review</th>
                                    <th>Rating # (1-5)</th>
                                    <th>Item ID</th>
                                    <th>User ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Connect to the database
                                    include "connection.php";
                                    session_start();

                                    // Retrieve the review data
                                    $user_id = $_COOKIE['user_id'];
                                    $sql = 'SELECT * FROM reviews WHERE user_id = ?';
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$user_id]);

                                    if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch()) {
                                            echo '<tr>';
                                            echo '<td>' . $row[0] . '</td>';
                                            echo '<td>' . $row[1] . '</td>';
                                            echo '<td>' . $row[2] . '</td>';
                                            echo '<td>' . $row[3] . '</td>';
                                            echo '<td>' . $row[4] . '</td>';
                                            echo '<td>' . $row[5] . '</td>';
                                            echo '</tr>';

                                            // Save the data as cookies
                                            setcookie("review_" . $row['id'], $row['id'] . "|" . $row['reviewType'] . "|" . $row['review'] . "|" . $row['rating'] . "|" . $row['itemId'] . "|" . $row['userId']);
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No reviews found</td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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