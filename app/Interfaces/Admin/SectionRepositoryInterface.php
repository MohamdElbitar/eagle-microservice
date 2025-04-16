<?php

namespace App\Interfaces\Admin;




interface SectionRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getSectionsByPlan($planId);
}
