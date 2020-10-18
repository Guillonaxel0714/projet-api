<?php

$page = ucfirst($_GET["page"]);
require $page.".php";
$class = new $page();

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if (key_exists("id", $_GET)) {
            $class->getOne($_GET["id"]);
        } else {
            $class->getAll();
        }
        break;
    case 'POST':
        $class->save($_POST);
    break;
    case 'PUT':
        var_dump($_POST);
        // $class->put($_GET["id"], $_POST);
    break;
    case 'DELETE':
        $class->delete($_GET["id"],);
    break;

    default:
        # code...
        break;
}