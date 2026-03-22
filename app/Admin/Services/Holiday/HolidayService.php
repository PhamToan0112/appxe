<?php

namespace App\Admin\Services\Holiday;

use App\Admin\Repositories\Holiday\HolidayRepositoryInterface;
use App\Traits\UseLog;
use Exception;
use App\Enums\DefaultStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HolidayService implements HolidayServiceInterface
{
    use UseLog;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected HolidayRepositoryInterface $repository;

    public function __construct(
        HolidayRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): object|false
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            DB::commit();
            return $this->repository->create($data);

        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Holiday create failed', $e);
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
            return $this->repository->update($data['id'],$data);
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Holiday update failed', $e);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        
        return true;
    }

    public function actionMultipleRecode(Request $request):bool
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
