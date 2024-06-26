<?php

class Comment
{
    private $id;
    private $body;
    private $createdAt;
    private $newsId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getNewsId()
    {
        return $this->newsId;
    }

    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;
        return $this;
    }
}

