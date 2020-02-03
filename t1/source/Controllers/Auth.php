<?php


namespace Source\Controllers;


use Source\Models\User;
use Source\Support\Email;

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

        session(SESSION_USER, $user->id);
        echo $this->ajaxResponse(RESPONSE_REDIRECT, [RESPONSE_URL => $this->router->route("app.home")]);
    }

    /**
     * @param array $data
     */
    public function register(array $data): void
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
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => $user->fail()->getMessage()
            ]);
            return;
        }
        session(SESSION_USER, $user->id);

        echo $this->ajaxResponse(RESPONSE_REDIRECT, [
            RESPONSE_URL => $this->router->route("app.home")
        ]);
    }

    /**
     * @param array $data
     */
    public function forget(array $data): void
    {
        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR, MESSAGE_MSG => "Informe seu E-MAIL para recuperar sua senha"
            ]);
            return;
        }

        $user = (new User())->find("email = :e", "e={$email}")->fetch();
        if (!$user) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => "O E-MAIL informado não está cadastrado"
            ]);
            return;
        }

        $user->forget = md5(uniqid(rand()));
        if (!$user->save()) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => $user->fail()->getMessage()
            ]);
            return;
        }

        session(SESSION_FORGET, $user->id);

        $email = new Email();
        $email->add(
            "Recuperação de Senha | " . site("name"),
            $this->view->render("emails/recover", [
                "user" => $user, "link" => $this->router->route("web.reset", [
                    "email" => $user->email,
                    "forget" => $user->forget
                ])
            ]),
            "{$user->first_name} {$user->last_name}",
            $user->email
        );

        if (!$email->send()) {
            echo $this->ajaxResponse(RESPONSE_MESSAGE, [
                MESSAGE_TYPE => MESSAGE_TYPE_ERROR,
                MESSAGE_MSG => "{$email->error()->getCode()} - {$email->error()->getMessage()}"
            ]);
            return;
        }

        flash(MESSAGE_TYPE_SUCCESS, "Tudo certo {$user->first_name}! Enviamos um link de recuperação para seu e-mail");
        echo $this->ajaxResponse(RESPONSE_REDIRECT, [RESPONSE_URL => $this->router->route("web.forget")]);
    }

    public function reset(array $data): void
    {
        if (empty(session(SESSION_FORGET)) || !$user = (new User())->findById(session(SESSION_FORGET))) {
            flash(MESSAGE_TYPE_INFO, "Informe seu E-MAIL para recuperar sua senha");
            $this->router->redirect("web.forget");
        }

    }

}