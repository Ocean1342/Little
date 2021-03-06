<?php

namespace Little\Controllers;


use Little\HTTP\Response;

/**
 *
 */
class HomeController extends BaseController
{
    /**
     * @return Response|null
     */
    public function __invoke(): ?Response
    {
        $content = $this->view->render('home.php');

        return new Response($content);
    }
}
