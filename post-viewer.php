<?php
include "PostManager.php";

$postManager = new PostManager();

$categories = $postManager->getPostCategories();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your blog</title>
</head>

<body>
    <?php
    include "header.html";
    ?>

    <?php
    if (isset($_POST["title"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        $title = $_POST["title"];

        $post = $postManager->getPost($title);

        // title
        echo "<h2>" . $post->getTitle() . "</h2>";

        // datetime
        echo "Published at: " . $post->getDatetime() . "<br /><br />";

        // content
        echo $post->getContent() . "<br />";

        // categories
        echo "<h3>Categories:</h3>";

        echo "<form action=\"searchCategories.php\" method=\"GET\" style=\"height: 100px; width: 20%; overflow-y: scroll;\">";
        foreach ($post->getCategories() as $category) {
            echo "<input type=\"submit\" name=\"category\" value=\"" . $category . "\"><br />";
        }
        echo "</form><br />";

        // edit post button
        echo "<form action=\"post-editor.php\" method=\"POST\">";
        echo "<label for=\"submit\">Edit post: </label>";
        echo "<input id=\"submit\" type=\"submit\" name=\"title\" value=\"" . $title . "\">";
        echo "</form><br />";

        // delete post button
        echo "<form action=\"delete-post.php\" method=\"POST\">";
        echo "<label for=\"submit\" style=\"color: red\">Delete post: </label>";
        echo "<input id=\"submit\" type=\"submit\" name=\"title\" value=\"" . $title . "\">";
        echo "</form>";
    }
    ?>
</body>

</html>