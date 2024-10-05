<?php
class UserModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to hash passwords
    public function hash_password($password) {
        $salt = bcrypt_gen_salt();
        $hashed_password = bcrypt_hash($password, $salt);
        return $hashed_password;
    }

    // Function to generate a secure token
    public function generate_token() {
        $token = bin2hex(random_bytes(32));
        return $token;
    }

    // Login function
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $hashed_password = $this->hash_password($password);
            if ($hashed_password === $user_data['password']) {
                $token = $this->generate_token();
                setcookie('login_token', $token, time() + 3600, '/', '', true, true);
                // Store the token in the database
                $query = "UPDATE users SET token = '$token' WHERE username = '$username'";
                $this->conn->query($query);
                return true;
            }
        }
        return false;
    }

    // Verify token function
    public function verify_token() {
        if (isset($_COOKIE['login_token'])) {
            $token = $_COOKIE['login_token'];
            $query = "SELECT * FROM users WHERE token = '$token'";
            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                return true;
            }
        }
        return false;
    }
}
?>