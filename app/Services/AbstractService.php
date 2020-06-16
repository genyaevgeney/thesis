<?php

namespace App\Services;

class AbstractService implements AbstractInterface
{
    /**
     * Repository class object
     *
     * @var object
     */
    protected $repository;
    /**
     * Count of rows on pagination page
     *
     * @var int
     */
    protected $paginationRowsCount = 5;

    public function __construct()
    {
    }

    /**
     * Call repository create method
     * @param  array $data
     * @return void
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    /**
     * Call repository paginate method
     *
     * @return object
     */
    public function paginate()
    {
        return $this->repository->paginate($this->paginationRowsCount);
    }

    /**
     * Call repository delete method
     *
     * @param  int $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    /**
     * Call repository getById method
     *
     * @param  int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Call repository update method
     *
     * @param  array $data
     * @param  int $id
     * @return void
     */
    public function update(array $data, int $id)
    {
        $this->repository->update($data, $id);
    }
}