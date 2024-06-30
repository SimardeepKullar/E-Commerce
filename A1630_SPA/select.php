<?php 
    if (!isset($_COOKIE['admin'])){
        header("Location: http://localhost/phpFiles630/A1630_SPA/adminLogin.php");    
    }  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Select DB</title>
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
            <section class="homeSection" style="border: 1px solid white; margin:0px 20px">
                <form method="post">
                    <h1 style="text-align:center">See Table Attributes</h1><br>  
                    <select name="tables">
                        <option value="" disabled selected hidden>Choose a table</option>
                        <option value="Truck_Id, Truck_Code, Availability_Code">Truck Table</option>
                        <option value="User_Id, Name, Tel_No, Email, Address, City_Code, Login_Id, Passwords, Balance">Users Table</option>
                        <option value="Receipt_Id, Store_Code, User_Id, Total_Price">Shopping Table</option>
                        <option value="Item_Id, Item_Name, Price, Made_In, Department_Code, PictureURL">Item Table</option>
                        <option value="Trip_Id, Source_Code, Destination_Code, Distance_KM, Truck_Code, Price">Trip Table</option>
                        <option value="Order_Id, Date_Issued, Date_Received, Total_Price, User_Id, Receipt_Id">Orders Table</option>
                        <option value="Admin_Users, Name, Login_Id, Login_Id">Admin Users Table</option>
                    </select>
                    <button type="submit" name="seeAttributes">See Attributes</button>
                </form>
                <form method="post">
                    <h1 style="text-align:center">Select Query</h1>
                    <label for="select"><b>Query</b></label>
                    <input type="text" id="select" placeholder="SELECT column1, ... FROM table_name;" name="select" required>
                    <button type="submit" name="selectButton">Run Select</button>
                </form>
            </section>
        
            <section class="homeSection" style="margin:0px 20px">
                <h1>Attributes for Selected Table:</h1>
                <p id="attributes">Please select a table.</p>
                <?php
                    if (isset($_POST['seeAttributes'])) {
                        $tableAtt = $_POST['tables'];
                        echo "<script>document.getElementById('attributes').innerHTML = '$tableAtt';</script>";
                    }
                ?>
                <h1>Results:</h1>
                <?php
                    require "connection.php";

                    if (isset($_POST['selectButton'])) {
                        $query = $_POST['select'];

                        $statement = $pdo->prepare($query);
                        $statement->execute();
                        
                        if (preg_match('/\bFROM\s+(\w+)/i', $query, $matches)) {
                            $table_name = $matches[1];
                        }
                        $describe = $pdo->prepare("DESCRIBE $table_name");
                        $describe->execute();
                        $columnNames = $describe->fetchAll(PDO::FETCH_COLUMN);

                        echo "<table><thead><tr>";
                        foreach ($columnNames as $columns) {
                            echo "<th>$columns</th>";
                        }
                        echo "</tr></thead><tbody>";
                        while($row = $statement->fetch()) {
                            echo "<tr>";
                            for ($i = 0; $i < count($columnNames); $i++){
                                echo "<td>" . $row[$i] . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
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