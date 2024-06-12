<?php
use PHPUnit\Framework\TestCase;

class SignUpTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("193.203.168.104", "u535044803_db_overstocks", "JeSuisUnMotDePasseSécurisé123!", "u535044803_db_overstocks");
    }

    public function testSignUp()
    {
        $username = "testuser";
        $email = "testuser@example.com";
        $password = password_hash("password", PASSWORD_BCRYPT);

        $sql = "INSERT INTO user (nameOfUser, mailOfUser, passwordHash) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        $this->assertTrue($stmt->execute());
        $stmt->close();
    }

    protected function tearDown(): void
    {
        $this->conn->query("DELETE FROM user WHERE email='testuser@example.com'");
        $this->conn->close();
    }
}
?>
