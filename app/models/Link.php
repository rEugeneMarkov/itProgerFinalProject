<?php

namespace App\Models;

class Link
{
    private $link;
    private $shortLink;
    private $userId;
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstence();
    }

    public function setData($link, $shortLink, $userId)
    {
        $this->link = $link;
        $this->shortLink = $shortLink;
        $this->userId = $userId;
    }

    public function validForm()
    {
        if (strlen($this->link) < 7) {
            return "Ссылка слишком короткая";
        } elseif (strlen($this->shortLink) < 3) {
            return "Короткое название минимум 3 символа";
        } elseif ($this->checkShortLink($this->shortLink)) {
            return "Такое сокращение уже используется в базе";
        } else {
            return "Верно";
        }
    }

    public function checkShortLink($shortLink)
    {
        $sql = "SELECT COUNT(*) FROM links WHERE short_link = :shortLink";
        $query = $this->db->prepare($sql);
        $query->execute(['shortLink' => $shortLink]);

        $count = $query->fetchColumn();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addLink()
    {
        $sql = 'INSERT INTO links(link, short_link, user_id) VALUES(:link, :shortLink, :userId)';
        $query = $this->db->prepare($sql);

        $query->execute(['link' => $this->link, 'shortLink' => $this->shortLink, 'userId' => $this->userId]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM links WHERE id = :id';
        $query = $this->db->prepare($sql);

        $query->execute(['id' => $id]);
    }

    public function getLink($shortLink)
    {
        $result = $this->db->query("SELECT * FROM `links` WHERE `short_link` = '$shortLink'");
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    public function getUserLinks($userId)
    {
        $result = $this->db->query("SELECT * FROM `links` WHERE `user_id` = '$userId' ORDER BY `id` DESC");
        return $result->fetchAll(\PDO::FETCH_OBJ);
    }
}
