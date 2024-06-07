<?php

class NewsManager
{
    private static $instance = null;

    private function __construct()
    {
        require_once(ROOT . '/utils/DB.php');
        require_once(ROOT . '/class/News.php');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function listNews()
    {
        $db = DB::getInstance();
        $rows = $db->select('SELECT * FROM `news`');
        return $this->mapRowsToNews($rows);
    }

    public function addNews($title, $body)
    {
        $db = DB::getInstance();
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (?, ?, ?)";
        $db->execute($sql, [$title, $body, date('Y-m-d')]);
        return $db->lastInsertId();
    }

    public function deleteNews($id)
    {
        $commentManager = CommentManager::getInstance();
        foreach ($commentManager->listCommentsByNewsId($id) as $comment) {
            $commentManager->deleteComment($comment->getId());
        }

        $db = DB::getInstance();
        $sql = "DELETE FROM `news` WHERE `id` = ?";
        return $db->execute($sql, [$id]);
    }

    private function mapRowsToNews($rows)
    {
        $newsList = [];
        foreach ($rows as $row) {
            $news = new News();
            $news->setId($row['id'])
                ->setTitle($row['title'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at']);
            $newsList[] = $news;
        }
        return $newsList;
    }
}
