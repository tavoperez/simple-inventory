<?php
# Conexion a la base de datos #
function connection (){
    $host = "mysql";
    $port = '3306';
    $dbname = 'inventario';
    $username = 'root';
    $password = 'root';
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        return $pdo;
        //$pdo->query('INSERT INTO category(category, category_location) VALUES ("prueba", "texto hubicacion")');
        
    } catch (PDOException $e) {
        echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    }
}
# Verificar datos #
function check_data ($filter, $string){
    if(preg_match('/^'.$filter.'$/', $string)){
        return false;
    }else{
        return true;
    }
}
# Limpiar cadenas de texto #
function str_clear($string){
    $string=trim($string);
    $string=stripslashes($string);
    $string=str_ireplace("<script>", "", $string);
    $string=str_ireplace("</script>", "", $string);
    $string=str_ireplace("<script src", "", $string);
    $string=str_ireplace("<script type=", "", $string);
    $string=str_ireplace("SELECT * FROM", "", $string);
    $string=str_ireplace("DELETE FROM", "", $string);
    $string=str_ireplace("INSERT INTO", "", $string);
    $string=str_ireplace("DROP TABLE", "", $string);
    $string=str_ireplace("DROP DATABASE", "", $string);
    $string=str_ireplace("TRUNCATE TABLE", "", $string);
    $string=str_ireplace("SHOW TABLES;", "", $string);
    $string=str_ireplace("SHOW DATABASES;", "", $string);
    $string=str_ireplace("<?php", "", $string);
    $string=str_ireplace("?>", "", $string);
    $string=str_ireplace("--", "", $string);
    $string=str_ireplace("^", "", $string);
    $string=str_ireplace("<", "", $string);
    $string=str_ireplace("[", "", $string);
    $string=str_ireplace("]", "", $string);
    $string=str_ireplace("==", "", $string);
    $string=str_ireplace(";", "", $string);
    $string=str_ireplace("::", "", $string);
    $string=trim($string);
    $string=stripslashes($string);
    return $string;
}
# Funcion renombrar fotos #
function rename_image($name){
    $name=str_ireplace(" ", "_", $name);
    $name=str_ireplace("/", "_", $name);
    $name=str_ireplace("#", "_", $name);
    $name=str_ireplace("-", "_", $name);
    $name=str_ireplace("$", "_", $name);
    $name=str_ireplace(".", "_", $name);
    $name=str_ireplace(",", "_", $name);
    $name=$name."_".rand(0,100);
    return $name;
}
# funcion paginador de pagina
function table_page($page, $N_pages, $url, $btn){
    $table= '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

    if($page<=1){
        $table.='
        <a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">
        ';
    }else{
        $table.='
        <a class="pagination-previous" href="'.$url.($page-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
        ';
    }

    $count=0;
    for($i=$page; $i<=$N_pages; $i++){
        if($count>=$btn){
            break;
        }

        if($page==$i){
            $table.='
                <li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>
            ';
        }else{
            $table.='
                <li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>
            ';
        }
        $count++;
    }

    if($page==$N_pages){
        $table.='
        </ul>
        <a class="pagination-next is-disabled" disabled>Siguiente</a>
        ';
    }else{
        $table.='
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" href="'.$url.$N_pages.'">'.$N_pages.'</a></li>
        </ul>
        <a class="pagination-next" href="'.$url.($page+1).'">Siguiente</a>
        ';
    }

    $table.= '</nav>';
    return $table;
}