<?php
class LoginController {
    private $userModel;

    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }

    public function login($username, $password) {
        return $this->userModel->login($username, $password);
    }

    public function verify_token() {
        return $this->userModel->verify_token();
    }
}
?>