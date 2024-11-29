<?php
    include "config.php";

    if(empty($_FILES['new-image']['name'])){
        $image_name = $_POST['old_image'];
    }
    else{
        $errors = array();
        
        $image_name = $_FILES['new-image']['name'];
        $image_size = $_FILES['new-image']['size'];
        $image_tmp = $_FILES['new-image']['tmp_name'];
        $image_type = $_FILES['new-image']['type'];
        $image_ext =  end(explode('.', $image_name));
        $extensions = array("jpeg", "jpg", "png","webp");

        // Check required file extensions
        if(in_array($image_ext, $extensions) === false){
            $errors[] = "This extension file is not allowed, Please choose a JPG or PNG file";
        }

        // Check file size
        if($image_size > 2097152){
            $errors[] = "File size must be 2MB or lower than 2MB";
        }

        // if there is no error then upload file into database
        if(empty($errors) == true){
            move_uploaded_file($image_tmp, "upload/" . $image_name);
        }
        else{
            print_r($errors);
            die();
        }
    }

    $sql = "UPDATE post SET title = '{$_POST["post_title"]}',description='{$_POST["postdesc"]}', category='{$_POST["category"]}', post_img='{$image_name}' 
            WHERE post_id = {$_POST["post_id"]}";
            
    $update_sql = mysqli_query($conn, $sql) or die ("Query Failed");

    if($update_sql){
        header("Location: post.php");
    }

?>