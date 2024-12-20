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
    <title>Create a new post</title>
</head>

<body>
    <?php
    include "header.html";
    ?>

    <h2>Create a new post</h2>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

        <!-- title -->
        <label for="new-post-title">Enter post title:</label>
        <br />

        <input type="text" id="new-post-title" name="new-post-title" required>
        <br /><br />

        <!-- content -->
        <label for="new-post-content">Enter post content:</label>
        <br />

        <textarea id="new-post-content" rows="10" cols="30" name="new-post-content" required></textarea>
        <br /><br />

        <!-- existing categories -->
        <?php echo "Choose categories:" ?>

        <div style="height: 100px; width: 20%; overflow-y: scroll;">
            <?php
            foreach ($categories as $key => $category) {
                echo "<br /><input type=\"checkbox\" id=\"category-$key\" name=\"categories[]\" value=\"$category\">";
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
        <br />

        <!-- submit -->
        <input type="submit" value="Create">

    </form>

    <?php
    if (isset($_POST["new-post-title"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (
            !empty(htmlspecialchars($_POST["new-post-title"]))
            && !empty(htmlspecialchars($_POST["new-post-content"]))
        ) {
            $title = htmlspecialchars($_POST["new-post-title"]);

            $content = htmlspecialchars($_POST["new-post-content"]);

            // store categories if present
            if (isset($_POST["categories"])) {
                $categories = $_POST["categories"];
            } else {
                $categories = [];
            }

            // create an array of newly added categories
            $newCategories = explode(";", htmlspecialchars($_POST["new-categories"]));

            $newCategoriesTrimmed = [];

            // trim and store non-empty strings as categories
            foreach ($newCategories as &$category) {

                if (!empty(trim($category))) {

                    $newCategoriesTrimmed[] = trim($category);
                }
            }

            // so that the variable no longer holds a reference to the last element of the categories array
            unset($category);

            $postManager->createPost($title, $content, $categories, $newCategoriesTrimmed);
        }

        // return to home page
        header("Location: index.php");
    }
    ?>
</body>

</html>