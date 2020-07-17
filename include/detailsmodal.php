<?php
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM inventory WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id ='$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);

?>

<!-- Details Modal -->
<?php ob_start(); ?>
  <div class="modal fade " id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
      <!--<button class="close" type="button" onclick="closeModal()" aria-label="Close">
          <span aria-hidden="true">&time;</span>
        </button> -->
        <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <span id="modal_errors" class="bg-danger"></span>
            <div class="col-sm-6">
              <div class="center-block">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="details img-responnsive">
              </div>
            </div>
            <div class="col-sm-6">
              <h4>Details</h4>
              <p> <?php echo $product['description']; ?></p>
              <hr/>
              <p>Price: $<?php echo $product['price']; ?></p>
              <p>Model: <?php echo $product['model']; ?></p>
              <p>Make: <?php echo $product['title']; ?></p>
              <p>Contact: <?php echo $product['contact']; ?> </p>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" onclick="closeModal()">Close</button>
        <button class="btn btn-warning" type ="submit" name="save"><span class="glyphicon glyphicon-heart "></span> Save to your List</button>
      </div>
      </div>
    </div>
  </div>
  <script>
  function closeModal(){
    jQuery('#details-modal').modal('hide');
    setTimeout(function(){
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
    },500);
  }

  </script>
  <?php echo ob_get_clean(); ?>
