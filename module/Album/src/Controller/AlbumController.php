<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\AlbumTable;
use Album\Form\AlbumForm;
use Album\Model\Album;

class AlbumController extends AbstractActionController
{
    private $title;
    private $albumTable;
    private $albumForm;

    public function __construct(
        string $title, 
        AlbumTable $albumTable,
        AlbumForm $albumForm
    )
    {
        $this->title = $title;
        $this->albumTable = $albumTable;
        $this->albumForm = $albumForm;
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
        $form = $this->albumForm;
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $album = new Album();
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                $album->exchangeArray($form->getData());  
                $this->albumTable->saveAlbum($album);
                return $this->redirect()->toRoute('album');
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $albumId = (int) $this->params()->fromRoute('id', 0);
        $album = $this->albumTable->getAlbum($albumId);
        $form = $this->albumForm;
        $form->setData([
            'title' => $album->title,
            'artist' => $album->artist,
        ]);

        if ($request->isPost()) {

            if ($form->isValid()) {
                $albumId = (int) $this->params()->fromRoute('id', 0);
                $album = $this->albumTable->getAlbum($albumId);
                $form->setData($request->getPost());

                if ($form->isValid()) {
                    $data = $form->getData();
                    $album->exchangeArray($form->getData());  
                    $album->id = $albumId;
                    $this->albumTable->saveAlbum($album);
                    return $this->redirect()->toRoute('album');
                }
            }
        }
        
        return new ViewModel([
            'album' => $album,
            'form' => $this->albumForm
        ]);
    }

    public function deleteAction()
    {
        $albumId = (int) $this->params()->fromRoute('id', 0);
        $album = $this->albumTable->getAlbum($albumId);
        $this->albumTable->deleteAlbum($albumId);
        
        return $this->redirect()->toRoute('album');
    }
}
