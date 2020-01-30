<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
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
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = "O e-mail informado não é válido";
            return false;
        }

        if ($this->find("email = :e", "e={$this->email}")->count()) {
            $this->fail = "O e-mail informado já está cadastrado";
            return false;
        }

        return parent::save();
    }
}