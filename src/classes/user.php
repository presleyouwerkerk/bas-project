<?php

namespace BasProject\classes;

class User
{
    private $connection;
    private $rolNaam;
    private $rolWachtwoord;

    public function __construct(Connection $connection, $rolNaam, $rolWachtwoord)
    {
        $this->connection = $connection;
        $this->rolNaam = $rolNaam;
        $this->rolWachtwoord = $rolWachtwoord;
    }

    public function loginUser(): bool
    {
        try {
            $pdo = $this->connection->getPdo();

            $query = "SELECT rolId, rolWachtwoord FROM gebruikers WHERE rolNaam = :rolNaam";

            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':rolNaam', $this->rolNaam);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($this->rolWachtwoord === $user['rolWachtwoord']) {
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

    public function validateUser(): array
    {
        $errors = [];
    
        if (empty($this->rolNaam) || empty($this->rolWachtwoord)) {
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
