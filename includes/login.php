<?php
include "db.php";
session_start();

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_stmt = $db->prepare($query);
        $select_stmt->execute();
        $row = $select_stmt -> fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            $db_username = $result['username'];
            $db_password = $result['user_password'];
            $db_user_role = $result['user_role'];
            $db_user_id = $result['user_id'];


        }

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
    $password = crypt($password, $db_password);


    if ($username != $db_username && $password != $db_password )
    {
        header("Location: ../index.php");
    }
   else if ($username  == $db_username && $password == $db_password )
    {
        $_SESSION['username'] = $db_username;
        $_SESSION['user_role'] = $db_user_role;
        $_SESSION['user_id']  = $db_user_id;


        header("Location: ../admin");
    }
   else
   {
       header("Location: ../index.php");
   }
}
?>