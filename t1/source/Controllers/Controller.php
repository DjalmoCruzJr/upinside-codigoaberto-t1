<?php


namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;

/**
 * Class Controller
 * @package Source\Controllers
 */
abstract class Controller
{
    /** @var Engine */
    protected $view;

    /** @var Router */
    protected $router;

    /** @var Optimizer */
    protected $seo;

    /**
     * Controller constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;

        /** @TODO ta dando pau aqui... */
        $this->view = Engine::create(dirname(__DIR__, 2) . PATH_VIEWS, "php");
        $this->view->addData(["router" => $router]);

        $this->seo = new Optimizer();
        $this->seo
            ->openGraph(
                site("name"),
                site("locale"),
                "article"
            )
            ->publisher(
                social("facebook_page"),
                social("facebook_author")
            )
            ->twitterCard(
                social("twitter_creator"),
                social("twitter_site"),
                site("domain")
            )
            ->facebook(social("facebook_app_id"));
    }

    /**
     * @param string $param
     * @param array $values
     * @return string
     */
    protected function ajaxResponse(string $param, array $values): string
    {
        return json_encode([$param => $values]);
    }
}