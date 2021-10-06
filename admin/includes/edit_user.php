<?php

if(isset($_GET['id']))
{
$user_id = $_GET['id'];
    try {
        $select_stmt = $db->prepare("SELECT * FROM users where user_id={$user_id}");
        $select_stmt->execute();
        $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result) {


           $username = $result['username'];
            $user_password = $result['user_password'];
            $user_firstname = $result['user_firstname'];
            $user_lastname = $result['user_lastname'];
            $user_email = $result['user_email'];
            $user_image = $result['user_image'];
            $user_role = $result['user_role'];


        }

    } catch (PDOException $e) {
        $e->getMessage();
    }




}

if(isset($_POST['edit_user']))
{
    //$user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['select_role'];

    $query = "SELECT randSalt from users";
    try{
        $query_stmt = $db->prepare($query);
        $query_stmt ->execute();
        $row = $query_stmt->fetch();
        $salt = $row['randSalt'];
        echo $salt;
        $hash_password = crypt($user_password, $salt);


    }
    catch (PDOException $e)
    {
        $e ->getMessage();
    }




    try{

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";

        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hash_password}' ";
        $query .= "WHERE user_id = '{$user_id}' ";

        $update_stmt = $db->prepare($query);
        $update_stmt->execute();
        header("Location:users.php");

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

}




?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title"">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <label for="title"">Lastname</label>
        <input type="text" class="form-control" name="user_lastname"  value="<?php echo $user_lastname ?>">
    </div>

    <div class="form-group">
        <label for="post_category">Role selection</label>
        <br>
        <select name="select_role" id="">

            <option value ="user"><?php echo $user_role ?></option>
            <?php
            if ($user_role == 'admin')
            {
               echo "<option value ='user'>user</option>";
            }
            else
            {
                echo "<option value ='admin'>admin</option>";
            }
            ?>


        </select>
    </div>


    <div class="form-group">
        <label for="username"">Username</label>
        <input type="text" class="form-control" name="username"  value="<?php echo $username ?>">
    </div>
    <div class="form-group">
        <label for="title"">Email</label>
        <input type="email" class="form-control" name="user_email"value="<?php echo $user_email ?>" >
    </div>
    <div class="form-group">
        <label for="password"">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password ?>">
    </div>
    <!-- <div class="form-group">
         <label for="title"">Post Image</label>
         <input type="file" name="image">
     </div>
 -->

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Edit user">

    </div>













</form>