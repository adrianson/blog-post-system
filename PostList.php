<?php
include "Post.php";

class PostList
{
    private $listFilename = "posts.txt";
    private $listFile;
    private $posts = [];

    public function __construct()
    {
        // open or create file listing post data
        $this->listFile = fopen($this->listFilename, "a+") or
            die("Unable to retrieve list of posts!");

        // populate post list
        while (!feof($this->listFile)) {

            $line = fgets($this->listFile);

            if (!empty($line)) {
                array_push($this->posts, json_decode($line, true));
            }
        }

        // close file
        fclose($this->listFile);
    }

    public function addPost($title, $content, $categories, $newCategories)
    {
        // disallow creation of posts with identical titles
        foreach ($this->posts as $post) {

            if (isset($post) && $post["title"] == $title) {

                echo "Post with title '$title' already exists!<br />";

                return;
            }
        }

        // merge into one list
        // previously existing categories used on the post and new ones added
        $categories = array_merge($categories, $newCategories);

        $post = new Post($title, $content, $categories);

        // create a list representation for the new post
        $newArray = array(
            // e.g. 2024-12-20 23:27:59
            "datetime" => date("Y-m-d H:i:s"),
            "title" => $post->getTitle(),
            "content" => $post->getContent(),
            "categories" => $post->getCategories()
        );

        // add the new post to the list and sort it
        array_push($this->posts, $newArray);

        sort($this->posts);

        // open file for writing
        $this->listFile = fopen($this->listFilename, "w") or
            die("Unable to retrieve list of posts!");

        foreach ($this->posts as $post) {
            fwrite($this->listFile, json_encode($post) . "\n");
        }

        fclose($this->listFile);
    }

    public function editPost($title, $content, $categories, $newCategories)
    {
        // fetch the Post object
        $post = $this->getPost($title);

        // update post
        $post->setContent($content);

        // merge into one list
        // previously existing categories used on the post and new ones added
        if (!empty($newCategories)) {
            $categories = array_merge($categories, $newCategories);
        }

        $post->setCategories($categories);

        // find the array corresponding to the post in question
        foreach ($this->posts as $key => $array) {

            if (isset($array) && $array["title"] == $title) {

                // store the new content
                $this->posts[$key]["content"] = $post->getContent();
                $array["content"] = $post->getContent();

                // store the new categories
                $this->posts[$key]["categories"] = $post->getCategories();
                $array["categories"] = $post->getCategories();
            }
        }

        sort($this->posts);

        // open file for writing
        $this->listFile = fopen($this->listFilename, "w") or
            die("Unable to retrieve list of posts!");

        foreach ($this->posts as $post) {
            fwrite($this->listFile, json_encode($post) . "\n");
        }

        fclose($this->listFile);
    }

    public function getPost($title)
    {
        $content = '';
        $categories = [];
        $datetime = '';

        // find the array corresponding to the post in question
        foreach ($this->posts as $post) {

            if (isset($post) && $post['title'] == $title) {

                $content = $post['content'];
                $categories = $post['categories'];
                $datetime = $post['datetime'];
            }
        }

        // create and return a new Post object
        $post = new Post(
            $title,
            $content,
            $categories,
            $datetime
        );

        return $post;
    }

    public function getPostCategories()
    {
        $resultList = [];

        // iterate through post data arrays and store any categories present
        foreach ($this->posts as $post) {
            foreach ($post["categories"] as $category) {
                $resultList[] = $category;
            }
        }

        sort($resultList);

        // only return the unique categories in the list
        return array_unique($resultList);
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function removeCategories($categories)
    {
        // iterate through the posts and their categories
        foreach ($this->posts as &$post) {

            foreach ($post["categories"] as $key => $category) {

                // if the category in focus is in the list of categories to be removed...
                if (in_array($category, $categories)) {

                    // ...remove it
                    array_splice($post["categories"], $key, 1);
                }
            }
        }

        // so that the variable no longer holds a reference
        // to the last element of the posts array
        unset($post);

        // open file for writing
        $this->listFile = fopen($this->listFilename, "w") or
            die("Unable to retrieve list of posts!");

        foreach ($this->posts as $post) {
            fwrite($this->listFile, json_encode($post) . "\n");
        }

        fclose($this->listFile);
    }

    public function removePost($title)
    {
        // iterate through the posts and remove the post indicated
        foreach ($this->posts as $key => $post) {

            if (isset($post) && $post["title"] == $title) {

                array_splice($this->posts, $key, 1);
            }
        }

        // open file for writing
        $this->listFile = fopen($this->listFilename, "w") or
            die("Unable to retrieve list of posts!");

        foreach ($this->posts as $post) {
            fwrite($this->listFile, json_encode($post) . "\n");
        }

        fclose($this->listFile);
    }

    public function searchCategory($searchTerm)
    {
        $resultList = [];

        // iterate through the posts and add to the result list
        // any posts that have the category
        foreach ($this->posts as $post) {

            if (isset($post) && in_array($searchTerm, $post["categories"])) {

                $resultList[] = $post['title'];
            }
        }

        return $resultList;
    }

    public function searchTitle($searchTerm)
    {
        $resultList = [];

        // iterate through the posts and add to the result list
        // any post that has the specified title
        foreach ($this->posts as $post) {

            if (isset($post) && $post["title"] == $searchTerm) {

                $resultList[] = $post["title"];
            }
        }

        return $resultList;
    }

}