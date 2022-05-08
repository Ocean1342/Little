<?php

namespace Little\Services;


use Little\Repositories\LinkRepositoryInterface;

use PDOException;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class LinkService implements LinkServiceInterface
{
    /**
     * @var string
     */
    public string $errorMessageToUser;

    /**
     * @var string error message when PDO throws PDOException
     */
    protected const DATABASE_ERROR_MESSAGE = 'Problem with service. Please try latter.';

    /**
     * @param LinkRepositoryInterface $repository
     */
    public function __construct(public LinkRepositoryInterface $repository)
    {
    }

    /**
     *
     * @param $shortLink
     * @return string|null
     * @throws PDOException
     */
    public function getBaseLink($shortLink): ?string
    {
        try {
            $res = $this->repository->getBaseLink($shortLink);
        } catch (PDOException $exception) {
            //логировать
            //echo $exception->getMessage();
            $this->errorMessageToUser = static::DATABASE_ERROR_MESSAGE;
            return null;
        }

        if (!$res)
            $this->errorMessageToUser = 'Your short link not found. Create it!';
        return $res;
    }


    /**
     * @return string
     */
    protected function generateShortLink(): string
    {
        return mb_substr(md5(uniqid(rand(), true)), 10, 6);
    }

    /**
     * @param $baseLink
     * @return bool
     */
    protected function validateLink($baseLink): bool
    {
        return filter_var($baseLink, FILTER_VALIDATE_URL);
    }

    /**
     * @param Request $request
     * @return string|null
     * @throws PDOException
     */
    public function createShortLink(Request $request): ?string
    {
        $baseLink = htmlspecialchars($request->request->get('base_link'));

        //validate link
        if (!$this->validateLink($baseLink)) {
            $this->errorMessageToUser = 'Not valid link. Try one more time';
            return null;
        }

        //create short link
        $arData = [];
        $shortLink = $this->generateShortLink();
        $arData['shortLink'] = $shortLink;
        $arData['baseLink'] = $baseLink;

        try {
            //save short link
            $this->repository->saveShortLink($arData);
        } catch (PDOException $exception) {
            //логировать
            //echo $exception->getMessage();
            $this->errorMessageToUser = static::DATABASE_ERROR_MESSAGE;
            return null;
        }
        return $shortLink;
    }
}