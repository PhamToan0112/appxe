<?php

namespace App\Admin\Services\Vehicle;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Services\Vehicle\VehicleServiceInterface;
use App\Admin\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Admin\Traits\Roles;
use App\Api\V1\Support\UseLog;
use App\Enums\Vehicle\VehicleStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehicleService implements VehicleServiceInterface
{
    use UseLog, Roles;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected VehicleRepositoryInterface $repository;


    protected DriverRepositoryInterface $driverRepository;

    public function __construct(
        VehicleRepositoryInterface $repository,
        DriverRepositoryInterface $driverRepository,
    ) {

        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
    }


    /**
     * @throws Exception
     */
    public function store(Request $request): object|bool
    {
        $data = $request->validated();
        if (isset($data['service_type'])) {
            $data['service_type'] = json_encode($data['service_type']);
        }
        return $this->repository->create($data);
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
            case 'active':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', VehicleStatus::Active);
                }
                return true;
            case 'inactive':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', VehicleStatus::Inactive);
                }
                return true;
            case 'deleted':
                foreach ($this->data['id'] as $value) {
                    $this->repository->updateAttribute($value, 'status', VehicleStatus::Deleted);
                }
                return true;
            default:
                return false;
        }
    }
}