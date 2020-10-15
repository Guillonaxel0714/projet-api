<?php

use Firebase\JWT\JWT;

require "Database.php";
require 'vendor/autoload.php';

$db = new Database();

$page = ucfirst($_GET["page"]);
if ($page == "Dist") {
    header("Location: /projet-api/dist/index.html");
}
require $page.".php";
$class = new $page();
$method = false;
$role= array();


if (key_exists("method", $_GET)) {
    $method = $_GET["method"];
}
$infos;
if (key_exists("token", $_COOKIE)) {
    $infos = JWT::decode($_COOKIE["token"], "demo", array('HS256'));
}

if (key_exists("apiKey", $_COOKIE)) {

    $role = $db->queryReturn("SELECT role FROM client 
                    WHERE apiKey =" . $_COOKIE["apiKey"]);
}


switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (key_exists("id", $_GET)) {
            $class->getOne($_GET["id"]);
        } else {
            $class->getAll();
        }
        break;
    case 'POST':
        if ($page === "Client" || $page === "User") {
            if ($method === "connexion") {
                $class->connexion($_POST);
            }
        } else {
            // $class->save($_POST);
        }

    break;
    case 'PUT':
        // if (in_array("ROLE_ADMIN", $role)) {
            $class->put($_GET["id"], file_get_contents("php://input"));
        // } else {
        //     $db->sendData("Vous n'avez pas les droits");
        // }
    break;
    case 'DELETE':
        // var_dump($_GET);
        // if (in_array("ROLE_USER", $role)) {
            $class->delete($_GET["id"],);
        // }
    break;

    default:
        # code...
        break;
}