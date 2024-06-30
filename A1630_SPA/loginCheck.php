<?php 
    include "connection.php";
    session_start();
    $form_data = json_decode(file_get_contents("php://input"));
    $data = array();
    $error = array();

    $username = $form_data->username;
    $password = $form_data->password;

    $statement = $pdo->prepare("SELECT salt FROM Users WHERE Login_Id = ?" );
    $statement->execute([$username]);
    $results = $statement->fetch();
    if($results == null ) {
        $out['error'] = true;
        $out['message'] = 'Invalid Username';
    }

    $reSalt = $results[0];
    $hashedP = md5($password.$reSalt);
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE passwords = ? AND Login_Id = ?");
    
    $stmt->bindValue(1, $hashedP); // bind $password to the first placeholder "?"
    $stmt->bindValue(2, $username); // bind $username to the second placeholder "?"
    $stmt->execute();
    $results = $stmt->fetchAll();
    
    if (count($results) > 0) {
        $User_Id = $results[0]['User_Id'];
        $_SESSION['User_Id']=$User_Id;
        $_SESSION['user']=$username;
        $statement = $pdo->prepare("SELECT User_Id FROM Users WHERE Login_Id = ?" );
        $statement->execute([$username]);
        $results = $statement->fetch();
        setcookie('user_id', $results[0], time() + (3600));
        $statement = $pdo->prepare("SELECT Name FROM Users WHERE Login_Id = ?" );
        $statement->execute([$username]);
        $results = $statement->fetch();
        setcookie('name_id', $results[0], time() + (3600));
        $statement = $pdo->prepare("SELECT address FROM Users WHERE Login_Id = ?" );
        $statement->execute([$username]);
        $results = $statement->fetch();
        setcookie('address', $results[0], time() + (3600));
        setcookie('admin', "", time() - (3600));
        $out['message'] = 'Login Successful';
        header("Location: http://localhost/phpFiles630/A1630_SPA/index.html#!/inventory");
    } else {
        // invalid login
        $out['error'] = true;
        $out['message'] = 'Invalid Login';
    }
    echo json_encode($out);
?>