<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization,X-Requested-With');
  
  
  /* Instantiate DB and Post */
  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  $db_obj = new Database;
$db  = $db_obj->connect();

$post_obj = new Post($db);

$data = json_decode(file_get_contents('php://input'));

$post_obj->id = $data->id;
$post_obj->title = $data->title;
$post_obj->body = $data->body;
$post_obj->author = $data->author;
$post_obj->category_id = $data->category_id;

if($post_obj->update()){
    echo json_encode(['message'=>'post updated successfully']);
}else{
    echo json_encode(['message'=>'Post not Updated']);
}