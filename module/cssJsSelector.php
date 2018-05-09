<?php  

// style script link selector
if( strpos(strtolower($_SERVER["PHP_SELF"]) , "product.php" )){
	echo '<link rel="stylesheet" type="text/css" href="css/product.css">';
	echo '<script src="javascript/product.js"></script>';
}else{
	
}

?>
