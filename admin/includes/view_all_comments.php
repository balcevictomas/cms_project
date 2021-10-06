<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th>Approve</th>
        <th>Unapprove</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    try {
        $insert_stmt = $db->prepare("SELECT * FROM comments");
        $insert_stmt->execute();
        $row = $insert_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            $comment_id = $result['comment_id'];
            echo "<tr>";
            echo '<td>'.$result['comment_id'].'</td>';
            echo '<td>'.$result['comment_author'].'</td>';
            echo '<td>'.$result['comment_content'].'</td>';

            // echo '<td>'.$result['post_cat_id'].'</td>';

            /*$query = $db->prepare("SELECT * FROM categories WHERE cat_id= {$result['post_cat_id']}");
            $query->execute();
            $row1 = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($row1 as $result1)
            {
                echo "<td>{$result1['cat_title']}</td>";
            }*/

            echo '<td>'.$result['comment_email'].'</td>';
           // echo '<td><img width="100 " src="../images/'.$result['post_image'].'"></td>';
            echo '<td>'.$result['comment_status'].'</td>';
            try
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
            }

            echo '<td>'.$result['comment_date'].'</td>';
            echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
           // echo '<td><a href="#">Edit</a></td>';
            echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";

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
if(isset($_GET['unapprove']))
{
    $unapprove_id =$_GET['unapprove'];

    try {
        $unapprove_stmt = $db->prepare("UPDATE comments set comment_status ='unapproved' where comment_id = {$unapprove_id}");
        $unapprove_stmt->execute();
        header("Location:comments.php");
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
    $delete_stmt = $db->prepare("DELETE FROM comments WHERE comment_id= {$_GET['delete']}");
    $delete_stmt->execute();
    header("Location:comments.php");


}




?>

