<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
    const PASSWD_MIN_LENGTH = 5;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name", "email", "passwd"]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        return ($this->validateEmail() && $this->validatePasswd() && parent::save()) ? true : false;
    }

    /**
     * @return bool
     */
    protected function validateEmail(): bool
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new \Exception("O e-mail informado não é válido");
            return false;
        }

        if ($this->find("email = :e", "e={$this->email}")->count() && empty($this->id)) {
            $this->fail = new \Exception("Já existe um usuário cadastrado com esse e-mail");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validatePasswd(): bool
    {
        if (empty($this->passwd) || strlen($this->passwd) < User::PASSWD_MIN_LENGTH) {
            $this->fail = new \Exception("Informe uma senha com pelo menos " . User::PASSWD_MIN_LENGTH . " caractetes");
            return false;
        }

        if (password_get_info($this->passwd)["algo"]) {
            return true;
        }

        $this->passwd = password_hash($this->passwd, PASSWORD_DEFAULT);
        return true;
    }


}