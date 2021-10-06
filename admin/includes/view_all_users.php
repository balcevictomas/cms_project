<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date</th>

    </tr>
    </thead>
    <tbody>
    <?php
    try {
        $insert_stmt = $db->prepare("SELECT * FROM users");
        $insert_stmt->execute();
        $row = $insert_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            $user_id = $result['user_id'];
            echo "<tr>";
            echo '<td>'.$result['user_id'].'</td>';
            echo '<td>'.$result['username'].'</td>';
            echo '<td>'.$result['user_firstname'].'</td>';
            echo '<td>'.$result['user_lastname'].'</td>';

            // echo '<td>'.$result['post_cat_id'].'</td>';

            /*$query = $db->prepare("SELECT * FROM categories WHERE cat_id= {$result['post_cat_id']}");
            $query->execute();
            $row1 = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($row1 as $result1)
            {
                echo "<td>{$result1['cat_title']}</td>";
            }*/

            echo '<td>'.$result['user_email'].'</td>';
           // echo '<td><img width="100 " src="../images/'.$result['post_image'].'"></td>';
            echo '<td>'.$result['user_role'].'</td>';
           /* try
            {
                $select_stmt = $db->prepare("SELECT * FROM posts WHERE post_id= {$result['comment_post_id']}");
                $select_stmt->execute();
                $row2 = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($row2 as $result2)
                {
                   $post_title = $result2['post_title'];
                    $post_id = $result2['post_id'];
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                }


            }
            catch (PDOException $e)
            {
                $e->getMessage();
            }*/

            echo '<td>Info</td>';
            echo "<td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";
            echo "<td><a href='users.php?change_to_user=$user_id'>User</a></td>";
            echo "<td><a href='users.php?source=edit_user&id=$user_id'>Edit</a></td>";
            echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";

        }

    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }

    ?>

    </tbody>

</table>


<?php
if(isset($_GET['change_to_admin']))
{
    $change_id =$_GET['change_to_admin'];

    try {
        $change_stmt = $db->prepare("UPDATE users set user_role ='admin' where user_id = {$change_id}");
        $change_stmt->execute();
        header("Location:users.php");
    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }


   // header("Location:comments.php");


}
if(isset($_GET['change_to_user']))
{
    $change_id =$_GET['change_to_user'];

    try {
        $change_stmt = $db->prepare("UPDATE users set user_role ='user' where user_id = {$change_id}");
        $change_stmt->execute();
        header("Location:users.php");
    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }


    // header("Location:comments.php");


}
if(isset($_GET['approve']))
{
    $approve_id =$_GET['approve'];
    try {

        $approve_stmt = $db->prepare("UPDATE comments set comment_status ='approved'  where comment_id = {$approve_id}");
        $approve_stmt->execute();
        header("Location:comments.php");
    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }





}






if(isset($_GET['delete']))
{
    $delete_stmt = $db->prepare("DELETE FROM users WHERE user_id= {$_GET['delete']}");
    $delete_stmt->execute();
    header("Location:users.php");


}




?>

