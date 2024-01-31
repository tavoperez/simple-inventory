<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">
<?php 
    require_once"./php/db.php";
    if(!isset($_GET['page'])){
        $pages = 1;
    }else{
        $pages= (int) $_GET['page'];
        if($pages <= 1){
            $pages=1;
        }
    }
    $pages= str_clear($pages);
    $url= "index.php?view=user_list&page=";
    $register=5;
    $search= "";

    require_once"./php/user_lists.php";
?>
</div>