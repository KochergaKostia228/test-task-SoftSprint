<?php
class UserRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT id, first_name, last_name, status, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE id = :id'
        );

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $movie = $stmt->fetch();

        return $movie ?: null;
    }

    public function create(string $first_name, string $last_name, int $status, int $role)
    {
        $sql = '
            INSERT INTO users (first_name, last_name, status, role)
            VALUES (:first_name, :last_name, :status, :role)
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'status' => $status,
            'role' => $role,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, string $first_name, string $last_name, int $status, int $role)
    {
        $sql = '
            UPDATE users
            SET first_name = :first_name,
                last_name = :last_name,
                status = :status,
                role = :role
            WHERE id = :id
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'status' => $status,
            'role' => $role,
        ]);
    }

    public function updateStatus(int $id, int $status)
    {
        $sql = '
            UPDATE users
            SET status = :status
            WHERE id = :id
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'status' => $status,
        ]);
    }

    public function delete(int $id){
        $stmt = $this->pdo->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
    }
}
