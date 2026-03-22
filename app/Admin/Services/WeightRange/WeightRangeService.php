<?php

namespace App\Admin\Services\WeightRange;

use App\Admin\Repositories\WeightRange\WeightRangeRepository;
use App\Enums\DefaultStatus;
use Exception;
use Illuminate\Http\Request;

class WeightRangeService implements WeightRangeServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected WeightRangeRepository $repository;

    public function __construct(WeightRangeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->repository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {

        $data = $request->validated();

        return $this->repository->update($data['id'], $data);
    }

    public function delete($id): object|bool
    {
        $this->repository->updateAttribute($id, 'status', DefaultStatus::Deleted);
        return true;
    }
}
