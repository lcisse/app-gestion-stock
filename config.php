<?php
if (!defined('BASE_URL')) {
    $root = str_replace('\\', '/', dirname(__DIR__));  
    
    $base_url = str_replace($_SERVER['DOCUMENT_ROOT'], '', $root) . '/app-gestion-stock';

    define('BASE_URL', $base_url); //sans docker
    //define('BASE_URL', 'http://localhost:8080'); // avec docker
}