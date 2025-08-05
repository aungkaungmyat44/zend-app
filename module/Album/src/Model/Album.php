<?php

namespace Album\Model;

class Album
{
    public $id;
    public $artist;
    public $title;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
        $this->title  = !empty($data['title']) ? $data['title'] : null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getArtist()
    {
        return $this->artist;
    }   

    public function getTitle()
    {
        return $this->title;
    }
}