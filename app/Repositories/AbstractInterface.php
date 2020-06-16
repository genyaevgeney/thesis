<?php

namespace App\Repositories;

/**
 * Interface AbstractInterface.
 */
interface AbstractInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @param int $limit
     * @return mixed
     */
    public function getAllLimit(int $limit = 10);

    public function getAll();

    public function paginate(int $rowsCount);

    /**
     * @return mixed
     */
    public function getAllNoLimit();

    /**
     * @param int $id
     * @param array $attributes
     * @param bool $getDataBack
     * @return mixed
     */
    public function update(int $id, array $attributes, bool $getDataBack = false);

    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $id);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $fillAttributes
     * @param array $searchAttributes
     * @return mixed
     */
    public function firstOrCreate(
        array $fillAttributes, array $searchAttributes = []
    );
}
