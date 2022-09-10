<?php 
include "functions.php";
$message ="";
$response = deleteaddress();
if($response['succuss']==true){
    header('location:address.php');
}else{
    $message =$response['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <span><?php if(!empty($message)){ echo $message; }?></span>
</body>
</html> 