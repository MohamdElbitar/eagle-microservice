<?php

namespace App\Services\Admin;

use App\Interfaces\Admin\SectionRepositoryInterface;

class SectionService
{
    protected $sectionRepository;

    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function getAllSections()
    {
        return $this->sectionRepository->getAll();
    }
    public function getSectionById($id)
    {
        return $this->sectionRepository->getById($id);
    }

    public function getSectionsByPlan($planId)
    {
        return $this->sectionRepository->getSectionsByPlan($planId);
    }

    public function createSection(array $data)
    {
        return $this->sectionRepository->create($data);
    }

    public function updateSection($id, array $data)
    {
        return $this->sectionRepository->update($id, $data);
    }

    public function deleteSection($id)
    {
        return $this->sectionRepository->delete($id);
    }
}
