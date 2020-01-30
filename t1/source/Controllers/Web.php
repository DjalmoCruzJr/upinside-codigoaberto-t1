<?php


namespace Source\Controllers;


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

        //        if (!empty(session("user"))) {
        //            $this->router->redirect("app.home");
        //        }
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