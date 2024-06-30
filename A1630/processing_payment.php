
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Order Summary</title>
        <style>
          #map{
            width: 100%;
            height: 100%;
          }    
        </style>
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
        <?php
            require "connection.php";

            session_start();
            $total = $_SESSION['total'];
            $user_id = $_COOKIE['user_id'];
            $name_id = $_COOKIE['name_id'];
            $store_id = $_POST['location'];
            $user_add = $_COOKIE['address'];
            $myArray = $_SESSION['arrayss'];
            $distance = $_POST['distanceHidden'];
            $factAdd = $_POST['factAdd'];
            setcookie('factAdd', $factAdd, time() + (3600));
           
            
            
            
            if ($store_id == "245 Church St, Toronto, ON M5B 1Z4") {
                $Source_Code = "Toronto Warehouse";
            }
            else {
                $Source_Code = "Malton Warehouse";
            }
        ?>
        <?php
            // getting the truck for delivery.
            $statement_truck = $pdo->prepare("SELECT Truck_Code FROM Truck WHERE Availability_Code = 1 ORDER BY Availability_Code LIMIT 1");
            $statement_truck->execute();
            $truck_code = $statement_truck->fetch();
            $truck_code_final = $truck_code[0];

            // getting city code from user table
            $statement_city_code = $pdo->prepare("SELECT City_Code FROM Users WHERE User_Id = '$user_id'");
            $statement_city_code->execute();
            $city_code = $statement_city_code->fetch();
            $city_code_final = $city_code[0];
        
            // inserting into trip table. Trip Id is auto generated in Trip table.
            $statement_trip = $pdo->prepare(
                "INSERT INTO Trip (Source_Code, Destination_Code, Distance_KM, Truck_Code, Price)
                VALUES('$Source_Code', '$city_code_final', '$distance', '$truck_code_final', '$total');");
            $statement_trip->execute();

            // inserting into shopping table. Receipt ID is auto generated in shopping table.
            $statement_shopping = $pdo->prepare(
                "INSERT INTO Shopping (Store_Code, User_Id, Total_Price)
                VALUES('$store_id', '$user_id', '$total');");
            $statement_shopping->execute();

            // getting the receipt id from Shopping table
            $statement_receipt_id = $pdo->prepare("SELECT Receipt_Id FROM Shopping ORDER BY Receipt_Id DESC LIMIT 1");
            $statement_receipt_id->execute();
            $receipt_id = $statement_receipt_id->fetch();
            $receipt_id_final = $receipt_id[0];

            // inserting into orders table. Order ID is auto generated in Orders table.
            $date_added = date("Y-m-d");
            $date_received = date("Y-m-d", strtotime("+ 7 day"));
            $statement_order = $pdo->prepare(
                "INSERT INTO Orders (Date_Issued, Date_Received, Total_Price, User_Id, Receipt_Id)
                VALUES('$date_added', '$date_received', '$total', '$user_id', '$receipt_id_final');");
            $statement_order->execute();

            // updating the balance for the user.
            $statement_get_balance = $pdo->prepare("SELECT Balance FROM Users WHERE User_Id = '$user_id'");
            $statement_get_balance->execute();
            $user_balance = $statement_get_balance->fetch();
            $user_balance_final = $user_balance[0];

            $new_balance = $user_balance_final + $total;

            $statement_update_balance = $pdo->prepare("UPDATE Users set Balance = '$new_balance' WHERE User_Id = '$user_id'");
            $statement_update_balance->execute();

            $statement = $pdo->prepare("SELECT * FROM Orders WHERE Receipt_Id = :receiptID");
            $statement->bindParam(':receiptID', $receipt_id_final);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $row) {
                $order_id = $row['Order_Id'];
            }
        ?>
        <main>
            <section class="homeSection">
                <h1>Thank you for your order!</h1>
                <?php
                    echo "<h3>Invoice for " . $name_id . " - Order Number: " . $order_id . "</h3>";
                ?>
            </section>
            <section class="processSection">
                <?php
                    echo "<h2>Items:</h2><br>";
                    foreach($myArray as $id){
                        $statement = $pdo->prepare("SELECT * FROM Item WHERE Item_Id = '$id'");
                        $statement->execute();
                        while($row = $statement->fetch()) {
                            echo "$" . $row['Price'] . " - ";
                            echo $row['Item_Name'] . "<br>";
                        }
                    }
                    echo "<br>Total: $" . $total . ".00<br>";

                    echo "<br><strong>Truck Number: </strong>" . $truck_code_final;
                    echo "<br><strong>Coming from: </strong>" . $Source_Code . " - " . $factAdd;
                    echo "<br><strong>Deliver to: </strong>" . $user_add. ", " . $city_code_final;
                    echo "<br><strong>Total Distance: </strong>" . $distance . "km";
                ?>
            </section>
            <section class="mapSection2"><div id="map"></div></section>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz9KF31zzZOrPY1L8U1MUIReadDdoL1Js&callback=initMap"></script>
            <script>
                function initMap() {
                    var map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: 43.6532, lng: -79.3832},
                        zoom: 12
                    });

                    var cookies = document.cookie.split(';');
                    var addressCookie = cookies.find(cookie => cookie.trim().startsWith('address='));
                    var address = (addressCookie && addressCookie.split('=')[1]) || '';
                    var userLoc = address.replace(/%20/g, " ");

                    var cookies = document.cookie.split(';');
                    var factCookie = cookies.find(cookie => cookie.trim().startsWith('factAdd='));
                    var factory = (factCookie && factCookie.split('=')[1]) || '';
                    var factoryLoc = factory.replace(/%20/g, " ");

                    var directionsService = new google.maps.DirectionsService();
                    var directionsDisplay = new google.maps.DirectionsRenderer();
                    directionsDisplay.setMap(map);
                        
                    directionsService.route({
                        origin: factoryLoc,
                        destination: userLoc,
                        travelMode: 'DRIVING'
                    }, function(response, status) {
                        if (status === 'OK') {
                            directionsDisplay.setDirections(response);
                            var distanceFromPoints = response.routes[0].legs[0].distance.value / 1000;
                            document.getElementById('printDistance').innerHTML = "Store Distance: " + distanceFromPoints.toFixed(2) + " km";
                            document.getElementById('factAdd').value = factoryLoc;
                            document.getElementById('distanceHidden').value = distanceFromPoints.toFixed(2);
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                }
            </script>
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