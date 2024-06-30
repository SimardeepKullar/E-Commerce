<?php
    session_start();
    // if (isset($_COOKIE['user'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: http://localhost/phpFiles630/A1630_SPA/login.php');
    }
?>
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
<section id="items" style="overflow:auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
    <h3 style="margin-top:3px">Shopping List</h3>
    <?php 
        require "connection.php";
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
<section id="shoppingCart" style="overflow:auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
    <div style="display: flex; gap:20px; margin-bottom: 20px">
        <h3 style="margin-top:3px">Shopping Cart</h3>
        <button type="button" id="button" class="button-3">Check Out</button>
    </div>
</section>


<script>
    document.getElementById("button").addEventListener("click", counter);
        
    function counter() {
        var item_array = [];
        var y = document.getElementById("shoppingCart").querySelectorAll(".cart");
          
        for(var i=0; i<y.length; i++){
            item_array[i] = y[i].id;
        }
        
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