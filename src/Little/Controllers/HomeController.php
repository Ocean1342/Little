<?php

namespace Little\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 *
 */
class HomeController extends BaseController
{


    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request)
    {
        $content = $this->twig->render('home.twig');
        return new Response($content, 200);
    }
}
