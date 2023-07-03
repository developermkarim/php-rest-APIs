<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';

include_once '../../models/Post.php';

$db_obj  = new Database;
$db = $db_obj->connect();

$post = new Post($db);

/* Data String from json */
$data = json_decode(file_get_contents('php://input'));

$post->id = $data->id;

if($post->delete()){

    echo json_encode(['message'=>'Data deleted successfully']);
}else{
    echo json_encode(['message'=> 'data not deleted']);
}
