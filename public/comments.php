<?php
require_once __DIR__ . '/../controllers/CommentNoteController.php';
require_once __DIR__ . '/../config/config.php';

$commentController = new CommentNoteController($pdo);
$comments = $commentController->index();

// Inclure la vue des commentaires
require_once __DIR__ . '/../views/comments_notes/list.php'; 