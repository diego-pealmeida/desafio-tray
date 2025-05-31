<?php

namespace App\Jobs;

use App\Data\DailyOrderReportData;
use App\Mail\UsersDailyOrderReportMail;
use App\Models\User;
use App\Repositories\User\Repository as UserRepository;
use App\Services\Reports\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendUsersDailyOrderEmails implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $date) {
        //
    }

    public function handle(
        Service $reportService,
        UserRepository $userRepository
    ): void
    {
        $report = $reportService->getDailyOrdersReport($this->date);

        if ($report->quantity == 0) return;

        $users = $userRepository->all();

        if ($users->isNotEmpty())
            $this->sendUsersReports($users, $report);
    }

    private function sendUsersReports(Collection $users, DailyOrderReportData $report)
    {
        foreach ($users as $user) {
            $this->sendUserReport($user, $report);
        }
    }

    private function sendUserReport(User $user, DailyOrderReportData $report): void
    {
        Mail::to($user->email, $user->name)
            ->send(new UsersDailyOrderReportMail($report, $user->name));
    }
}
