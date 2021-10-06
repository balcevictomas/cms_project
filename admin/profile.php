<?php

include "includes/admin_header.php";
if (isset($_SESSION['username']))
{

    echo $username = $_SESSION['username'];
    try {
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_stmt = $db->prepare($query);
        $select_stmt->execute();
        $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            $username = $result['username'];
            $user_password = $result['user_password'];
            $user_firstname = $result['user_firstname'];
            $user_lastname = $result['user_lastname'];
            $user_email = $result['user_email'];

        }

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

}
if(isset($_POST['edit_user']))
{
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $_SESSION['username'] = $username;




    try{

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";

        $query .= "username = '{$username}', ";

        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}' ";
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

    <div id="wrapper">

    <!-- Navigation -->
    <?php
    include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome Admin
                        <small>Autorinho</small>

                    </h1>

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
                            <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">

                        </div>













                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>