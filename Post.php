<?php
class Post
{
    private $title = "";
    private $datetime;
    private $categories = [];
    private $filename = "";
    private $content = "";

    function __construct($title, $content, $categories, $datetime = null)
    {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setCategories($categories);
        $this->setDatetime($datetime);
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategories()
    {
        sort($this->categories);

        return $this->categories;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}