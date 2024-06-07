<?php

class CommentManager
{
    private static $instance = null;

    private function __construct()
    {
        require_once(ROOT . '/utils/DB.php');
        require_once(ROOT . '/class/Comment.php');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function listComments()
    {
        $db = DB::getInstance();
        $rows = $db->select('SELECT * FROM `comment`');
        return $this->mapRowsToComments($rows);
    }

    public function listCommentsByNewsId($newsId)
    {
        $db = DB::getInstance();
        $rows = $db->select('SELECT * FROM `comment` WHERE `news_id` = ?', [$newsId]);
        return $this->mapRowsToComments($rows);
    }

    public function addCommentForNews($body, $newsId)
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (?, ?, ?)";
        $db->execute($sql, [$body, date('Y-m-d'), $newsId]);
        return $db->lastInsertId();
    }

    public function deleteComment($id)
    {
        $db = DB::getInstance();
        $sql = "DELETE FROM `comment` WHERE `id` = ?";
        return $db->execute($sql, [$id]);
    }

    private function mapRowsToComments($rows)
    {
        $comments = [];
        foreach ($rows as $row) {
            $comment = new Comment();
            $comment->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at'])
                ->setNewsId($row['news_id']);
            $comments[] = $comment;
        }
        return $comments;
    }
}
