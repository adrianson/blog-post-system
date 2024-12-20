<?php
include "PostManager.php";

$postManager = new PostManager();
$categoriesAvailable = $postManager->getPostCategories();

$title = '';
$content = '';
$categories = [];

if (isset($_POST["title"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $content = "";
    $categories = [];

    $posts = $postManager->getPosts();

    // read in the post's content and categories
    foreach ($posts as $post) {

        if ($post['title'] == $title) {

            $content = $post['content'];
            $categories = $post['categories'];
        }
    }
}
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

    <h2>Edit post</h2>

    <form action="edit-post.php" method="POST">

        <!-- title -->
        <label for="new-post-title">Post title:</label>
        <br />

        <input type="text" id="new-post-title" name="title" value="<?php echo $title ?>" readonly>
        <p style="color: red;">Post title cannot be changed</p>
        <br /><br />

        <!-- content -->
        <label for="new-post-content">Post content:</label>
        <br />

        <textarea id="new-post-content" rows="10" cols="30" name="content" required><?php echo $content ?></textarea>
        <br /><br />

        <!-- existing categories -->
        <?php echo "Categories:" ?>

        <div style="height: 100px; width: 20%; overflow-y: scroll;">
            <?php
            foreach ($categoriesAvailable as $key => $category) {

                echo "<br /><input type=\"checkbox\" id=\"category-$key\" name=\"categories[]\" value=\"$category\"";

                // mark the categories selected/added for the post as checked
                if (in_array($category, $categories)) {
                    echo " checked";
                }

                echo ">";

                echo "<label for=\"category-$key\">$category</label>";
            }
            ?>
        </div>
        <br />

        <!-- add new categories -->
        <label for="new-categories">Enter new categories as a semicolon-separated list:</label>
        <br />

        <textarea id="new-categories" rows="5" cols="30" name="new-categories"></textarea>
        <br />

        <!-- submit -->
        <input type="submit" value="Submit">
    </form>
</body>

</html>