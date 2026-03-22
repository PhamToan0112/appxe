<?php

namespace App\Admin\Services\VehicleLines;

use App\Admin\Repositories\VehicleLines\VehicleLinesRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Support\UseLog;
use App\Enums\DefaultStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehicleLinesService implements VehicleLinesServiceInterface
{
    use UseLog, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected VehicleLinesRepositoryInterface $repository;

    public function __construct(
        VehicleLinesRepositoryInterface      $repository
    )
    {

        $this->repository = $repository;
    }

    public function store(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $vehicle = $this->repository->create($data);
            DB::commit();
            return $vehicle;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create vehicle by driver', $e);
            return false;
        }
    }


    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            DB::commit();
            return $this->repository->update($data['id'], $data);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update vehicle', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {

        return $this->repository->delete($id);
    }

    public function actionMultipleRecode(Request $request): bool
    {
        $this->data = $request->all();
        switch ($this->data['action']) {
            case 'published':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', DefaultStatus::Published);
                }
                return true;
            case 'draft':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', DefaultStatus::Draft);
                }
                return true;
            case 'deleted':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', DefaultStatus::Deleted);
                }
                return true;
            default:
                return false;
        }
    }

}
