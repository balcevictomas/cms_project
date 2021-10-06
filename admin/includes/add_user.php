<?php
if(isset($_POST['create_user']))
{
    //$user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['select_role'];




    try{
        $insert_stmt = $db->prepare("INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES 
      ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}','{$user_password}')");
        $insert_stmt->execute();
        echo "User was created: <a href='users.php'>View Users</a>";

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
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title"">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category ID</label>
        <br>
        <select name="select_role" id="">
            <option value ="user">Select options</option>
           <option value ="admin">Admin</option>
            <option value ="user">User</option>
        </select>
    </div>


    <div class="form-group">
        <label for="username"">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="title"">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="password"">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
   <!-- <div class="form-group">
        <label for="title"">Post Image</label>
        <input type="file" name="image">
    </div>
-->

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add user">

    </div>













</form>