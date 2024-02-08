<?php
    require_once './language/en.php';
    $search_module = str_clear($_POST['search_module']);
    $modules = ["users", "category", "product"];

    // $searc_module trae en name del input para evaluarlo con los $modules que esperamos
    if(in_array($search_module, $modules)){
        // pasamos indice y el nombre de la vista
        $url_modules=[
            "users"=> "user_search",
            "category"=> "category_search",
            "product"=> "product_search"
        ];

        // asignamos otro valor al array dependiendo de lo que resivimos del search_module
        $url_modules=$url_modules[$search_module];
        $search_module="esearch_".$search_module;

        // Iniciar busqueda
        if(isset($_POST['txt_search'])){
            $txt = str_clear($_POST['txt_search']);
            if(empty($txt)){
                echo '
                <div class="notification is-danger is-light">
                    <strong>'.$warnig.'</strong><br>
                    '.$asearch.'
                </div>
                ';
            }else{
                if(check_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}", $txt)){
                    echo '
                    <div class="notification is-danger is-light">
                        <strong>'.$warnig.'</strong><br>
                        '.$error_search_term.'
                    </div>
                    ';
                }else{
                    $_SESSION[$search_module]= $txt;
                    echo"<script>window.location.href='index.php?view=$url_modules'</script>";
                    exit();
                }
            }
        }

        // Eliminar busqueda
        if(isset($_POST['search_delete'])){
            unset($_SESSION[$search_module]);
            echo"<script>window.location.href='index.php?view=$url_modules'</script>";
            exit();
        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_search.'
            </div>
            ';
    }