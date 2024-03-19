<?php 
ob_start();
    include("header.php");
?>


<?php
    count($product->getData(table: 'cart')) ? include("./Template/_cart-template.php") : include('./Template/notFound/_cartNotFound.php');


    include("./Template/_wishlist-template.php");

    include("./Template/_new-phones.php");
?>


<?php 
    include("footer.php");
?>