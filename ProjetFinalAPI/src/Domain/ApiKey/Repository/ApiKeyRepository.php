<?php

namespace App\Domain\ApiKey\Repository;

use PDO;

class ApiKeyRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getUserByApiKey(string $apiKey): ?array
    {
        $sql = "SELECT * FROM users WHERE api_key = :api_key";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':api_key', $apiKey);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }


    public function creerApiKey(array $data): ?string
{
    // Générer une nouvelle clé API
    $apiKey = bin2hex(random_bytes(16));

    // Insérer la clé API dans la base de données pour l'utilisateur
    $sql = "UPDATE users SET api_key = :api_key WHERE username = :username";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':api_key', $apiKey);
    $stmt->bindParam(':username', $data['username']);
    $stmt->execute();

    return $apiKey;
}


public function verifierIdentifiantsUsager(string $username): ?array
{
    $sql = "SELECT * FROM users WHERE username = :username";
    $statement = $this->connection->prepare($sql);
    $statement->bindParam(':username', $username);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}


/**
     * Mettre à jour la clé API pour un utilisateur spécifié
     *
     * @param int $userId
     * @param string $apiKey
     * @return bool
     */
    public function updateApiKey(int $userId, string $apiKey): bool
    {
        $sql = "UPDATE users SET api_key=:api_key WHERE id=:id";
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->execute(['api_key' => $apiKey, 'id' => $userId]);

        return $result;
    }

    public function LireCleApi(array $data): ?string
    {
        $sql = "SELECT api_key FROM users WHERE username = :username";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam('username', $username);
        $statement->execute();

        $user = $statement->fetch();

        return null;
    }

}

