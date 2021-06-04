<?php
session_start();
require_once('database.php');

if (isset($_SESSION['session_id'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $query = "
            SELECT email, passw
            FROM utenti
            WHERE email =:username
        ";
      
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
      
        $user = $check->fetch(PDO::FETCH_ASSOC);
       
        if (!$user || password_verify($password, $user['passw']) === false) {
            $msg = 'Credenziali utente errate %s';
        } else {
            
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['email'];
            
            
            header('Location: ../index.php');
            exit;
        }
    }
    
    printf($msg, '<a href="../login.html">torna indietro</a>');
}
?>