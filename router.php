<?php

$matches=[];
if(preg_match('/\/([^\/]+)\/([^\/]+)/',$_SERVER["REQUEST_URI"],$matches))
{
    $_GET['resourses_type']=$matches[1];    
    $_GET['resource_id']=$matches[2];
    error_log(print_r($matches,1));
    require 'estructuraBasic.php';
}else if(preg_match('/\/([^\/]+)\/?/',$_SERVER["REQUEST_URI"],$matches))
{
    $_GET['resourses_type']=$matches[1];        
    error_log(print_r($matches,1));
    require 'estructuraBasic.php';
}else
{
    error_log('No matches');
    http_response_code(404);
}

?>