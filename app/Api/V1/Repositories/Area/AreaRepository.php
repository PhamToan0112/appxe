<?php

namespace App\Api\V1\Repositories\Area;
use \App\Admin\Repositories\Area\AreaRepository as AdminArea;
use App\Api\V1\Repositories\Category\CategoryRepositoryInterface;

class AreaRepository extends AdminArea implements AreaRepositoryInterface
{

    public function findByPublished($id)
    {
        $this->instance = $this->model->where('id', $id)
            ->published()
            ->firstOrFail();

        return $this->instance;
    }
    public function getTree(){
        $this->instance = $this->model->published()
            ->orderBy('position', 'ASC')
            ->get()
            ->toTree();

        return $this->instance;
    }

    public function getStoresId($area_id)
    {
        $this->instance = $this->findByPublished($area_id);
        $storesId = $this->instance->stores->pluck('id')->all();

        return $storesId;

    }
}
