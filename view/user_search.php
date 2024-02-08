<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Buscar usuario</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/db.php";

        if(isset($_POST['search_module'])){
            require_once './php/search.php';
        }
        if(!isset($_SESSION['esearch_users']) && empty($_SESSION['esearch_users'])){
    ?>
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off" >
                <input type="hidden" name="search_module" value="users">   
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_search" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit" >Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="search_module" value="users"> 
                <input type="hidden" name="search_delete" value="users">
                <p>Estas buscando <strong>“<?php echo $_SESSION['esearch_users'] ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
            </form>
        </div>
    </div>
    <?php  
        if(!isset($_GET['page'])){
            $pages = 1;
        }else{
            $pages= (int) $_GET['page'];
            if($pages <= 1){
                $pages=1;
            }
        }
        $pages= str_clear($pages);
        $url= "index.php?view=user_search&page=";
        $register=5;
        $search= $_SESSION['esearch_users'];
    
        require_once"./php/user_lists.php";
    } ?>
</div>