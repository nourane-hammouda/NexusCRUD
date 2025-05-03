<?php
require_once __DIR__ . '/../config/config.php';
class CommentNote {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CREATE : Ajouter un commentaire/note
    public function addCommentNote($comment, $project_id, $user_id) {
        $sql = "INSERT INTO comments_notes (message, project_id, employee_id) VALUES (:message, :project_id, :employee_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['comment' => $comment, 'project_id' => $project_id, 'user_id' => $user_id]);
    }

    // READ : Récupérer tous les commentaires/notes
    public function getAllCommentsNotes() {
        $sql = "SELECT * FROM comments_notes";
        return $this->pdo->query($sql)->fetchAll();
    }

    // UPDATE : Modifier un commentaire/note
    public function updateCommentNote($id, $comment) {
        $sql = "UPDATE comments_notes SET comment = :comment WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'comment' => $comment]);
    }

    // DELETE : Supprimer un commentaire/note
    public function deleteCommentNote($id) {
        $sql = "DELETE FROM comments_notes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
