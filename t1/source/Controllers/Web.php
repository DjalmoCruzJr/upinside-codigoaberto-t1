<?php


namespace Source\Controllers;


class Web extends Controller
{

    public function __construct($router)
    {
        parent::__construct($router);

        if (!empty(session("user"))) {
            $this->router->redirect("app.home");
        }
    }

    public function login(): void
    {
        $head = $this->seo->optimize("Crie sua conta no | " . site("name"),
            site("desc"),
            $this->router->route("web.login"),
            image("login")
        )->render();

        echo $this->view->render("theme/login", [
            "head" => $head
        ]);
    }

    public function error(array $data): void
    {
        echo "<h1>OOPS! | {$data["errcode"]}</h1>";
    }
}