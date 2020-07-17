</div> <br/><br/>
<!-- Footer -->
<footer class="text-center" id="footer">&copy; Copyright 2019 Superior Car Sales
</footer>

<script>
function get_child_options(){
  var parentID = jQuery('#parent').val();
  jQuery.ajax({
    url: '/project/admin/parsers/child_categories.php',
    type: 'POST',
    data: {parentID : parentID},
    sucess: function(data){
      jQuery('#child').html(data);
    },
    error: function(){alert("Something went wrong.")},
  });
}
jQuery('select[name="parent"]').change(get_child_options);
</script>

</body>
</html>
