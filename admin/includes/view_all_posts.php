<?php
if(isset($_POST['checkBoxArray']))
{
    foreach ($_POST['checkBoxArray'] as $checkID)
    {
     $bulk = $_POST['bulk_options'];

     switch ($bulk)
     {
         case 'published':
             $query = "UPDATE posts SET post_status = '{$bulk}' WHERE post_id = '{$checkID}'";


             break;
         case 'draft':

             $query = "UPDATE posts SET post_status = '{$bulk}' WHERE post_id = '{$checkID}'";


             break;

         case 'delete':

             $query = "DELETE FROM posts WHERE post_id = '{$checkID}'";


             break;

         case 'clone':
             $query = "SELECT * FROM posts WHERE post_id = '{$checkID}' ";
             try{
                $clone_stmt = $db->prepare($query);
                $clone_stmt ->execute();
                $row = $clone_stmt -> fetchAll(PDO::FETCH_ASSOC);
                foreach ($row as $result)
                {
                    $post_title = $result['post_title'];
                    $post_cat_id = $result['post_cat_id'];
                    $post_date = $result['post_date'];
                    $post_author = $result['post_author'];
                    $post_status = $result['post_status'];
                    $post_image = $result['post_image'];
                    $post_tags = $result['post_tags'];
                    $post_content = $result['post_content'];
                    $query = "INSERT INTO posts(post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                    $query .= "VALUES({$post_cat_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
                }
             }
             catch (PDOException $e)
             {
                 $e->getMessage();
             }


            break;

     }
        try{

            $update_stmt = $db->prepare($query);
            $update_stmt->execute();


        }
        catch (PDOException $e)
        {
            $e->getMessage();
            echo $e;
        }

    }
}

?>



<form action="" method="post">

<table class="table table-bordered table-hover">
    <div class="row" id="bulkOptionsContainer">
        <div class="col-sm-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="form-group col-xs-4">
            <input type="submit" class="btn btn-success" name="submit" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
    </div>
    <thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <?php
    try {
        $insert_stmt = $db->prepare("SELECT * FROM posts ORDER BY post_id DESC");
        $insert_stmt->execute();
        $row = $insert_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            echo "<tr>";
            ?>

            <th><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $result['post_id'] ?>'></th>
    <?php
            echo '<td>'.$result['post_id'].'</td>';
            echo '<td>'.$result['post_author'].'</td>';
            echo '<td>'.$result['post_title'].'</td>';

           // echo '<td>'.$result['post_cat_id'].'</td>';

            $query = $db->prepare("SELECT * FROM categories WHERE cat_id= {$result['post_cat_id']}");
            $query->execute();
            $row1 = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($row1 as $result1)
            {
                echo "<td>{$result1['cat_title']}</td>";
            }

            echo '<td>'.$result['post_status'].'</td>';
            echo '<td><img width="100 " src="../images/'.$result['post_image'].'"></td>';
            echo '<td>'.$result['post_tags'].'</td>';
            echo '<td>'.$result['post_comment_count'].'</td>';
            echo '<td>'.$result['post_date'].'</td>';
            echo '<td><a href="../post.php?p_id='.$result['post_id'].'">View Post</a></td>';
            echo '<td><a href="posts.php?source=edit_post&p_id='.$result['post_id'].'">Edit</a></td>';
            $post_id = $result['post_id'];

            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?')\" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<td><a href='posts.php?reset={$post_id}'>{$result['post_views_count']}</a></td>";


        }

    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }

    ?>

    </tbody>

</table>
</form>

<?php
if(isset($_GET['delete']))
{
    $delete_stmt = $db->prepare("DELETE FROM posts WHERE post_id= {$_GET['delete']}");
    $delete_stmt->execute();
    header("Location:posts.php");


}
if(isset($_GET['reset']))
{
    $reset_stmt = $db->prepare("UPDATE posts SET post_views_count = 0 WHERE post_id = {$_GET['reset']}");
    $reset_stmt->execute();
    header("Location:posts.php");


}




?>

