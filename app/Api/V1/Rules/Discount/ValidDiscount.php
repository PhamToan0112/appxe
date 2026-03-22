<?php

namespace App\Api\V1\Rules\Discount;

use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Traits\CalculationsTrait;
use Illuminate\Contracts\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ValidDiscount implements Rule
{
    use CalculationsTrait;

    protected string $message;

    protected ?string $discountId;


    public function __construct(?string $discountId)
    {
        $this->message = __("invalid_discount");
        $this->discountId = $discountId;

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function passes($attribute, $value): bool
    {
        if (empty($this->discountId)) {
            return true;
        }
        $discountRepository = app(DiscountRepositoryInterface::class);

        $discount = $discountRepository->findByField('id', $this->discountId);

        if (!$discount) {
            $this->message = __("discount_not_exist");
            return false;
        }

        if (!$discount->isActive()) {
            return false;
        }


        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
