<?php

    if(isset($_GET['p_id'])){
        $the_post_id = $_GET['p_id'];
    }
    $query = "select * from posts where post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];

    }

    if(isset($_POST['update_post'])){
        $post_author = $_POST['author'];
        $post_title = $_POST['title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['name'];

        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];

        $target_dir = "/Applications/XAMPP/xamppfiles/htdocs/admin/images/";

        move_uploaded_file($post_image_temp, $target_dir . $post_image);


        if(empty($post_image)){
            $query = "select * from posts where post_id = $the_post_id";
            $select_image = mysqli_query($connection, $query);

            while($row = mysqli_fetch_array($select_iamge)){
                $post_image = $row['post_image']; 
            }
        }

        $query = "update posts set post_category_id = '{$post_category_id}', post_title = '{$post_title}', post_author  = '{$post_author}', post_date = now(), post_image  = '{$post_image}', post_content  = '{$post_content}', post_tags = '{$post_tags}', post_status = '{$post_status}' where post_id = '{$the_post_id}' ";
    
        $update_post = mysqli_query($connection, $query);

        confirm_query($update_post);
    }

?>




<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <select name="post_category" id="">


        <?php 
            $query = "select * from category";
            $select_categories = mysqli_query($connection, $query);
            confirm_query($select_categories);

            while($row = mysqli_fetch_assoc($select_categories)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value=' {$cat_id} '> {$cat_title} </option>";
            }
 
            ?> 

        </select>


    </div>

    <div class="form-group">
        <label for="author">Post author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="author">
    </div>

    <div class="form-group">
        <label for="post_status">Post status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>

    <div class="form-group">
        <img  witdth="100" src="../images/<?php echo  $post_image; ?>">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10">
            <?php echo $post_content; ?>"
        </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Publish" >
    </div>

</form>