<?php

$from = "themanusia@themanusia.xyz";
$to = "minecraftindo0@gmail.com";
$subject = "Test";
$message = "gud";
$headers = "From:" .$from;
mail($to,$subject,$message,$headers);
echo "gud";