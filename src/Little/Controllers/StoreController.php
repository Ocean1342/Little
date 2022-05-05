<?php

namespace Little\Controllers;


use Little\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class StoreController extends BaseController
{
    /**
     * @param Request $request
     * @param string $shortLink
     * @return string
     */
    protected function prepareShortLinkToUser(Request $request, string $shortLink): string
    {
        return $request->server->get('REQUEST_SCHEME') .
            '://' .
            $request->server->get('SERVER_NAME') .
            '/' .
            $shortLink;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request): Response
    {

        $shortLink = $this->service->createShortLink($request);
        if (!$shortLink) {
            $message = $this->service->errorMessageToUser;
        } else {
            $message = 'Success! Short Link: ' .
                $this->prepareShortLinkToUser($request, $shortLink);
        }
        $content = $this->twig->render('home.twig', [
            'message' => $message,
        ]);


        return new Response($content, 200);

    }
}