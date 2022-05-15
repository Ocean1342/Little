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
    public function __invoke():? Response
    {
        $content = render_template('home.php');

        return new Response($content);
    }
}
