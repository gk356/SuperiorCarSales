<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
  if(!is_logged_in()){
    login_error_redirect();
  }
  include 'include/head.php';
  include 'include/navigation.php';

  $sql = "SELECT * FROM category where parent = 0";
  $result = $db->query($sql);
  $errors = array();
  $category = "";
  $post_parent = '';

  //Edit Category
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $edit_sql = "SELECT * FROM category where id = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);

  }

  //delete Category
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    $sql = "SELECT * FROM categoy where id = '$delete_id'";
    $result = $db->query($sql);
    $category = mysqli_fetch_assoc($result);
    if($category['parent'] == 0){
      $sql = "DELETE FROM category where parent = '$delete_id'";
      $db->query($sql);
    }
    $dsql = "DELETE FROM category where id ='$delete_id'";
    $db->query($dsql);
    header('Location: category.php');
  }



  //Process form
  if(isset($_POST) && !empty($_POST)){
    $post_parent = $_POST['parent'];
    $category = $_POST['category'];
    $sqlform = "SELECT * FROM category where category = '$category' AND parent = '$post_parent'";
    if(isset($_GET['edit'])){
      $id = $edit_category['id'];
      $sqlform = "SELECT * FROM category WHERE category = '$category' AND parent = '$post_parent' AND id != '$id'";
    }
    $fresult = $db->query($sqlform);
    $count = mysqli_num_rows($fresult);
    //if category is blank
    if($category == ''){
      $errors[] .= 'You must enter category!!!';
    }
    // if exist on Database
    if($count > 0){
      $errors[] .= $category. ' already exists. Please choose new category.';
    }
    //Display error or update Database
    if(!empty($errors)){
      //display errors
      $display = display_errors($errors); ?>
      <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?=$display;?>');
        });
      </script>
    <?php
    }
    else{
      //update databse
      $updatesql = "INSERT INTO category (category, parent) Values ('$category', '$post_parent')";
      if(isset($_GET['edit'])){
        $updatesql = "UPDATE category SET category ='$category', parent = '$post_parent' WHERE id = '$edit_id' ";
      }
      $db->query($updatesql);
      header('Location: category.php');
    }
  }
  $category_value = '';
  $parent_value = '0';
  if(isset($_GET['edit'])){
    $category_value = $edit_category['category'];
    $parent_value = $edit_category['parent'];
  }else{
    if(isset($_POST)){
      $category_value = $category;
      $parent_value = $post_parent;
    }
  }
 ?>
<h2 class="text-center">Categories</h2><hr />
<div class="row">

  <!-- From -->
  <div class="col-md-6">
    <form class="form" action"category.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <legend><?=((isset($_GET['edit']))?'Edit':'Add a');?> Category</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?=(($parent_value == 0))?'selected="selected"':'';?>>Parent</option>
          <?php while($parent = mysqli_fetch_assoc($result)):?>
            <option value="<?=$parent['id'];?>" <?=(($parent_value == $parent['id']))?'selected="selected"':'';?>><?=$parent['category'];?></option>
          <?php endwhile;?>
        </select>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" value="<?=$category_value;?>">
      </div>
      <div class="form-group">
        <input type="submit" value="<?=((isset($_GET['edit'])))?'Edit':'Add';?> Category" class="btn btn-success">
      </div>
    </form>
  </div>

  <!-- Category Table -->
  <div class="col-md-6">
    <table class="table table-bordered">
      <thead>
        <th>Category</th><th>Parent</th><th></th>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM category where parent = 0";
          $result = $db->query($sql);
         while($parent = mysqli_fetch_assoc($result)):
          $parent_id = (int)$parent['id'];
          $sql2 = "SELECT * FROM category where parent = '$parent_id'";
          $cresult = $db->query($sql2);
          ?>
          <tr class="bg-primary">
            <td><?=$parent['category'];?></td>
            <td>Parent</td>
            <td>
              <a href="category.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="category.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span></a>
            </td>

        <?php while($child = mysqli_fetch_assoc($cresult)): ?>
          <tr class="bg-info">
            <td><?=$child['category'];?></td>
            <td><?=$parent['category'];?></td>
            <td>
              <a href="category.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="category.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endwhile; ?>
      </tbody>
    </table>

  </div>

</div>
 <?php
  include 'include/footer.php';
  ?>
