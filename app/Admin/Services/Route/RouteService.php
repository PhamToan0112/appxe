<?php

namespace App\Admin\Services\Route;

use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Route\RouteRepositoryInterface;
use App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface;
use App\Api\V1\Exception\BadRequestException;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteService implements RouteServiceInterface
{
    use UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected RouteRepositoryInterface $repository;
    protected RouteVariantRepositoryInterface $variantRepository;

    protected DriverRepositoryInterface $driverRepository;


    public function __construct(RouteRepositoryInterface        $repository,
                                DriverRepositoryInterface       $driverRepository,
                                RouteVariantRepositoryInterface $variantRepository)
    {
        $this->repository = $repository;
        $this->variantRepository = $variantRepository;
        $this->driverRepository = $driverRepository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object
    {

        $data = $request->validated();
        DB::beginTransaction();
        try {
            $driverId = $data['driver_id'];
            $driver = $this->driverRepository->findOrFail($driverId);
            $startTime = $driver->service_intercity_start_time ?? null;
            $endTime = $driver->service_intercity_end_time ?? null;
            if (!$startTime || !$endTime) {
                throw new Exception("Tài xế chưa đăng ký khung giờ phục vụ");
            }
            $route = $this->repository->create($data);
            $this->variantRepository->createRouteVariants($startTime, $endTime, $route, $driver);
            DB::commit();
            return $route;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Create route failed", $e);
            throw $e;
        }

    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {
        $data = $request->validated();
        $routeId = $data['id'];

        DB::beginTransaction();

        try {
            $route = $this->repository->findOrFail($routeId);
            $driver = $route->driver;
            $startTime = $driver->service_intercity_start_time ?? null;
            $endTime = $driver->service_intercity_end_time ?? null;

            $route->routeVariants()->delete();
            $result = $this->repository->update($routeId, $data);
            $this->variantRepository->createRouteVariants($startTime, $endTime, $result, $driver);

            DB::commit();

            return $result;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError("Update route failed", $e);
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

    public function actionMultipleRecord(Request $request)
    {
        $this->data = $request->all();

        $action = $this->data['action'];
        $ids = $this->data['id'];

        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $this->delete($id);
                }
                return true;
            default:
                return false;
        }
    }
}