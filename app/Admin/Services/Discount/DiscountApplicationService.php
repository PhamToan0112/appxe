<?php

namespace App\Admin\Services\Discount;

use App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class DiscountApplicationService implements DiscountApplicationServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DiscountApplicationRepositoryInterface $repository;
    protected DiscountRepositoryInterface $discountRepository;

    public function __construct(
        DiscountApplicationRepositoryInterface $repository,
        DiscountRepositoryInterface $discountRepository
    ){
        $this->repository = $repository;
        $this->discountRepository = $discountRepository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object
    {

        $this->data = $request->validated();

        return $this->repository->create($this->data);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): object
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);
    }

    /**
     * @throws Exception
     */
    public function delete($id): object
    {
        return $this->repository->delete($id);
    }




}
