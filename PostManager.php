<?php
include "PostList.php";

class PostManager
{

    private $postList;

    public function __construct()
    {
        $this->postList = new PostList();
    }

    public function createPost($title, $content, $categories, $newCategories)
    {
        $this->postList->addPost($title, $content, $categories, $newCategories);
    }

    public function deletePost($title)
    {
        $this->postList->removePost($title);
    }

    public function deleteCategories($categories)
    {
        $this->postList->removeCategories($categories);
    }

    public function editPost($title, $content, $categories, $newCategories)
    {
        $this->postList->editPost($title, $content, $categories, $newCategories);
    }

    public function getPost($title)
    {
        return $this->postList->getPost($title);
    }

    public function getPosts()
    {
        return $this->postList->getPosts();
    }

    public function getPostCategories()
    {
        return $this->postList->getPostCategories();
    }

    public function searchPosts($type, $searchTerm)
    {
        $resultList = [];

        // determine by which parameter to search
        if ($type == "title") {

            $resultList = $this->postList->searchTitle($searchTerm);

        } else if ($type == "category") {

            $resultList = $this->postList->searchCategory($searchTerm);
        }

        return $resultList;
    }
}