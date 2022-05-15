<?php

namespace Little\Controllers;

use InvalidArgumentException;
use Little\Repositories\Exceptions\PDOLinkRepositoryException;
use Symfony\Component\HttpFoundation\Request;
use Little\HTTP\Response;

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
     * @return Response
     */
    public function __invoke():? Response
    {

        $status = 200;
        try {
            $shortLink = $this->service->createShortLink($_POST['base_link']);
            $message = 'Success! Short Link: ' .
                $this->prepareShortLinkToUser(
                    $_SERVER['SERVER_NAME'],
                    $shortLink,
                    $_SERVER['REQUEST_SCHEME']
                );
        } catch (InvalidArgumentException $exception) {
            $message = $exception->getMessage();
            $status = 400;
        } catch (PDOLinkRepositoryException $exception) {
            $message = 'An error occurred. Please, try latter';
            $status = 500;
        }
        $content = renderTemplate('home.php', [
            'message' => $message,
        ]);

        return new Response($content, $status);
    }
}