<?php

namespace Little\Repositories;

use InvalidArgumentException;
use Little\Repositories\Exceptions\DuplicateShortLinkException;
use Little\Repositories\Exceptions\NotFoundLinkException;
use Little\Repositories\Exceptions\PDOLinkRepositoryException;
use PDO;
use PDOException;

class PDOLinkRepository extends LinkRepositoryAbstract
{

    /**
     *
     */
    public function __construct(
        protected PDO $pdo
    )
    {
    }

    /**
     * @param string $shortLink
     * @return string|null
     * @throws PDOLinkRepositoryException
     * @throws InvalidArgumentException
     */
    public function findBaseLink(string $shortLink): ?string
    {
        $this->validateShortLink($shortLink);

        $stmt = $this->pdo->prepare(
            "SELECT base_link FROM links WHERE short_link=:short_link"
        );
        $stmt->bindValue(':short_link', $shortLink);
        $stmt->execute();

        try {
            $res = $stmt->fetch();
        } catch (PDOException $exception) {
            throw new NotFoundLinkException($exception->getMessage(), $exception->getCode());
        }
        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    /**
     * @param string $shortLink
     * @param string $baseLink
     * @return bool
     * @throws DuplicateShortLinkException
     * @throws PDOLinkRepositoryException
     * @throws InvalidArgumentException
     */
    public function saveShortLink(string $shortLink, string $baseLink): bool
    {
        $this->validateShortLink($shortLink);

        $this->validateBaseLink($baseLink);

        $stmt = $this->pdo->prepare("INSERT INTO links (base_link,short_link)
        VALUES (:base_link, :short_link)");
        $stmt->bindValue(':base_link', $baseLink);
        $stmt->bindValue(':short_link', $shortLink);
        try {
            $res = $stmt->execute();
        } catch (PDOException $exception) {

            if ($exception->getCode() == '23000') {
                throw new DuplicateShortLinkException($exception->getMessage());
            } else {
                throw new PDOLinkRepositoryException($exception->getMessage());
            }

        }


        return $res;
    }

    /**
     * @param string $shortLink
     * @return void
     */
    protected function validateShortLink(string $shortLink): void
    {
        if (!preg_match('/[a-zA-Z]/i', $shortLink)) {
            throw new InvalidArgumentException(
                sprintf('Short link "%s" is not string.', $shortLink)
            );
        }
    }

    /**
     * @param string $baseLink
     * @return void
     */
    public function validateBaseLink(string $baseLink): void
    {
        if (!filter_var($baseLink, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(
                sprintf('Base link "%s" is not valid link.', $baseLink)
            );
        }
    }

}