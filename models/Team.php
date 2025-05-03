<?php

class Team {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllTeams() {
        $stmt = $this->pdo->query("SELECT * FROM teams ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeamById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTeam($name) {
        $stmt = $this->pdo->prepare("INSERT INTO teams (name) VALUES (?)");
        $stmt->execute([$name]);
        return $this->pdo->lastInsertId();
    }

    public function updateTeam($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE teams SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function deleteTeam($id) {
        $stmt = $this->pdo->prepare("DELETE FROM teams WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
