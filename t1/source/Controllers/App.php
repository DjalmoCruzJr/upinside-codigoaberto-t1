<?php


namespace Source\Controllers;


use Source\Models\User;

class App extends Controller
{
    /** @var User */
    protected $user;

    public function __construct($router)
    {
        parent::__construct($router);

        if (empty(session(SESSION_USER_ID)) || !$this->user = (new User())->findById(session(SESSION_USER_ID))) {
            session(SESSION_USER_ID, null, true);

            flash(FLASH_TYPE_ERROR, "Acesso negado! Por favor, faça login para acessar");
            $this->router->redirect("web.login");
        }
    }

    public function home(): void
    {
        $head = $this->seo->optimize(
            "Bem-vindo(as) {$this->user->first_name} | " . site("name"),
            site("desc"),
            $this->router->route("app.home"),
            image("Conta de {$this->user->first_name}")
        )->render();

        echo $this->view->render("theme/dashboard", [
            "head" => $head,
            "user" => $this->user
        ]);
    }

    public function logoff(): void
    {
        session(SESSION_USER_ID, null, true);
        flash(FLASH_TYPE_INFO, "Você saiu com sucesso! Volte logo {$this->user->first_name}...");
        $this->router->redirect("web.login");
    }

}