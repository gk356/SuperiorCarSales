<?php
$sql = "SELECT * FROM category WHERE parent = 0";
$pquery = $db->query($sql);
 ?>

<!-- Top Navigation-->
<nav class="navbar navbar-default navbar-fixed-top">
<a href="/project/index.php" class="navbar-brand">Superior Car Sales</a>
<div class="container">
  <ul class="nav navbar-nav">

    <?php
    while($parent = mysqli_fetch_assoc($pquery)): ?>
    <?php $parent_id = $parent['id'];
    $sql2 = "SELECT * FROM category where parent = '$parent_id'";
    $cquery = $db->query($sql2);
    ?>

    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category']; ?><span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">

        <?php while($child = mysqli_fetch_assoc($cquery)): ?>
        <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category'];?></a></li>
        <?php endwhile; ?>

      </ul>
    </li>
  <?php endwhile; ?>
  </ul>

  <ul class="nav navbar-nav navbar-right">

    <!--<li><a href="/project/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>-->
    <li><a href="/project/admin/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
  </ul>
</div>
</nav>
