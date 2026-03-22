<?php
namespace App\Admin\Services\ReportOrder;

use App\Admin\Services\ReportOrder\ReportOrderServiceInterface;
use  App\Admin\Repositories\ReportOrder\ReportOrderRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ReportOrderService implements ReportOrderServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ReportOrderRepositoryInterface $repository;

    public function __construct(ReportOrderRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }

}
