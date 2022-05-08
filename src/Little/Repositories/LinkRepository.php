<?php

namespace Little\Repositories;

use PDO;

/**
 *
 */
class LinkRepository implements LinkRepositoryInterface
{
    /**
     * @param PDO $pdo
     */
    public function __construct(public PDO $pdo)
    {
    }

    /**
     * @param $shortLink
     * @return string|null
     */
    public function getBaseLink($shortLink): ?string
    {
        $stmt = $this->pdo->prepare(
            "SELECT base_link FROM links where short_link=:short_link"
        );
        $stmt->bindValue(':short_link',$shortLink);
        $bool = $stmt->execute();
        if(! $res = $stmt->fetch())
            return null;
        return $res[0];
    }

    /**
     * @param array $arData
     * @return bool
     */
    public function saveShortLink(array $arData): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO links (base_link,short_link)
        VALUES (:base_link, :short_link)');
        $stmt->bindValue(':base_link',$arData['baseLink']);
        $stmt->bindValue(':short_link',$arData['shortLink']);
        $res = $stmt->execute();
        return $res;
    }

}