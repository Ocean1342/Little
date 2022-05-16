<?php

namespace Little\Controllers;

use InvalidArgumentException;
use Little\Repositories\Exceptions\PDOLinkRepositoryException;
use Little\HTTP\Response;

/**
 *
 */
class StoreController extends BaseController
{
    /**
     * @param string $shortLink
     * @return string
     */
    protected function prepareShortLinkToUser(string $shortLink, string $serverName = 'localhost', string $scheme = 'http'): string
    {
        return $scheme . '://' . $serverName . '/' . $shortLink;
    }

    /**
     * @return Response
     */
    public function __invoke(): ?Response
    {

        $status = 200;
        try {
            $shortLink = $this->service->createShortLink($this->request->getPost()['base_link']);
            $message = 'Success! Short Link: ' .
                $this->prepareShortLinkToUser(
                    $shortLink,
                    $this->request->getServerName(),
                    $this->request->getScheme()
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