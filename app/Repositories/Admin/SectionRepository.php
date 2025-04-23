<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SectionRepositoryInterface;
use App\Models\Section;

class SectionRepository implements SectionRepositoryInterface
{
    public function getAll()
    {
        return Section::all();
    }

    public function getById($id)
    {
        return Section::findOrFail($id);
    }

    public function create(array $data)
    {
        return Section::create($data);
    }

    public function update($id, array $data)
    {
        $section = Section::findOrFail($id);
        $section->update($data);
        return $section;
    }

    public function delete($id)
    {
        $section = Section::findOrFail($id);
        return $section->delete();
    }

    public function getSectionsByPlan($planId)
    {
        return Section::where('plan_id', $planId)->get();
    }
}
