<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\AlbumTable;

class AlbumController extends AbstractActionController
{
    private $title;
    private $albumTable;

    public function __construct(string $title, AlbumTable $albumTable)
    {
        $this->title = $title;
        $this->albumTable = $albumTable;
    }

    public function indexAction()
    {
        $albums = $this->albumTable->fetchAll();
        return new ViewModel([
            'title' => $this->title,
            'albums' => $albums
        ]);
    }

    public function addAction()
    {
        die('Add action called');
        // Logic for adding an album
        return new ViewModel();
    }

    public function editAction()
    {
        die('Edit action called');
        // Logic for editing an album
        return new ViewModel();
    }

    public function deleteAction()
    {
        die('Delete action called');
        // Logic for deleting an album
        return new ViewModel();
    }
}
