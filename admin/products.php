<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'include/head.php';
include 'include/navigation.php';


if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $db->query("DELETE FROM inventory WHERE id = '$id'");
  header('Location: products.php');
  //UPDATE inventory SET deleted = 1 where id = '$id'
}
if (isset($_GET['add']) || isset($_GET['edit'])) {
  $brandQuery = $db->query("SELECT * FROM brand ORDER BY brand");
  $parentQuery = $db->query("SELECT * FROM category where parent = 0 ORDER BY category");
  $childQuery = $db->query("SELECT * FROM category WHERE parent != 0 ORDER BY category");
  $title = ((isset($_POST['title']) && $_POST['title'] != '')?$_POST['title']:'');
  if(isset($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
  }

  if($_POST){
    $title = $_POST['title'];
    $brand = $_POST['brand'];
    $category = $_POST['child'];
    $price = $_POST['price'];
    $list_price = $_POST['list_price'];
    $contact = $_POST['contact'];
    $description = $_POST['description'];
    $model = $_POST['model'];

    $errors = array();
    $required = array('title','brand','price','parent','child','contact');
    foreach ($required as $field) {
      if($_POST[$field] == ''){
        $errors[] = 'All filed with an * are required.';
        break;
      }
    }
    if(!empty($_FILES)){
      //var_dump($_FILES);
      $photo =$_FILES['photo'];
      $name = $photo['name'];
      $nameArray = explode('.',$name);
      $filename = $nameArray[0];
      $fileExt = $nameArray[1];
      $mime = explode('/',$photo['type']);
      $mimeType = $mime[0];
      $mimeExt = $mime[1];
      $tempLoc = $photo['tmp_name'];
      $fileSize = $photo['size'];
      $allowed = array('png','jpg','jpeg','gif');
      $uploadName = md5(microtime()).'.'.$fileExt;
      $uploadPath = BASEURL.'/images/products/'.$uploadName;
      $dbpath = '/project/images/products/'.$uploadName;
      if($mimeType != 'image'){
        $errors[] = 'File must be an images';
      }
      if(!in_array($fileExt,$allowed)){
        $errors[] = 'The images extension must be a png, jpeg, jpg or gif.';
      }
      if($fileSize > 15000000){
        $errors[] = 'File too large.';
      }
      if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpeg')){
        $errors[] = 'Something is wrong with your images.';
      }
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }
    else{
      //update database
      move_uploaded_file($tempLoc, $uploadPath);
      $insertSQL = "INSERT INTO inventory (title, price, list_price, brand, category, image, description, model, contact)
                    VALUES('$title','$price','$list_price','$brand','$category', '$dbpath', '$description','$model','$contact')";

      $db->query($insertSQL);
      header('Location: products.php');
    }
  }
?>
<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add a');?> Inventory</h2><hr>
<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">

  <div class="form-group col-md-3">
    <label for="title">Title *: </label>
    <input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
  </div>

  <div class="form-group col-md-3">
    <label for="brand">Brand *: </label>
    <select class="form-control" id="brand "name="brand">
      <option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '')?' selected':'');?>></option>
      <?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
        <option value="<?=$brand['id'];?>" <?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected':'');?>><?=$brand['brand'];?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="parent">Parent Category *: </label>
    <select class="form-control" id="parent" name="parent">
      <option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':'');?>></option>
      <?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
        <option value="<?=$parent['id'];?>" <?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' selected':'');?>><?=$parent['category'];?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="child">Child Category *:</label>
    <select id="child" name="child" class="form-control">
    <option value=""<?=((isset($_POST['child']) && $_POST['child'] == '')?' selected':'');?>></option>
      <?php while($child = mysqli_fetch_assoc($childQuery)): ?>
        <option value="<?=$child['id'];?>" <?=((isset($_POST['child']) && $_POST['child'] == $child['id'])?' selected':'');?>><?=$child['category'];?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="form-group col-md-3">
    <label for="price">Price *:</label>
    <input type="text" name="price" class="form-control" id="price" value="<?=((isset($_POST['price']))?$_POST['price']:'');?>">
  </div>

  <div class="form-group col-md-3">
    <label for="price">List Price :</label>
    <input type="text" name="list_price" class="form-control" id="list_price" value="<?=((isset($_POST['list_price']))?$_POST['list_price']:'');?>">
  </div>

  <div class="form-group col-md-3">
    <label for="model">Model :</label>
    <input type="text" name="model" class="form-control" id="model" value="<?=((isset($_POST['model']))?$_POST['model']:'');?>">
  </div>

  <div class="form-group col-md-3">
    <label for="contact">Contact *:</label>
    <input type="text" name="contact" class="form-control" id="contact" value="<?=((isset($_POST['contact']))?$_POST['contact']:'');?>">
  </div>

  <div class="form-group col-md-6">
    <label for="photo">Image :</label>
    <input type="file" name="photo" class="form-control" id="photo">
  </div>

  <div class="form-group col-md-6">
    <label for="description">Description :</label>
    <textarea rows="6" name="description" class="form-control" id="description"><?=((isset($_POST['description']))?$_POST['description']:'');?></textarea>
  </div>

  <div class="form-group pull-right col-md-3">
    <a href="products.php" class="btn btn-default">Cancel</a>
  <input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Inventory" class="btn btn-success">
  </div>
</form>

<?php }
else
{
$sql = "SELECT * FROM inventory WHERE deleted = 0";
$presults = $db->query($sql);

if(isset($_GET['featured'])){
  $id = (int)$_GET['id'];
  $featured = (int)$_GET['featured'];
  $featuredSql = "UPDATE inventory SET featured = $featured WHERE id = $id";
  $db->query($featuredSql);
  header('Location: products.php');
 }

?>

<h2 class="text-center">Inventory</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Inventory</a><div class="clearfix"></div>
<hr/>
<table class="table table-bordered table-condensed table-stripped">
  <thead>
    <th></th>
    <th>Product</th>
    <th>Price</th>
    <th>Categories</th>
    <th>Featured</th>

  </thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($presults)):
      $childID = $product['category'];
      $catSql = "SELECT * from category WHERE id = '$childID'";
      $result = $db->query($catSql);
      $child = mysqli_fetch_assoc($result);
      $parentID = $child['parent'];
      $pSql = "SELECT * FROM category WHERE id = '$parentID'";
      $presult = $db->query($pSql);
      $parent = mysqli_fetch_assoc($presult);
      $category = $parent['category'].'-'.$child['category'];

   ?>
      <tr>
        <td>
          <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
          <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span></a>
        </td>
        <td><?=$product['title'];?></td>
        <td><?=money($product['price']);?></td>
        <td>
          <?=$category;?>
        </td>
        <td>
          <a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featured'] == 1)?'minus':'plus');?>"></span></a>&nbsp<?=(($product['featured'] == 1)?'Featured Producted':'');?>
        </td>
        </tr>
    <?php endwhile; ?>

  </tbody>
</table>


<?php }
 include 'include/footer.php';
