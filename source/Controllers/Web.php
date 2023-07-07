<?php


namespace Source\Controllers;


use Source\Models\User;

/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{

    /**
     * Web constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        if (!empty(session(SESSION_USER))) {
            $this->router->redirect("app.home");
        }
    }

    /**
     * LOGIN
     */
    public function login(): void
    {
        $head = $this->seo->optimize(
            "Faça login para continuar | " . site("name"),
            site("desc"),
            $this->router->route("web.login"),
            image("Login")
        )->render();

        echo $this->view->render("theme/login", [
            "head" => $head
        ]);
    }

    /**
     * REGISTER
     */
    public function register(): void
    {
        $head = $this->seo->optimize(
            "Crie sua conta no " . site("name"),
            site("desc"),
            $this->router->route("web.login"),
            image("Login")
        )->render();

        $user = new \stdClass();
        $user->first_name = null;
        $user->last_name = null;
        $user->email = null;

        echo $this->view->render("theme/register", [
            "head" => $head,
            "user" => $user
        ]);
    }

    /**
     * FORGET
     */
    public function forget(): void
    {
        $head = $this->seo->optimize(
            "Recupere sua senha | " . site("name"),
            site("desc"),
            $this->router->route("web.forget"),
            image("Forget"),
            )->render();

        echo $this->view->render("theme/forget", [
            "head" => $head,
        ]);
    }

    /**
     * RESET
     * @param array $data
     */
    public function reset(array $data): void
    {
        if (empty(session(SESSION_FORGET))) {
            session(SESSION_FORGET, null, true);
            flash(MESSAGE_TYPE_INFO, "Informe seu E-MAIL para recuperar sua senha");
            $this->router->redirect("web.forget");
            return;
        }

        $email = filter_var($data["email"], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data["forget"], FILTER_DEFAULT);
        if (!$email || !$forget) {
            flash(MESSAGE_TYPE_ERROR, "Desculpe, não foi possível recuperar sua senha. Tente novamente");
            $this->router->redirect("web.forget");
        }

        $user = (new User())->find("email = :e AND forget = :f", "e={$email}&f={$forget}")->fetch();
        if (!$user) {
            flash(MESSAGE_TYPE_ERROR, "Desculpe, não foi possível recuperar sua senha. Tente novamente");
            $this->router->redirect("web.forget");
        }

        $head = $this->seo->optimize(
            "Crie sua nova senha | " . site("name"),
            site("desc"),
            $this->router->route("web.reset"),
            image("Reset"),
            )->render();

        echo $this->view->render("theme/reset", [
            "head" => $head
        ]);
    }

    /**
     * ERROR
     * @param array $data
     */
    public function error(array $data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        $head = $this->seo->optimize(
            "Ooops {$error} | " . site("name"),
            site("desc"),
            $this->router->route("web.error", ["errcode" => $error]),
            image($error)
        )->render();

        echo $this->view->render("theme/error", [
            "head" => $head,
            "error" => $error
        ]);
    }


}