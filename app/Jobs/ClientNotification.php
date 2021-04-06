<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\Notification\NotificationServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class ClientNotification
 *
 * @package App\Jobs
 */
class ClientNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 2;

    /**
     * @var array
     */
    private $params;

    /**
     * Create a new job instance.
     *
     * @param  array  $params
     */
    public function __construct(array $params)
    {
        $this->queue = 'notification';
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @param  NotificationServiceInterface  $notificationService
     * @return void
     */
    public function handle(NotificationServiceInterface $notificationService): void
    {
        try {
            $notificationService->isNotified();
        } catch (Throwable $exception) {
            Log::error($exception->getMessage(), $exception->getTrace());
        }
    }
}
