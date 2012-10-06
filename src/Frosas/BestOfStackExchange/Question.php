<?php

namespace Frosas\BestOfStackExchange;

class Question
{
    private $title;
    private $url;
    private $tags;

    function __construct($title, $url, array $tags)
    {
        $this->title = $title;
        $this->url = $url;
        $this->tags = $tags;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getUrl()
    {
        return $this->url;
    }

    function getTags()
    {
        return $this->tags;
    }
}
