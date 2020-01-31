<?php


namespace Source\Controllers;


use Source\Models\User;

/**
 * Class Auth
 * @package Source\Controllers
 */
class Auth extends Controller
{

    /**
     * Auth constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @param array $data
     */
    public function login(array $data): void
    {
        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data["passwd"], FILTER_DEFAULT);

        if (!$email || !$passwd) {
            echo $this->ajaxResponse(MESSAGE_MSG, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => "Informe seu e-mail e sua senha para logar",
            ]);
            return;
        }

        $user = (new User())->find("email= :e", "e={$email}")->fetch();
        if (!$user || password_verify($passwd, $user->passwd)) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => "E-mail e/ou senha inválido(s)"
            ]);
            return;
        }

        session(SESSION_USER_ID, $user->id);
        echo $this->ajaxResponse(RESPONSE_REDIRECT, [RESPONSE_URL => $this->router->route("app.home")]);
    }

    /**
     * @param array $data
     */
    public
    function register(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (in_array("", $data)) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => "Preencha todos os campos para se cadastrar"
            ]);
            return;
        }

        $user = new User();
        $user->first_name = $data["first_name"];
        $user->last_name = $data["last_name"];
        $user->email = $data["email"];
        $user->passwd = password_hash($data["passwd"], PASSWORD_DEFAULT);

        if (!$user->save()) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return;
        }
        session(SESSION_USER_ID, $user->id);

        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("app.home")
        ]);
    }

}