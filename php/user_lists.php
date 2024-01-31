<?php
$init = ($pages > 0) ? (($pages*$register)-$register) : 0;
$table = "";

if (isset($search) && !empty($search)) {
    $query_data = "SELECT * FROM user WHERE ((user_id!='".$_SESSION['id']."') AND (user_name LIKE '%$search%' OR lastname LIKE '%$search%' OR user_sesion LIKE '%$search%' OR email LIKE '%$search%')) ORDER BY user_name ASC LIMIT $init,$register";

    $query_total = "SELECT COUNT(user_id) FROM user WHERE ((user_id!='".$_SESSION['id']."') AND (user_name LIKE '%$search%' OR lastname LIKE '%$search%' OR user_sesion LIKE '%$search%' OR email LIKE '%$search%'))";
} else {
    $query_data = "SELECT * FROM user WHERE ((user_id!='".$_SESSION['id']."')) ORDER BY user_name ASC LIMIT $init,$register";

    $query_total = "SELECT COUNT(user_id) FROM user WHERE user_id !='".$_SESSION['id']."'";
}



$connection = connection();

$data = $connection->query($query_data);
$data=$data->fetchAll();
$total= $connection->query($query_total);
$total = (int) $total->fetchColumn();
$n_pages = ceil($total/$register);
$table .= '
    <div class="table-container">
    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
        <thead>
            <tr class="has-text-centered">
                <th>#</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Email</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>
        <tbody>
';
if($total>= 1 && $pages <= $n_pages){
    $count=$init+1;
    $init_page = $init=+1;
    foreach($data as $rows){
        $table.='
            <tr class="has-text-centered" >
                <td>'.$count.'</td>
                <td>'.$rows['user_name'].'</td>
                <td>'.$rows['lastname'].'</td>
                <td>'.$rows['user_sesion'].'</td>
                <td>'.$rows['email'].'</td>
                <td>
                    <a href="index.php?view=user_update&user_id_up='.$rows['user_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$pages.'&user_id_delete='.$rows['user_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $count++;
    }
    $final_page = $count-1;
}else{
    if($total>= 1){
        $table.='
            <tr class="has-text-centered" >
                <td colspan="7">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    }else{
        $table.='
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}


$table.='
    </tbody></table></div>
';

if($total>= 1 && $pages <= $n_pages){
    $table.='<p class="has-text-right">Mostrando usuarios <strong>'.$init_page.'</strong> al <strong>'.$final_page.'</strong> de un <strong>total de '.$total.'</strong></p>';
}


$connection=null;
echo $table;

if($total>=1 && $pages<=$n_pages){
    echo table_page($pages, $n_pages, $url, 5);
}