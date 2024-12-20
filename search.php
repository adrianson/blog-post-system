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
    <title>Search</title>
</head>

<body>
    <?php
    include "header.html";
    ?>

    <h2>Search your posts</h2>

    <!-- title search box -->
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

        <label for="search-terms">Search post by title:</label>
        <br />

        <input type="text" id="search-terms" name="search-term" required>

        <input type="submit" value="Search">
    </form>
    <br />

    <?php
    if (isset($_POST["search-term"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        $searchTerm = htmlspecialchars($_POST["search-term"]);

        if (empty($searchTerm)) {
            echo "Please enter a post title to search for!<br /><br />";
        } else {

            // process search
            $resultList = [];
            $resultList = $postManager->searchPosts("title", $searchTerm);

            // response
            if (empty($resultList)) {
                echo "No post with title \"$searchTerm\" found!<br /><br />";
            } else {
                echo "<form action=\"post-viewer.php\" method=\"POST\">";
                echo "Post with title <input type=\"submit\" name=\"title\" value=\""
                    . $searchTerm
                    . "\"> found!<br /><br />";
                echo "</form>";
            }
        }
    }
    ?>

    <!-- search the categories -->
    <?php echo "Your post categories:<br />" ?>

    <form action="searchCategories.php" method="GET" style="height: 100px; width: 20%; overflow-y: scroll;">
        <?php
        foreach ($categories as $category) {
            echo "<input type=\"submit\" name=\"category\" value=\"" . $category . "\"><br />";
        }
        ?>
    </form>
    <br />

    <!-- delete categories -->
    <a href="deleteCategories.php"><button>Delete categories</button></a>
</body>

</html>