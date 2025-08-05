<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

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

    public function getArtist($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf('Artist with ID %d not found', $id));
        }
        return $row;
    }

    public function saveArtist(Artist $artist)
    {
        $data = $artist->getArrayCopy();

        if (empty($artist->id)) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getArtist($artist->id)) {
            throw new RuntimeException(sprintf('Cannot update artist with ID %d; does not exist', $artist->id));
        }

        $this->tableGateway->update($data, ['id' => $artist->id]);
    }

    public function deleteArtist($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
