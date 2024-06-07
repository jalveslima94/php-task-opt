<?php

define('ROOT', __DIR__);
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');

$newsManager = NewsManager::getInstance();
$commentManager = CommentManager::getInstance();

foreach ($newsManager->listNews() as $news) {
    echo "############ NEWS " . htmlspecialchars($news->getTitle()) . " ############\n";
    echo htmlspecialchars($news->getBody()) . "\n";
    foreach ($commentManager->listCommentsByNewsId($news->getId()) as $comment) {
        echo "Comment " . htmlspecialchars($comment->getId()) . " : " . htmlspecialchars($comment->getBody()) . "\n";
    }
}
