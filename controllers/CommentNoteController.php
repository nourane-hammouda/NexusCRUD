<?php
require_once __DIR__ . '/../models/CommentNotes.php';
require_once __DIR__ . '/../config/config.php';

class CommentNoteController {
    private $commentNoteModel;

    public function __construct($pdo) {
        $this->commentNoteModel = new CommentNote($pdo); // Connexion DB
    }

    // Ajouter un commentaire/note
    public function create($comment, $project_id, $user_id) {
        return $this->commentNoteModel->addCommentNote($comment, $project_id, $user_id);
    }

    // Récupérer tous les commentaires/notes
    public function index() {
        return $this->commentNoteModel->getAllCommentsNotes();
    }

    // Modifier un commentaire/note
    public function update($id, $comment) {
        return $this->commentNoteModel->updateCommentNote($id, $comment);
    }

    // Supprimer un commentaire/note
    public function delete($id) {
        return $this->commentNoteModel->deleteCommentNote($id);
    }
}

?>
