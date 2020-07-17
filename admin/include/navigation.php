<!-- Top Navigation-->
<nav class="navbar navbar-default navbar-fixed-top">
<a href="/project/admin/index.php" class="navbar-brand">Superior Admins</a>
<div class="container">
  <ul class="nav navbar-nav">
    <li><a href="brands.php">Brands</a></li>
    <li><a href="category.php">Category</a></li>
    <li><a href="products.php">Inventory</a></li>
    <?php if(has_permission('admin')):?>
      <li><a href="users.php">Users</a></li>
    <?php endif; ?>
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$user_data['first'];?>!<span class="caret"></span></a>
      <ul class="dropdown-menu" role = "menu">
        <li><a href="change_password.php">Change Password</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </li>

    <!--
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php //echo $parent['category']; ?><span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="#"></a></li>
      </ul>
    </li>
  -->

  </ul>
  <!--<ul class="nav navbar-nav navbar-right">
    <li><a href="/project/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
    <li><a href="/project/login_page.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
  </ul> -->
</div>
</nav>
