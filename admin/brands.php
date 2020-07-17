<?php
require_once '../core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'include/head.php';
include 'include/navigation.php';
// get brands from SQLiteDatabase
$sql = "SELECT * FROM brand ORDER BY brand";
$results = $db->query($sql);
$errors = array();

//Edit Brands
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
  $edit_result = $db->query($sql2);
  $eBrand = mysqli_fetch_assoc($edit_result);
}

//DELETE brands
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET['delete'];
  $sql = "DELETE FROM brand where id ='$delete_id'";
  $db->query($sql);
  header('Location: brands.php');
}
// If add form is submitted
if(isset($_POST['add_submit'])){
  $brand = $_POST['brand'];
  // check if brand is blank
  if($_POST['brand'] == ''){
    $errors[] .= "You must enter a brand!!";
  }
  //check if brand exist in Database
  $sql ="SELECT * FROM brand WHERE brand = '$brand'";
  if(isset($_GET['edit'])){
    $sql = "SELECT * FROM brand where brand = '$brand' AND id != '$edit_id'";
  }
  $result = $db->query($sql);
  $count = mysqli_num_rows($result);
  if($count > 0){
    $errors[] .= $brand .' This brand already exists. Please enter new brand.';
  }
  //display error
  if(!empty($errors)){
    echo display_errors($errors);
  }
  else{
    // add brand to Database
    $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
    if(isset($_GET['edit'])){
      $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
    }
    $db->query($sql);
    header('Location: brands.php');
  }
}
?>
<h2 class="text-center">Brands</h2> <hr/>
<!-- Brand Form -->
<div class="text-center">
  <form class="form-inline" action = "brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method = "post">
    <div class="form-group">
      <?php
      $brand_value ="";
      if(isset($_GET['edit'])){
        $brand_value = $eBrand['brand'];
      }else{
        if(isset($_POST['brand'])){
          $brand_value = $_POST['brand'];
        }
      }
      ?>
      <label for="brand"><?=((isset($_GET['edit']))?'Edit a ':'Add a ');?>Brand: </label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value;?>">
      <?php if(isset($_GET['edit'])):?>
        <a href ="brands.php" class="btn btn-default">Cancel</a>
     <?php endif; ?>
      <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?>Brand" class="btn btn-success" >
    </div>
  </form>
</div>
<hr />

<table class="table table-bordered table-striped table-auto table-condensed">
  <thead>
    <th></th> <th>Cars Comapany</th> <th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td><a href="brands.php?edit=<?=$brand['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><?php echo $brand['brand']; ?></td>
        <td><a href="brands.php?delete=<?=$brand['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>
      </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php
include 'include/footer.php';
?>
