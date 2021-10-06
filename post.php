<?php
include "includes/header.php";
include "includes/navigation.php";
?>




    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if(isset($_GET['p_id']))
            {
                $post_id = $_GET['p_id'];
            }
            $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$post_id}'";
            $view_stmt = $db->prepare($view_query);
            $view_stmt->execute();

            try{
                $select_stmt = $db->prepare("SELECT * FROM posts WHERE post_id={$post_id}");
                $select_stmt->execute();
                $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row as $result) {
                    $post_title = $result['post_title'];
                    $post_author = $result['post_author'];
                    $post_date = $result['post_date'];
                    $post_image = $result['post_image'];
                    $post_content = $result['post_content'];
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?> </p>


                    <hr>
                    <!-- Blog Comments -->

                    <!-- Comments Form -->

                    <?php

                    if(isset($_POST['post_comment']))
                    {
                        //echo $_POST['comment_author'];
                        $post_id = $_GET['p_id'];
                        if(!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && !empty($_POST['comment']))
                            {
                                try
                                {
                                    $query = "INSERT INTO comments(comment_post_id, comment_author,comment_email, comment_content, comment_status, comment_date)";
                                    $query .= " VALUES ('$post_id','{$_POST['comment_author']}', '{$_POST['comment_email']}', '{$_POST['comment']}', 'unapproved',now())";
                                    $insert_stmt = $db->prepare($query);
                                    $insert_stmt->execute();
                                    // echo $query;



                                }
                                catch (PDOException $e)
                                {
                                    $e->getMessage();

                                }
                                try{
                                    $add_query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id={$post_id}";
                                    $sum_stmt = $db->prepare($add_query);
                                    $sum_stmt->execute();
                                }
                                catch (PDOException $e)
                                {
                                    $e->getMessage();
                                }


                            }
                        else
                            {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }



                    }?>
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">
                            <div class="form-group">
                                <label for="author">Author</label>
                                <br>
                                <input type="text" class="form-control" name="comment_author">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="comment_email">
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea name ="comment"class="form-control" id="" cols="30" rows="10"></textarea>
                            </div>
                            <button type="submit" name="post_comment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->
                    <?php
                    $query1 = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
                    $query1 .= " AND comment_status = 'approved'";
                    $query1 .= " order by comment_id desc";
                   // echo $query1;
                    try
                    {
                        $query_stmt = $db->prepare($query1);
                        $query_stmt->execute();
                        $pagauk = $query_stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($pagauk as $result)
                            {
                                $comment_date = $result['comment_date'];
                                $comment_author = $result['comment_author'];
                                $comment_content= $result['comment_content'];
                                ?>
                                <div class="media">
                                    <a class="pull-left" href="#">
                                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $comment_author ?>
                                            <small><?php echo $comment_date ?></small>
                                        </h4>
                                        <?php echo $comment_content ?>
                                    </div>
                                </div>



                                <?php
                            }
                    }
                    catch (PDOException $e)
                        {
                            $e->getMessage();
                            echo $e;
                        }


                    ?>




                    <!-- Comment -->


                    <?php

                }

            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }



            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php
        include "includes/sidebar.php";
        ?>

    </div>
    <!-- /.row -->

    <hr>


<?php
include "includes/footer.php";
?>