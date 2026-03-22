<?php

namespace App\Admin\Services\CategorySystem;

use App\Admin\Services\CategorySystem\CategorySystemServiceInterface;
use App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Enums\ActiveStatus;
use Illuminate\Http\Request;


class CategorySystemService implements CategorySystemServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(CategorySystemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {

        $this->data = $request->validated();
        return $this->repository->create($this->data);
    }

    public function update(Request $request)
    {

        $this->data = $request->validated();
        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id)
    {
        $categorySystem = $this->repository->findOrFail($id);
        if ($categorySystem) {
            $categorySystem->status = ActiveStatus::Deleted;
            $categorySystem->save();
        }

        return $categorySystem;
    }

}