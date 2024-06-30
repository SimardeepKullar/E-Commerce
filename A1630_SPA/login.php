<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: http://localhost/phpFiles630/A1630_SPA/inventory.php');  
    }
?>
<section class="loginSection">
    <div ng-app="myApp" ng-controller="loginController">
        <form ng-submit="checkLogin()">
            <h1 style="text-align:center">Login page</h1>
            <label for="username"><b>Username</b></label>
            <input type="text" id="username" placeholder="Enter your username" name="username" ng-model="username" required>
                    
            <label for="password"><b>Password</b></label>
            <input type="password" id="password" placeholder="Enter your password" name="password" ng-model="password" required>
                    
            <button type="submit" ng-click="login()">Login</button>
            <button onclick="window.location.href='signup.html'">Sign Up</button> 
        </form>
        <div class="alert alert-success" style="color:red"><center>{{message}}</center></div>
    </div>
</section>