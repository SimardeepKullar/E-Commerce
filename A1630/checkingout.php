<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="images/favicon.png">
        <title>Check Out</title>
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
          session_start();

          require "connection.php";
          echo "<br>";
        ?>
        <main>
        <section class="checkOutSection">
        <form class="store" method="GET">
            <label>Promo Code:</label><br>
            <input id='pcode' name='pcode' type="text"></input>
            <button type="submit">promo code</button>

        </form>
        <?php
       
        $good = false;
        if(isset($_GET['pcode'])) {
            if ($_GET['pcode'] != "" ) {
                $pcode = $_GET['pcode'];
                $statement = $pdo->prepare("SELECT * FROM PromoCode WHERE promocodes = '$pcode' and used = false;");
                $statement->execute();
                $results = $statement->fetch();
                if($results == null ) {
                    echo "<p style='color:red ; text-align:center'; >* code is invalid or used try Again *</p>";
                }
                else {
                    echo "<p style='color:green ; text-align:center'; >valid code</p>";
                    //$takeaway = 100;
                    $good = true;
                    $statement = $pdo->prepare("UPDATE PromoCode SET used=true WHERE promocodes='$pcode';");
                    $statement->execute();
                }
            }
            else {
                echo "<p style='color:red ; text-align:center'; >* no code entered *</p>";
            }
       
        }

        ?>
        <?php
            $total = 0;
            if(isset($_POST['myArray'])) {
                $myArray = json_decode($_POST['myArray']);
                $_SESSION['arrayss'] =  $myArray;
            }
            echo "<h2>Items:</h2><br>";
            
            foreach($myArray as $id){
                $statement = $pdo->prepare("SELECT * FROM Item WHERE Item_Id = '$id'");
                $statement->execute();
                while($row = $statement->fetch()) {
                    $curr = $row['Price'];
                    echo $row['Item_Name'] . "<br>";

                    $total = $total + $curr;
                }
            }
            if ($total != 0 ){
              $_SESSION['total'] = $total;
            }
            echo "<br>Total price of the order is: $" . $_SESSION['total'] . ".00";

            if ($good == TRUE){
            echo "<br> total saving with code is:  -100.00";
            $_SESSION['total'] = $_SESSION['total'] - 100;
             echo "<br>New price of the order is: $" . $_SESSION['total'] . ".00";
            }
        ?>
        <br><br>
        <form class="store" method="POST" action="processing_payment.php">
            <label>Store Locations:</label><br>
            <input required type="radio" name="location" onclick="selectMap()" id="radioButton1" value="245 Church St, Toronto, ON M5B 1Z4">
            <label id="loc1" name="loc1" for="radioButton1">Toronto Warehouse</label><br>

            <input required type="radio" name="location" onclick="selectMap()" id="radioButton2" value="6900 Airport Rd, Mississauga, ON L4V 1E8">
            <label id="loc2"name="loc2" for="radioButton2">Malton Warehouse</label><br>

            <p id="printDistance" name="printDistance"></p>
            <input hidden id="factAdd" name="factAdd"></input>
            <input hidden id="distanceHidden" name="distanceHidden"></input>

            <button type="submit" value="submit">Proceed to Payment</button>
        </form>
        </section>
        <section class="mapSection1"><div id="map"></div></section>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz9KF31zzZOrPY1L8U1MUIReadDdoL1Js&callback=initMap"></script>
        <script>
            function selectMap(){
                if (document.getElementById('radioButton1').checked) {
                    var factoryLoc = document.getElementById("radioButton1").value;
                    initMap2(factoryLoc);
                } else if (document.getElementById('radioButton2').checked) {
                    var factoryLoc = document.getElementById("radioButton2").value;
                    initMap2(factoryLoc);
                }
            }

            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 43.6532, lng: -79.3832},
                    zoom: 12
                });
            }

            function initMap2(factoryLoc) {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 43.6532, lng: -79.3832},
                    zoom: 12
                });

                var cookies = document.cookie.split(';');
                var addressCookie = cookies.find(cookie => cookie.trim().startsWith('address='));
                var address = (addressCookie && addressCookie.split('=')[1]) || '';
                var userLoc = address.replace(/%20/g, " ");

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