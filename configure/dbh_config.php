<?php
 // connect to the database
 $conn = mysqli_connect('localhost', 'yoshi', 'esting123', 'login_test');

 // check connection
 if(!$conn){
     die('Connection error: '. mysqli_connect_error());
    //  echo ;
 }