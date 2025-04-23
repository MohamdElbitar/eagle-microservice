<?php

namespace App\Interfaces\Admin;


interface SoftDeleteInterface
{
    /**
     * Summary of reset
     * @param int $id
     * @return void
     */
    public function restore(int $id);

    /**
     * Summary of forceDelete
     * @param int $id
     * @return void
     */
    public function forceDelete(int $id);
}
