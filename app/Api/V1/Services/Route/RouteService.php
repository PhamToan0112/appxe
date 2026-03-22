<?php

namespace App\Api\V1\Services\Route;

use App\Admin\Repositories\RouteVariant\RouteVariantRepositoryInterface;
use App\Api\V1\Exception\BadRequestException;
use App\Api\V1\Repositories\Route\RouteRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\UseLog;
use Exception;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;

class RouteService implements RouteServiceInterface
{
    use AuthSupport, AuthServiceApi, UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected RouteRepositoryInterface $repository;

    protected RouteVariantRepositoryInterface $routeVariantRepository;


    public function __construct(
        RouteRepositoryInterface $repository,
        RouteVariantRepositoryInterface $routeVariantRepository
    ) {
        $this->repository = $repository;
        $this->routeVariantRepository = $routeVariantRepository;
    }

    /**
     * @throws Exception
     */
    public function create(Request $request): object
    {
        $data = $request->validated();
        $driver = $this->getCurrentDriver();
        $data['driver_id'] = $driver->id;
        $startTime = $driver->service_intercity_start_time ?? null;
        $endTime = $driver->service_intercity_end_time ?? null;
        if (!$startTime || !$endTime) {
            throw new BadRequestException("Driver has not registered service times.");
        }

        $route = $this->repository->create($data);
        $this->routeVariantRepository->createRouteVariants($startTime, $endTime, $route, $driver);

        return $route;
    }


    public function search(Request $request)
    {
        $data = $request->validated();

        $startAddress = $data['start_address'];
        $endAddress = $data['end_address'];

        return $this->routeVariantRepository->getByQueryBuilder([
            'trip_type' => $data['type'],
        ])
            ->where(function ($query) use ($startAddress) {
                $keywords = explode(' ', $startAddress);
                foreach ($keywords as $keyword) {
                    $query->orWhereRaw("LOWER(start_address) LIKE ?", ['%' . strtolower($keyword) . '%']);
                }
            })
            ->where(function ($query) use ($endAddress) {
                $keywords = explode(' ', $endAddress);
                foreach ($keywords as $keyword) {
                    $query->orWhereRaw("LOWER(end_address) LIKE ?", ['%' . strtolower($keyword) . '%']);
                }
            })
            ->get();
    }
}