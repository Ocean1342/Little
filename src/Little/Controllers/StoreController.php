<?php

namespace Little\Controllers;

use InvalidArgumentException;
use Little\Repositories\Exceptions\PDOLinkRepositoryException;
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
    protected function prepareShortLinkToUser(string $serverName, string $shortLink, string $scheme = 'http'): string
    {
        return $scheme . '://' . $serverName . '/' . $shortLink;
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
        $status = 200;
        try {
            $shortLink = $this->service->createShortLink($request);
            $message = 'Success! Short Link: ' .
                $this->prepareShortLinkToUser(
                    $request->server->get('SERVER_NAME'),
                    $shortLink,
                    $request->server->get('REQUEST_SCHEME')
                );
        } catch (InvalidArgumentException $exception) {
            $message = $exception->getMessage();
            $status = 400;
        } catch (PDOLinkRepositoryException $exception) {
            $message = 'An error occurred. Please, try latter';
            $status = 500;
        }
        $content = $this->twig->render('home.twig', [
            'message' => $message,
        ]);

        return new Response($content, $status);

    }
}