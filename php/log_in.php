<?php
require_once "./language/en.php";
#almacenar datos
$user= str_clear($_POST['user']);
$password= str_clear($_POST['password']);

#verificar campos

if(empty($user) || empty($password)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$Required_fields.'
    </div>
    ';
    exit();
}

# verificando integridad de los datos
if(check_data('[a-zA-Z0-9]{4,20}', $user)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_user.'
    </div>
    ';
    exit();
}

if(check_data('[a-zA-Z0-9$@.-]{7,100}', $password)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_password_login.'
    </div>
    ';
    exit();
}

$data = connection();
$data=$data->query("SELECT * FROM user WHERE user_sesion='$user'");

if($data->rowCount() == 1){
    $data=$data->fetch();
    if($data['user_sesion']==$user && password_verify($password, $data['passwords'])){

        $_SESSION['id']=$data['user_id'];
        $_SESSION['name']=$data['user_name'];
        $_SESSION['lastname']=$data['lastname'];
        $_SESSION['user']=$data['user_sesion'];

        if(headers_sent()){
            echo "<script> window.location.href='index.php?view=home'</script>";
        }else{
            header("location:index.php?view=home");
        }
        
    }else{
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_login.'
    </div>
    ';
    }
}else{
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$Required_login.'
    </div>
    ';
}
$data=null;