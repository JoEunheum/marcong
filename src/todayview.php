<?php

$idnumber = $_GET['idnumber'];

if(isset($_COOKIE['todayview'])){
  $temp = explode(" , ", $_COOKIE['todayview']);
  if(!in_array($idnumber, $temp))
  {
    setcookie('todayview', $_COOKIE['todayview']. ' , ' .$idnumber, time()+86400,'/');
  }
}else{
  setcookie('todayview',$idnumber,time()+86400,'/');
}
echo $idnumber;
 ?>
