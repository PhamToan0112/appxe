<?php

namespace App\Api\V1\Services\Vehicle;

use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Admin\Services\File\FileService;
use App\Constants\ImageFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;
use App\Traits\UseLog;
use Exception;
use App\Enums\Vehicle\VehicleType;

class VehicleService implements VehicleServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    private string $folderVehicle = "images/vehicles";

    protected VehicleRepositoryInterface $repository;
    protected FileService $fileService;

    public function __construct(
        VehicleRepositoryInterface $repository,
        FileService                $fileService
    )
    {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    public function store(Request $request): bool|object
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['driver_id'] = $this->getCurrentDriverId();
            
            $data = $this->fileService->uploadImages($this->folderVehicle, $data, ImageFields::getVehicleFields());
            
            $vehicle = $this->repository->create($data);
            DB::commit();
            return $vehicle;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to create vehicle', $e);
            return false;
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $vehicleId = $data['vehicle_id'];

            $data = $this->fileService->uploadImages($this->folderVehicle, $data, ImageFields::getVehicleFields());

            $vehicle = $this->repository->update($vehicleId, $data);
            DB::commit();
            return $vehicle;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to update vehicle', $e);
            return false;
        }
    }

    public function delete($id)
    {
        return $this->repository->update($id, ['is_deleted' => 1]);
    }
}
