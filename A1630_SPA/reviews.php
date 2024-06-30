<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<?php
    session_start();
    // if (isset($_COOKIE['user'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: http://localhost/phpFiles630/A1630_SPA/login.php');
    }
?>
<section ng-app="myApp" ng-controller="formcontroller" class="review">
    <h2 class="Reviews-title">Your Reviews</h2>
    <div id="review-tables-wrapper">
        <table id="review-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Service Rating</th>
                <th>Review</th>
                <th>Product Rating</th>
                <th>Item ID</th>
                <th>User ID</th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="review in reviews">
                    <td>{{ review.Review_Id }}</td>
                    <td>{{ review.ServiceRating }}</td>
                    <td>{{ review.Review }}</td>
                    <td>{{ review.RN }}</td>
                    <td>{{ review.Item_Id }}</td>
                    <td>{{ review.User_Id }}</td>
                </tr>
                <tr ng-if="reviews.length == 0">
                    <td colspan="6">Currently no reviews, add one below!</td>
                </tr>
            </tbody>
        </table>
        <div class="container">
            <form name="reviewForm" ng-submit="insertData()">
                <h2 style="text-align:center">Add a review</h2>
                <div class="review-gap">
                    <label for="rating"><b>Service Rating (1=Worst, 5=Best)</b></label>
                    <div id="radioGroup">
                        <input type="radio" name='ServiceRating' ng-model="insert.ServiceRating" ng-value='1' required>
                        <label for="1">1</label>
                        <input type="radio" name='ServiceRating' ng-model="insert.ServiceRating" ng-value='2'>
                        <label for="2">2</label>
                        <input type="radio" name='ServiceRating' ng-model="insert.ServiceRating" ng-value='3'>
                        <label for="3">3</label>
                        <input type="radio" name='ServiceRating' ng-model="insert.ServiceRating" ng-value='4'>
                        <label for="4">4</label>
                        <input type="radio" name='ServiceRating' ng-model="insert.ServiceRating" ng-value='5'>
                        <label for="5">5</label>
                    </div>
                </div>
                <div class="review-gap">
                    <div id="productDropdown">
                        <label for="product"><b>Choose the product you want to review</b></label>
                        <select id="selectInput" ng-model="insert.product" name="product" required>
                            <option value="">Select a product</option>
                            <?php
                                require "connection.php";
                                $statement = $pdo->prepare("SELECT Item_Id, Item_Name FROM Item");
                                $statement->execute();
                                while ($row = $statement->fetch()){
                                    echo '<option value=" '.$row['Item_Id'].' "> '.$row['Item_Name'].' </option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="review-gap">
                    <label for="rating"><b>Product Rating (1=Worst, 5=Best)</b></label>
                    <div id="radioGroup">
                        <input type="radio" name='rating' ng-model="insert.rating" ng-value='1' required>
                        <label for="1">1</label>
                        <input type="radio" name='rating' ng-model="insert.rating" ng-value='2'>
                        <label for="2">2</label>
                        <input type="radio" name='rating' ng-model="insert.rating" ng-value='3'>
                        <label for="3">3</label>
                        <input type="radio" name='rating' ng-model="insert.rating" ng-value='4'>
                        <label for="4">4</label>
                        <input type="radio" name='rating' ng-model="insert.rating" ng-value='5'>
                        <label for="5">5</label>
                    </div>
                </div>
                <div class="review-gap">
                    <label for="Review"><b>Review Message</b></label>
                    <input type="text" ng-model="insert.review" name="review" required>
                </div>

                <input ng-click="changeView()" type="submit" name='insert'/>
                <label class="text-success" ng-show="successInsert">{{successInsert}}</label>
            </form>
        </div>
    </div>
</section>

