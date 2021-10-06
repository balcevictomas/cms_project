<?php
function users_online()
{

          global $db;
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 60;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '{$session}'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count == NULL) {
                $sec_query = "INSERT INTO users_online(session , time) VALUES ('{$session}', '{$time}')";
                $stmt = $db->prepare($sec_query);
                $stmt->execute();
            } else {
                $sec_query = "UPDATE users_online SET time ='{$time}' WHERE session='{$session}'";
                $stmt = $db->prepare($sec_query);
                $stmt->execute();
            }
            $online_query = "SELECT * FROM users_online WHERE time >'{$time_out}'";
            $online_stmt = $db->prepare($online_query);
            $online_stmt->execute();
            $count_user = $online_stmt->rowCount();

            return $count_user;

}


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