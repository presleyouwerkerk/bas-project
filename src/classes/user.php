<?php

namespace BasProject\classes;

class User
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function loginUser(array $userData): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT rolId, rolWachtwoord FROM gebruikers WHERE rolNaam = :rolNaam";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':rolNaam', $userData['username']);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($userData['password'] === $user['rolWachtwoord']) {
                    $_SESSION['roleId'] = $user['rolId'];
                    return true;
                }
            }
            return false;
        } catch (\PDOException $e) {
            error_log("Error logging in: " . $e->getMessage());
            return false;
        }
    }

    public function validateUser(array $userData): array
    {
        $errors = [];

        if (empty($userData['username']) || empty($userData['password'])) {
            $errors[] = "Fields cannot be empty";
        }
        return $errors;
    }

    public function logout()
    {
        session_unset();

        session_destroy();
    }
}
