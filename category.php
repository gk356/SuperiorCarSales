<?php
require_once 'core/init.php';
include 'include/head.php';
include 'include/navigation.php';
include 'include/headerfull.php';
include 'include/leftbar.php';

if(isset($_GET['cat'])){
  $cat_id = ($_GET['cat']);
}else{
  $cat_id ='';
}

$sql = "SELECT * FROM inventory WHERE category = '$cat_id'";
$productQ = $db->query($sql);
$category = get_category($cat_id);

?>

  <!-- Main Content -->
  <div class="col-md-8">
    <div class="row">
      <h1 class="text-center"><?=$category['child'].' '.$category['parent'];?></h1>
      <?php while($product = mysqli_fetch_assoc($productQ)) : ?>

        <div class="col-md-3">
          <h2><?php echo $product['title']; ?></h2>
          <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="img-thumb"/>
          <p class="list-price text-danger">Dealer Price: <s>$<?php echo $product['list_price']; ?></s></p>
          <p class="price">Our Price: $<?php echo $product['price']; ?></p>
          <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Details</button>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <?php

  include 'include/rightbar.php';
  include 'include/footer.php';
  ?>
