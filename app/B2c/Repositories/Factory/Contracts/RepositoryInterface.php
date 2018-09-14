<?php

namespace App\B2c\Repositories\Factory\Contracts;

/**
 * RepositoryInterface provides the standard functions declaration to be expected by All repository.
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
interface RepositoryInterface
{
    /**
     * Get all records method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $columns
     */
    public function all($columns = array('*'));

    /**
     * Find method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param int $id
     * @param array $columns
     */
    public function find(int $id, $columns = array('*'));

    /**
     * Delete method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param integer $id
     */
    public function delete(int $id);

    /**
    * Create method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $attributes
    */
    public function create(array $attributes);

    /**
     * Update method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     * @param int $id
     */
    public function update(array $attributes, int $id);
}
