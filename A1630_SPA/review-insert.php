<?php
    include "connection.php";
    session_start();
    $form_data = json_decode(file_get_contents("php://input"));
    $data = array();
    $error = array();

    if(empty($form_data->ServiceRating)) {
        $error["ServiceRating"] = "Service Rating is required";
    }
        
    if(!empty($error)) {
        $data["error"] = $error;
    } else {
        $ServiceRating = $form_data->ServiceRating;
        $Rating = ($form_data->rating);
        $Rating = (int)$Rating;
        $Review = $form_data->review;
        $Item_Id = ($form_data->product);
        $Item_Id = (int)$Item_Id;
        $user_id = $_SESSION['User_Id'];
        $user_id = (int)$user_id;

        // INSERT INTO Reviews (Review_Type, Review, RN, Item_Id, User_Id) VALUES ("PRODUCT", "This is a great product", 5, 1, 1);
        $qry = "INSERT INTO Reviews (ServiceRating, Review, RN, Item_Id, User_Id) VALUES ('$ServiceRating', '$Review', '$Rating', '$Item_Id', '$user_id')";
        $stmt = $pdo->prepare($qry);
        $stmt->execute(); 
        $data["message"] = "Success! Review Added.";
    }
    echo json_encode($data);
?>