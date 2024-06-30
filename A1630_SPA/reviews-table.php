<?php
  // Connect to the database
  include "connection.php";
  session_start();
  // Retrieve the review data
  $user_id = $_SESSION['User_Id'];
  $sql = 'SELECT * FROM reviews WHERE User_Id = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_id]);

  if ($stmt->rowCount() > 0) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
  } else {
    echo json_encode([]);
  }
?>