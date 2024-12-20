<?php
include "PostManager.php";

$postManager = new PostManager();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your blog</title>
</head>

<body>
    <header>
        <h1>Your Blog</h1>
        <hr />
    </header>

    <main>
        <a href="post-creator.php"><button>Create a new post</button></a>

        <br />
        <br />

        <a href="search.php"><button>Search your posts</button></a>

        <h2>Browse your posts</h2>

        <form action="post-viewer.php" method="POST" style="height: 300px; width: 20%; overflow-y: scroll;">
            <?php

            // get posts and populate the list of published posts
            $posts = $postManager->getPosts();

            foreach ($posts as $post) {
                echo $post['datetime'] . " -- <input type=\"submit\" name=\"title\" value=\"" . $post["title"] . "\"><br />";
            }
            ?>
        </form>
    </main>
</body>

</html>