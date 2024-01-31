<?php
    require_once './language/en.php';
    $search_module = str_clear($_POST['search_module']);
    $modules = ["user", "category", "product"];

    if(in_array($search_module, $modules)){
        $url_modules=[
            "user"=> "user_search",
            "category"=> "category_search",
            "product"=> "product_search"
        ];

        $search_module="search_".$search_module;
        $url_modules=$url_modules[$search_module];

        print_r($url_modules);
        exit();

        // Iniciar busqueda
        if(isset($_POST['txt_search'])){
            $txt = str_clear($_POST['txt_search']);

            if(empty($txt)){
                echo '
                <div class="notification is-danger is-light">
                    <strong>'.$warnig.'</strong><br>
                    '.$search.'
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
                    header("Location: index.php?view=$url_modules", true,303);
                    exit();
                }
            }
        }

        // Eliminar busqueda
        if(isset($_POST['search_delete'])){

        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_search.'
            </div>
            ';
    }