<?php
if(isset($_POST['create_post']))
{
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    $post_date = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    try{
        $insert_stmt = $db->prepare("INSERT INTO posts(post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES 
      ('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}','{$post_tags}', '{$post_comment_count}', '{$post_status}')");
        $insert_stmt->execute();

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
   $last_id = $db->lastInsertId();
   echo "<p>Post Added <a href='../post.php?p_id={$last_id}'>View Post</a> or <a href='./posts.php'>Edit more</a></p>";
}




?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title"">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category ID</label>
        <br>
        <select name="post_category_id" id="">
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
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">


        <select name="post_status" id="">
            <option value="draft">Post status</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>

        </select>

    </div>
    <div class="form-group">
        <label for="title"">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="title"">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content"">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">

    </div>













</form>