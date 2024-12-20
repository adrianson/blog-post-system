<?php
include "PostManager.php";

$postManager = new PostManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        !empty(htmlspecialchars($_POST["title"]))
        && !empty(htmlspecialchars($_POST["content"]))
    ) {
        $title = htmlspecialchars($_POST["title"]);

        $content = htmlspecialchars($_POST["content"]);

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

        $postManager->editPost($title, $content, $categories, $newCategoriesTrimmed);
    }

    // return to home page
    header("Location: index.php");
}