<?php

if(isset($_POST['getYear'])){
    echo $_POST['getYear'];


    header("Location: dashboard.php?year=".$_POST['getYear']);
}


?>