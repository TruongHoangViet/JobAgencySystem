
<?php
$currLocation = basename($_SERVER['PHP_SELF']);

$arrHrefs = array("index.php", "postjobform.php", "about.php", "searchjobform.php");

$arrBtnNames = array("Home", "Post Job", "About", "Search Jobs");
?>

</nav>
</nav>

<!-- 3 navigation buttons on each page -->

<nav class="navButtons">
  <?php
  if ($currLocation == "index.php") {
    array_splice($arrHrefs, 0, 1);
    array_splice($arrBtnNames, 0, 1);
  } elseif ($currLocation == "postjobform.php" || $currLocation == "postjobprocess.php") {
    array_splice($arrHrefs, 1, 1);
    array_splice($arrBtnNames, 1, 1);
  } elseif ($currLocation == "about.php") {
    array_splice($arrHrefs, 2, 1);
    array_splice($arrBtnNames, 2, 1);
  } elseif ($currLocation == "searchjobform.php"   || $currLocation == "searchjobprocess.php") {
    array_splice($arrHrefs, 3, 1);
    array_splice($arrBtnNames, 3, 1);
  } else {
    echo "<p>Error! Page could not be found.</p>";
  }

  for ($i = 0; $i < count($arrHrefs); $i++) {
    echo $arrNewLinks = "<a href='$arrHrefs[$i]'>$arrBtnNames[$i]</a>";
  }
  ?>

</nav>
</body>

</html>