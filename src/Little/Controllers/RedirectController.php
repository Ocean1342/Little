<?php

namespace Little\Controllers;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class RedirectController extends BaseController
{

    /**
     * @param string $shortLink
     * @return RedirectResponse|Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(string $shortLink)
    {
        $baseLink = $this->service->getBaseLink(htmlspecialchars($shortLink));
        if (! $baseLink){
            $content = $this->twig->render('home.twig', [
                'message' => 'Your short link not found. Create it!',
            ]);
            return new Response($content,404);
        }
        return new RedirectResponse($baseLink);
    }

}