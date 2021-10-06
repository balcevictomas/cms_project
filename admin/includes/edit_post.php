<?php
//$post_author = '';
if (isset($_GET['p_id']))
{
    $id = $_GET['p_id'];

    try {
        $insert_stmt = $db->prepare("SELECT * FROM posts where post_id={$id}");
        $insert_stmt->execute();
        $row = $insert_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result) {

          $post_id = $result['post_id'];
            $post_author = $result['post_author'];
            $post_title = $result['post_title'];
            $post_cat_id = $result['post_cat_id'];
            $post_status = $result['post_status'];
            $post_image = $result['post_image'];
            $post_tags = $result['post_tags'];
            $post_comment_count = $result['post_comment_count'];
            $post_date = $result['post_date'];
            $post_content = $result['post_content'];


        }

    } catch (PDOException $e) {
        $e->getMessage();
    }

    if(isset($_POST['update']))
    {
       $post_title = $_POST['title'];
        $post_category = $_POST['post_category'];
        $post_author = $_POST['author'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_tmp = $_FILES['image']['tmp_name'];
        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];

move_uploaded_file($post_image_tmp, "../images/$post_image");

if(empty($post_image))
{
    try {
        $search_stmt = $db->prepare("SELECT * FROM posts WHERE post_id= {$id}");
        $search_stmt->execute();
        $row = $search_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $result)
        {
            $post_image = $result['post_image'];
        }
    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }
}

     $query = "UPDATE posts SET ";
     $query .= "post_title = '{$post_title}', ";
     $query .= "post_cat_id = '{$post_category}', ";
     $query .= "post_date = now(), ";
     $query .= "post_author = '{$post_author}', ";

     $query .= "post_status = '{$post_status}', ";
     $query .= "post_tags = '{$post_tags}', ";
     $query .= "post_content = '{$post_content}', ";
     $query .= "post_image = '{$post_image}' ";
     $query .= "WHERE post_id = '{$id}'";
     //echo $query;

        try {
            $update_stmt = $db->prepare($query);
            $update_stmt->execute();
        }
        catch (PDOException $e)
        {
            $e->getMessage();
        }

    echo "<p>Post Updated <a href='../post.php?p_id={$id}'>View Post</a> or <a href='./posts.php'>Edit more</a></p>";
    }
}


?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title"">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category ID</label>
        <br>
        <select name="post_category" id="">
        <?php
        try{

            $edit_stmt = $db->prepare("SELECT * FROM categories");
            $edit_stmt->execute();
            $row = $edit_stmt->fetchAll(PDO::FETCH_ASSOC);
            //  echo count($row);
            foreach($row as $result) {
                $cat_title = $result['cat_title'];
                $cat_id = $result['cat_id'];
                echo  "<option value='{$cat_id}'>{$cat_title}</option>";
            }



        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }?>
        </select>
    </div>

    <div class="form-group">
        <label for="title"">Post Author</label>
        <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>
    <!--<div class="form-group">
        <label for="post_status"">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php /*echo $post_status; */?>">
    </div>-->
    <div class="form-group">
        <select name="post_status" id="">
            <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>
            <?php if($post_status == 'published')
            {
                echo "<option value='draft'>Draft</option>";
            }
            else
            {
                echo "<option value='published'>Published</option>";
            }?>
        </select>
        </div>

    <div class="form-group">

        <img src="../images/<?php echo $post_image ?>" width="100 alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="title"">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content"">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control"> <?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update" value="Edit Post">

    </div>













</form>