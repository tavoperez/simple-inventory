<?php
require_once 'db.php';
require '../language/en.php';
# almacenando datos
$name= str_clear($_POST['name']);
$lastname= str_clear($_POST['lastname']);
$user= str_clear($_POST['user']);
$email= str_clear($_POST['email']);
$password= str_clear($_POST['password']);
$repeat_password= str_clear($_POST['repeat_password']);

# verificar campos vacios
if(empty($name) || empty($lastname) || empty($user) || empty($email) || empty($password) || empty($repeat_password)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$Required_fields.'
    </div>
    ';
    exit();
}

# verificando integridad de los datos
if(check_data('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $name)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_name.'
    </div>
    ';
    exit();
}

if(check_data('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $lastname)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_lastname.'
    </div>
    ';
    exit();
}

if(check_data('[a-zA-Z0-9]{4,20}', $user)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_user.'
    </div>
    ';
    exit();
}

if(check_data('[a-zA-Z0-9$@.-]{7,100}', $password) || check_data('[a-zA-Z0-9$@.-]{7,100}', $repeat_password)){
    echo '
    <div class="notification is-danger is-light">
        <strong>'.$warnig.'</strong><br>
        '.$error_repeat_password.'
    </div>
    ';
    exit();
}

# verificacion email
if(!empty($email)){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check = connection();
        $check=$check->query("SELECT email FROM user WHERE email='$email'");
        if($check->rowCount() > 0){
            echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_duplicate_email.'
            </div>
            ';
            exit();
        }
        $check=null;
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>'.$warnig.'</strong><br>
            '.$error_email.'
        </div>
        ';
        exit();
    }
}

# verificar usuario
        $check_user = connection();
        $check_user=$check_user->query("SELECT user_sesion FROM user WHERE user_sesion='$user'");
        if($check_user->rowCount() > 0){
            echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_duplicate_user.'
            </div>
            ';
            exit();
        }
        $check_user=null;

        # verificar claves

        if($password != $repeat_password){
            echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_password.'
            </div>
            ';
            exit();
        }else{
          $key = password_hash($password, PASSWORD_BCRYPT, ['cost'=>10]);
        }

        $data= connection();
        $data= $data->prepare("INSERT INTO user(user_name,lastname,user_sesion,passwords,email) VALUES(:name,:lastname,:user,:key,:email)");

        $markers=[
            ":name"=>$name,
            ":lastname"=>$lastname,
            ":user"=>$user,
            ":key"=>$key,
            ":email"=>$email
        ];
        $data->execute($markers);

        if($data->rowCount() == 1){
            echo '
            <div class="notification is-info is-light">
                <strong>'.$success.'</strong><br>
                '.$user_save.'
            </div>
            ';
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>'.$warnig.'</strong><br>
                '.$error_save.'
            </div>
            ';
            exit();
        }

        $data=null;
        