<?php

require('db.php');
$id ="";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {        
    $id =$_GET['id'];    
    $stmt = $pdo->exec("DELETE FROM recipes WHERE id=$id");    
}
header("Location: http://localhost/index.php");

?>