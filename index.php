<?php require "./inc/session_start.php";?>
<!DOCTYPE html>
<html lang="es">
    <?php
        include "./inc/head.php";
    ?>
<body>
    <?php

        if(!isset($_GET['view']) || $_GET['view']==""){
            $_GET['view'] = 'login';
        }

        if(is_file('./view/'.$_GET['view'].'.php') && $_GET['view'] !='login' && $_GET['view'] != '404'){
            
            # denegar acceso a usuarios no logueados
            if(!isset($_SESSION['id']) || isset($_SESSION['id'])=='' || isset($_SESSION['user'])==''){
                include './view/logout.php';
                exit();
            }

            include "./inc/navbar.php";
            include "./view/".$_GET['view'].".php";

            include "./inc/script.php";
        }else{
            if($_GET['view'] == 'login'){
                include "./view/login.php";
            }else{
                include "./view/404.php";
            }
        }
    ?>
</body>
</html>