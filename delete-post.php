<?php
include "PostManager.php";

$postManager = new PostManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];

    $postManager->deletePost($title);

    // return to home page
    header("Location: index.php");

}