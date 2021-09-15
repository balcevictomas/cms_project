<?php

function insert_cat() {
    if(isset($_POST['submit']))
    {
        global $db;
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" OR empty($cat_title))
        {
            echo "This field is empty";
        }
        else
        {
            $insert_stmt = $db->prepare("INSERT INTO categories (cat_title) VALUES ('{$cat_title}')");
            if($insert_stmt->execute())
            {
                echo "Added";
            }
            else
            {
                echo "Not added";
            }
        }
    }


}

function showAll_cat ()
{
    global $db;

    try{
        $select_stmt = $db->prepare("SELECT * FROM categories");
        $select_stmt->execute();
        $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        //  echo count($row);
        foreach($row as $result) {
            echo "<tr>";
            echo "<td>{$result['cat_id']}</td>";
            echo "<td>{$result['cat_title']}</td>";
            echo "<td><a href='categories.php?delete={$result['cat_id']}'>Delete</a></td>";
            echo "<td><a href='categories.php?edit={$result['cat_id']}'>Edit</a></td>";
            echo "</tr>";
        }

    }
    catch(PDOException $e)
    {
        $e->getMessage();
    }
}

function delete_cat ()
{
    global $db;
    if (isset($_GET['delete']))
    {

        try{

            $delete_stmt = $db->prepare("DELETE FROM categories WHERE cat_id={$_GET['delete']}");
            $delete_stmt->execute();
            header("Location: categories.php");



        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }
    }
}



?>