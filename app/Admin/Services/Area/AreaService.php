<?php

namespace App\Admin\Services\Area;

use App\Admin\Services\Area\AreaServiceInterface;
use  App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Enums\Area\AreaStatus;
use Exception;
use Illuminate\Http\Request;

class AreaService implements AreaServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected AreaRepositoryInterface $repository;

    public function __construct(AreaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object
    {

        $data = $request->validated();
        $bounds = getBoundsByName($data['address']);
        if (!$bounds) {
            throw new Exception('Địa điểm phải là một khu vực hợp lệ.');
        }
        $data['boundaries'] = json_encode($bounds);

        return $this->repository->create($data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {

        $data = $request->validated();
        $bounds = getBoundsByName($data['address']);
        if (!$bounds) {
            throw new Exception('Địa điểm phải là một khu vực hợp lệ.');
        }
        $data['boundaries'] = json_encode($bounds);
        return $this->repository->update($data['id'], $data);
    }

    public function delete($id): object|bool
    {
        $this->repository->updateAttribute($id, 'status', AreaStatus::Off);
        return true;
    }
}
