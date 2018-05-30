<?php  

// style script link selector
if( strpos(strtolower($_SERVER["PHP_SELF"]) , "product.php" )){
	echo '<link rel="stylesheet" type="text/css" href="css/product.css">';
	echo '<script src="javascript/product.js"></script>';
}elseif( strpos(strtolower($_SERVER["PHP_SELF"]) , "cart.php" ) || strpos(strtolower($_SERVER["PHP_SELF"]) , "deliver.php" ) ) {
	echo '<link rel="stylesheet" type="text/css" href="css/cart.css">';
	echo '<script src="javascript/cart.js"></script>';	
}

?>
