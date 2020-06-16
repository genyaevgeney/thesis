<?php

namespace App\Services;

interface AbstractInterface
{
    /**
     * Describe class create method
     *
     * @param  array $data
     */
    public function create(array $data);

    /**
     * Describe class paginate method
     */
    public function paginate();

    /**
     * Describe class update method
     *
     * @param  array  $data [description]
     * @param  int    $id   [description]
     */
    public function update(array $data, int $id);

    /**
     * Describe class delete method
     *
     * @param  int $id
     */
    public function delete(int $id);

    /**
     * Describe class getById method
     *
     * @param  int $id
     */
    public function getById(int $id);
}