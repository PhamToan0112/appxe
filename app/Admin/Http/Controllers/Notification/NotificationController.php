<?php

namespace App\Admin\Http\Controllers\Notification;

use App\Admin\DataTables\Notification\NotificationDataTable;
use App\Admin\DataTables\Notification\NotificationDepositDataTable;
use App\Admin\DataTables\Notification\NotificationPaymentDataTable;
use App\Admin\DataTables\Notification\NotificationWithdrawDataTable;
use App\Admin\DataTables\Notification\NotificationReportDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Notification\NotificationRequest;
use App\Admin\Repositories\Bank\BankRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\Notification\NotificationServiceInterface;
use App\Admin\Traits\Roles;
use App\Enums\Notification\MessageType;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\VerifiedStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    use Roles;

    protected DriverRepositoryInterface $driverRepository;

    protected UserRepositoryInterface $userRepository;

    protected BankRepositoryInterface $bankRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        DriverRepositoryInterface       $driverRepository,
        UserRepositoryInterface         $userRepository,
        BankRepositoryInterface         $bankRepository,
        NotificationServiceInterface    $service
    )
    {

        parent::__construct();

        $this->repository = $repository;
        $this->driverRepository = $driverRepository;
        $this->userRepository = $userRepository;
        $this->bankRepository = $bankRepository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'index' => 'admin.notifications.index',
            'deposit' => 'admin.notifications.deposit',
            'withdraw' => 'admin.notifications.withdraw',
            'payment' => 'admin.notifications.payment',
            'report' => 'admin.notifications.report',
            'create' => 'admin.notifications.create',
            'edit' => 'admin.notifications.edit'
        ];
    }

    public function getRoute(): array
    {

        return [
            'index' => 'admin.notification.index',
            'create' => 'admin.notification.create',
            'edit' => 'admin.notification.edit',
            'deposit' => 'admin.notification.deposit',
            'withdraw' => 'admin.notification.withdraw',
            'payment' => 'admin.notification.payment',
            'report' => 'admin.notification.report',
            'delete' => 'admin.page.delete'
        ];
    }

    public function index(NotificationDataTable $dataTable)
    {   
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('notifications')),
            'actionMultiple' => $actionMultiple,
        ]);
    }

    public function withdraw(NotificationWithdrawDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render($this->view['withdraw'], [
            'breadcrumbs' => $this->crums->add(__('withdraw')),
            'actionMultiple' => $actionMultiple,
        ]);
    }

    public function deposit(NotificationDepositDataTable $dataTable)
    {   
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render($this->view['deposit'], [
            'breadcrumbs' => $this->crums->add(__('deposit')),
            'actionMultiple' => $actionMultiple,
        ]);
    }

    public function payment(NotificationPaymentDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render($this->view['payment'], [
            'breadcrumbs' => $this->crums->add(__('payment')),
            'actionMultiple' => $actionMultiple,
        ]);
    }

    public function report(NotificationReportDataTable $dataTable)
    {
        $actionMultiple = $this->getActionMultiple();
        return $dataTable->render($this->view['report'], [
            'breadcrumbs' => $this->crums->add(__('report')),
            'actionMultiple' => $actionMultiple,
        ]);
    }


    public function updateDeviceToken(Request $request)
    {
        return $this->service->updateDeviceToken($request);
    }

    public function updateStatus(NotificationRequest $request)

    {
        return $this->service->updateStatus($request);
    }


    /**
     * Get notification for admin
     *
     * @param NotificationRequest $request
     * @return JsonResponse
     */
    public function getNotificationsForAdmin(NotificationRequest $request): JsonResponse
    {
        $notifications = $this->service->getNotifications($request);

        if ($notifications) {
            return response()->json([
                'notifications' => $notifications
            ]);
        }
        return response()->json([
            'notifications' => [],
            'errors' => ['Specific condition is not met']
        ], 422);
    }

    public function create(): View|Application
    {
        return view($this->view['create'], [
            'types' => NotificationType::asSelectArray(),
            'type' => MessageType::asSelectArray(),
            'options' => NotificationOption::asSelectArray(),
            'status' => NotificationStatus::asSelectArray(),
            'breadcrumbs' => $this->crums->add(__('notifications'), route($this->route['index']))->add(__('add'))
        ]);
    }

    public function store(NotificationRequest $request): RedirectResponse
    {
        $response = $this->service->store($request);
        if ($response) {
            return redirect()->route($this->route['index'])->with('success', __('notifySuccess'));
        } else if ($response == false) {
            return redirect()->route($this->route['create'])->with('error', __('Chưa có một ai để gửi thông báo'));
        } else {
            return redirect()->route($this->route['create'])->with('error', __('notifyFail'));
        }
    }

    /**
     * @throws Exception
     */
    public function edit($id): View|Application
    {
        $notification = $this->repository->findOrFail($id);

        if ($notification->type === MessageType::DEPOSIT) {
            $baseBreadcrumbLabel = __('request_deposit');
            $baseBreadcrumbRoute = $this->route['deposit'];
        } else if ($notification->type === MessageType::WITHDRAW) {
            $baseBreadcrumbLabel = __('request_withdraw');
            $baseBreadcrumbRoute = $this->route['withdraw'];
        } else {
            $baseBreadcrumbLabel = __('notification');
            $baseBreadcrumbRoute = $this->route['index'];
        }

        $breadcrumbs = $this->crums->add($baseBreadcrumbLabel, route($baseBreadcrumbRoute));

        $editBreadcrumbLabel = __('edit');
        $breadcrumbs->add($editBreadcrumbLabel);
        $banks = $this->bankRepository->getAll();


        $viewData = [
            'types' => NotificationType::asSelectArray(),
            'message_type' => MessageType::asSelectArray(),
            'options' => NotificationOption::asSelectArray(),
            'status' => NotificationStatus::asSelectArray(),
            'is_verified' => VerifiedStatus::asSelectArray(),
            'notification' => $notification,
            'breadcrumbs' => $breadcrumbs,
            'banks' => $banks,

        ];

        return view($this->view['edit'], $viewData);
    }


    public function update(NotificationRequest $request): RedirectResponse
    {

        $response = $this->service->update($request);

        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }

        return back()->with('error', __('notifyFail'));
    }


    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }

    protected function getActionMultiple(): array
    {   
        return [
            'read' => NotificationStatus::READ->description(),
            'not_read' => NotificationStatus::NOT_READ->description(),
            'deleted' => 'Xóa vĩnh viễn',
        ];
    }

    public function actionMultipleRecode(Request $request): RedirectResponse
    {   
        $boolean = $this->service->actionMultipleRecode($request);
        if ($boolean) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }
}
