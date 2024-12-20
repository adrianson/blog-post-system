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
    <title>Delete categories</title>
</head>

<body>
    <?php
    include "header.html";
    ?>

    <h2>Delete post categories</h2>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

        <div style="height: 100px; width: 20%; overflow-y: scroll;">
            <?php
            foreach ($categories as $key => $category) {
                echo "<br /><input type=\"checkbox\" id=\"category-$key\" name=\"categories[]\" value=\"$category\">";
                echo "<label for=\"category-$key\">$category</label>";
            }
            ?>
        </div>

        <input type="submit" value="Delete">
    </form>

    <?php
    if (isset($_POST["categories"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        $categories = $_POST["categories"];

        $postManager->deleteCategories($categories);

        // return to home page
        header("Location: index.php");
    }
    ?>
</body>

</html>