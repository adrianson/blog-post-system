<?php
include "PostManager.php";

$postManager = new PostManager();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search posts by category</title>
</head>

<body>
    <?php
    include "header.html";
    ?>

    <a href="search.php">Go to search</a>

    <?php
    if (isset($_GET["category"]) && $_SERVER["REQUEST_METHOD"] == "GET") {

        // page heading
        echo "<h2>Posts in category: " . $_GET["category"] . "</h2>";

        // output results
        echo "<form action=\"post-viewer.php\" method=\"POST\""
            . "style=\"height: 300px; width: 20%; overflow-y: scroll;\">";

        $posts = $postManager->getPosts();

        // iterate over the posts
        foreach ($posts as $post) {

            // find if any categories match the indicated category
            if (in_array($_GET["category"], $post['categories'])) {

                echo $post['datetime']
                    . " -- <input type=\"submit\" name=\"title\" value=\""
                    . $post["title"]
                    . "\"><br />";

            }

        }

        echo "</form>";

    }
    ?>

</body>

</html>