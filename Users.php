<?php

    require './Database.php';
    $request_method = $_SERVER["REQUEST_METHOD"];


    switch($request_method)
    {
      case 'GET':
        if(!empty($_GET["id"]))
        {

          // Récupérer un seul produit
          $id = intval($_GET["id"]);
          getUsers($id);
        }
        else
        {

          // Récupérer tous les produits
          getUsers();
        }
        break;
      default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
    }

    function getUser($id=0)
    {
      global $conn;
      $query = "SELECT * FROM user";
      if($id != 0)
      {
        $query .= " WHERE id=".$id." LIMIT 1";
      }
      $response = array();
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_array($result))
      {
        $response[] = $row;
      }
      header('Content-Type: application/json');
      echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function getUsers()
    {
      global $conn;
      $query = "SELECT * FROM user";
      $response = array();
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_array($result))
      {
        $response[] = $row;
      }
      header('Content-Type: application/json');
      echo json_encode($response, JSON_PRETTY_PRINT);
    }




?>