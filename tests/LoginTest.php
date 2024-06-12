<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("193.203.168.104", "u535044803_db_overstocks", "JeSuisUnMotDePasseSécurisé123!", "u535044803_db_overstocks");
        $password = password_hash("password", PASSWORD_BCRYPT);
        $this->conn->query("INSERT INTO users (nameOfUser, mailOfUSer, passwordHash) VALUES ('testuser', 'testuser@example.com', '$password')");
    }

    public function testLogin()
    {
        $email = "testuser@example.com";
        $password = "password";

        $sql = "SELECT * FROM user WHERE mailOfUSer=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->assertTrue(password_verify($password, $row['password']));
        } else {
            $this->fail("Email not found");
        }
        $stmt->close();
    }

    protected function tearDown(): void
    {
        $this->conn->query("DELETE FROM users WHERE email='testuser@example.com'");
        $this->conn->close();
    }
}
?>
