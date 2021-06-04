<?php
require_once('database.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
   
    $isUsernameValid = filter_var(
        $username,
        FILTER_VALIDATE_EMAIL
    );
    
    $pwdLenght = mb_strlen($password);
 
    
    
    if ($cpassword != $password ) {
        echo "<script>
    alert('Password non corretta');
    window.location.href='../register.html';
    </script>"; 
        
    }
    elseif (false === $isUsernameValid) {
        echo "<script>
            alert('Lo username non è valido. \\n Sono ammessi solamente caratteri alfanumerici e l\'underscore. \\n Lunghezza minina 3 caratteri. \\n Lunghezza massima 20 caratteri');
             window.location.href='../register.html';
                </script>";
        $msg = 'Lo username non è valido. Sono ammessi solamente caratteri 
                alfanumerici e l\'underscore. Lunghezza minina 3 caratteri.
                Lunghezza massima 20 caratteri';
    } elseif ($pwdLenght < 8 || $pwdLenght > 20) {
                echo "<script>
            alert('Lunghezza minima password 8 caratteri e massima 20');
             window.location.href='../register.html';
                </script>";
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = "
            SELECT email
            FROM utenti
            WHERE email = :username
        ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($user) > 0) {
            echo "<script>
            alert('E-mail già in uso');
             window.location.href='../register.html';
                </script>"; 
        } else {
            $query = "
                INSERT INTO utenti
                VALUES (:username, :password, 0)
            ";
        
            $check = $pdo->prepare($query);
            $check->bindParam(':username', $username, PDO::PARAM_STR);
            $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $check->execute();
            
            if ($check->rowCount() > 0) {
                echo "<script>
                alert('Registrazione terminata con successo');
                window.location.href='../login.html';
                </script>"; 
            } else {
                $msg = 'Problemi con l\'inserimento dei dati %s';
            }
        }
    }
    
   
}