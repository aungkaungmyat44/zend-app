<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Album\Model\Album;

class AlbumTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getAlbum($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Album with ID %d not found', $id));
        }
        return $row;
    }

    public function saveAlbum(Album $album)
    {
        $data = $album->getArrayCopy();

        if (empty($album->id)) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getAlbum($album->id)) {
            throw new RuntimeException(sprintf('Cannot update album with ID %d; does not exist', $album->id));
        }

        $this->tableGateway->update($data, ['id' => $album->id]);
    }

    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
