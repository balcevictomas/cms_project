<?php
include "includes/header.php";
include "includes/navigation.php";

if(isset($_GET['author']))
{
    $author = $_GET['author'];
    $query = "SELECT * FROM users where username='{$author}'";
    try {
        $select_stmt = $db->prepare($query);
        $select_stmt->execute();
        $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$row) {
            echo '<h1 class="text-center">Nothing here</h1>';
            die;
        }
        foreach ($row as $result)
        {
            $user_firstname = $result['user_firstname'];
            $user_lastname = $result['user_lastname'];
            $user_image= $result['user_image'];
        }
        ?>

    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

                <h1 class="text-center"><?php echo $author ?></h1>

                <img style="float: left; width: 140px;" alt="" src="images/users/<?php echo $user_image ?>" />
                <div style="margin-left: 20rem;">
                    <p><?php echo $user_firstname; ?></p>
                    <p><?php echo $user_lastname; ?></p>


<br>
                    <br>
                    <br>



            </div>

            <h2 class="page-header text-center">
                All posts by user
            </h2>



            <?php
            try{
                $select_stmt = $db->prepare("SELECT * FROM posts WHERE post_author='{$author}' and post_status='published'");
                $select_stmt->execute();
                $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row as $result) {
                    $post_id = $result['post_id'];
                    $post_title = $result['post_title'];
                    $post_author = $result['post_author'];
                    $post_date = $result['post_date'];
                    $post_image = $result['post_image'];
                    $post_content = $result['post_content'];
                    ?>


                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>

                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    <hr>
                    <p><?php echo substr($post_content, 0, 100)  ?> </p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>


                    <hr>
                    <?php }
                }
                catch (PDOException $e)
                {
                  $e->getMessage();
                  echo $e;
                }
                ?>






        </div>

   <?php

    }
    catch (PDOException $e)
    {
        $e->getMessage();
    }


?>





        <!-- Blog Sidebar Widgets Column -->
        <?php
}
        include "includes/sidebar.php";
        ?>

    </div>

    <!-- /.row -->

    <hr>


<?php
include "includes/footer.php";

?>