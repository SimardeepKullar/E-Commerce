<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      if (isset($_COOKIE['user'])) {
        // Allow the user to access the page
      } else {
        echo "<h1>Need to login first to access the page</h1>";
        // Redirect the user to the login page
        header('Location: http://localhost/phpFiles630/A1630/login.php');
      }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.png">
    <title>Shopping Cart</title>
    <style>
      #items {
        float: left;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 55%;
        height: 500px;
      }
      #shoppingCart {
        float: left;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 35%;
        height: 500px
      }
    </style>
    <script>
      function allowDrop(ev) {
        ev.preventDefault();
      }
          
      function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
      }
          
      function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));
      }
    </script>
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
      <section id="items" style="overflow:auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
        <h3 style="margin-top:3px">Shopping List</h3>
        <?php 
          require "connection.php";
          echo "<br>";
          $statement = $pdo->prepare("SELECT * FROM Item");
          $statement->execute();
          while($row = $statement->fetch()) {
            $url = $row['PictureURL'];
            $price = $row['Price'];
            $increment = $row['Item_Id'];
            echo "<figure style='float:left' class='cart' draggable='true' ondragstart='drag(event)' id='$increment'>";
            echo "<img draggable='true' height='150px' width='220px' src='$url'>";
            echo "<figcaption>Price: $$price</figcaption></figure>";
            echo "\t";
          }
        ?>
      </section>
      <section id="shoppingCart" style="overflow:auto;" ondrop="drop(event)" ondragover="allowDrop(event)"><h3 style="margin-top:3px">Shopping Cart</h3></section>
      <button type="button" id="button" class="button-3">Check Out</button>
    </main>

      <script>
        document.getElementById("button").addEventListener("click", counter);
        
        function counter() {
          var item_array = [];
          var y = document.getElementById("shoppingCart").querySelectorAll(".cart");
          
          for(var i=0; i<y.length; i++){
            item_array[i] = y[i].id;
          }
          
          //this is the code. Change it styll
          let myForm = document.createElement('form');
          myForm.action = 'checkingout.php';
          myForm.method = 'POST';

          let myInput = document.createElement('input');
          myInput.type = 'hidden';
          myInput.name = 'myArray';
          myInput.value = JSON.stringify(item_array);

          myForm.appendChild(myInput);
          document.body.appendChild(myForm);

          myForm.submit();
        }
      </script>
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