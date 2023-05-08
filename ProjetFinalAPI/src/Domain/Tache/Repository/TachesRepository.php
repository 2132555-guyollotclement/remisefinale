<?php

namespace App\Domain\Tache\Repository;

use PDO;

class TachesRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function insereTache(array $tache): int
    {
        $sql = "INSERT INTO taches (titre, description) VALUES (:titre, :description)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':titre', $tache['titre']);
        $stmt->bindParam(':description', $tache['description']);

        $stmt->execute();

        return (int)$this->connection->lastInsertId();
    }

    public function selectTaches(): array
    {
        $sql = "SELECT * FROM taches";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateTache(int $tacheId, array $tache): void
    {
        $sql = "UPDATE taches SET termine = :termine WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $tacheId);
        $stmt->bindParam(':termine', $tache['termine']);

        $stmt->execute();
    }

    public function deleteTache(int $tacheId): void
    {
        $sql = "DELETE FROM taches WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $tacheId);

        $stmt->execute();
    }

    public function chercherUtilisateur(string $username): ?array
{
    $sql = "SELECT * FROM users WHERE username = :username;";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(':username', $username);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    return (array)$row;
}


}
