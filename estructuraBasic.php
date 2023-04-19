<?php
//autenticacion por http poco segura
/*
$user =array_key_exists('PHP_AUTH_USER',$_SERVER)?$_SERVER['PHP_AUTH_USER']:'';
$pw =array_key_exists('PHP_AUTH_PW',$_SERVER)?$_SERVER['PHP_AUTH_PW']:'';

if($user!== 'juan' || $pw !== '123'){
    die;
}
*/
// autentificacion HMAC
/*
if(!array_key_exists('HTTP_X_HASH',$_SERVER)||!array_key_exists('HTTP_X_TIMESTAMP',$_SERVER)||!array_key_exists('HTTP_X_UID',$_SERVER)){
    die;
}
list($hash,$uid, $timestamp)=[
    $_SERVER['HTTP_X_HASH'],
    $_SERVER['HTTP_X_UID'],
    $_SERVER['HTTP_X_TIMESTAMP'],
]
$secret="!h, no e lo cuentes a nadie";
$newHash=sha1($uid.$timestamp.$secret);

if($newHash !== $hash){
    die;
}*/




//definimos los recuros disponible
$arregloRecursos=[
    'libros',
    'autores',
   'generos' ,
];
//validamos el recurso este disponible
$tipoRecursos=$_GET['resourses_type'];
if(!in_array($tipoRecursos,$arregloRecursos)){
    http_response_code(400);
    die;
}
//defino los recursos
$libros=[
    1=>[
        'titulo'=>'loque el viento se llevo',
        'id_autor'=>2,
        'id_genero'=>2,
    ],
    2=>[
        'titulo'=>'la iliada',
        'id_autor'=>1,
        'id_genero'=>1,
    ],
    3=>[
        'titulo'=>'la odiesa',
        'id_autor'=>1,
        'id_genero'=>1,
    ],
];
header( 'Content-Type: application/json');

//levantamos el id del recuro buscado
$resourseId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';
//generamos la respuesta aumiendo que el peddio es correcto

    switch(strtoupper($_SERVER['REQUEST_METHOD'])){
        case 'GET':
            if(empty($resourseId)){
                echo json_encode($libros);
            }else{
                if(array_key_exists( $resourseId, $libros)){
                    echo json_encode($libros[$resourseId]);
                }
                else{
                    http_response_code(404);
                }
            }
          
            break;
        case 'POST':
            $json = file_get_contents("php://input");
            $libros[] = json_decode($json, true);
            //array_push()
            //echo array_keys($libros)[count($libros)-1];//devuelve el id del ultimo libro que se creo
            echo json_encode( $libros );//devuelve la totalidad de la coleccion
            break;
        case 'PUT':
            //validamo que el recurso buscado exita
            if(!empty($resourseId)&& array_key_exists($resourseId,$libros)){
                //tomamos la entrada cruda
                $json = file_get_contents("php://input");
                $libros[$resourseId] = json_decode($json, true);
                echo json_encode( $libros );//devuelve la totalidad de la coleccion en formato json
            }
            break;
        case 'DELETE':
            //validamo que el registro exita
            if(!empty($resourseId)&& array_key_exists($resourseId,$libros)){
                unset($libros[$resourseId]);
                echo json_encode( $libros );//devuelve la totalidad de la coleccion en formato json

            }

            break;
    }
?>