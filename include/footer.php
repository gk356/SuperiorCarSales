</div> <br/><br/>
<!-- Footer -->
<footer class="text-center" id="footer">&copy; Copyright 2019 Superior Car Sales
<p class="footer-text">
Follow us at:<br />
FaceBook <br />
Instagram <br />
SnapChat <br />
</p>
</footer>

<script>
  jQuery(window).scroll(function(){
    var vscroll = jQuery(this).scrollTop();
    console.log(vscroll);
  });

  function detailsmodal(id){
    var data = {"id": id};
    jQuery.ajax({
      url :'/project/include/detailsmodal.php',
      method : "post",
      data : data,
      success : function(data){
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');
      },
      error : function(){
        alert("Something went wrong!!");
      }
    });
  }

  function save_item(){
    alert("you clicked");
  }
</script>
</body>
</html>
