<form action="" method="post">
    <div class="form-group">
        <label for="cat_title">Update category</label>

        <?php
        if (isset($_GET['edit']))
        {


            try{

                $edit_stmt = $db->prepare("SELECT * FROM categories where cat_id={$_GET['edit']}");
                $edit_stmt->execute();
                $row = $edit_stmt->fetchAll(PDO::FETCH_ASSOC);
                //  echo count($row);
                foreach($row as $result) {
                    $cat_title = $result['cat_title'];
                    $cat_id = $result['cat_id'];
                    echo  '<input value="'.$cat_title.'" type="text" class="form-control" name = "cat_title">';
                }



            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }

        if (isset($_POST['update']))
        {



            try{

                $update_stmt = $db->prepare("UPDATE categories SET cat_title='{$_POST['cat_title']}' WHERE cat_id='{$_GET['edit']}'");
                $update_stmt->execute();
                header("Location: categories.php");


            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }



        ?>




    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name = "update" value="Update category">
    </div>


</form>