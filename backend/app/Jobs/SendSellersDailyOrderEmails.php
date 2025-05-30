<?php

namespace App\Jobs;

use App\Mail\SellerDailyOrderReportMail;
use App\Models\Seller;
use App\Repositories\Seller\Repository as SellerRepository;
use App\Services\Reports\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendSellersDailyOrderEmails implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $date, private ?int $seller_id = null) {
        //
    }

    public function handle(
        Service $reportService,
        SellerRepository $sellerRepository
    ): void
    {
        if (!empty($this->seller_id)) {
            $seller = $sellerRepository->find($this->seller_id);

            if (!empty($seller))
                $this->sendSellerReport($seller, $reportService);

            return;
        }

        $sellers = $sellerRepository->all();

        if ($sellers->isNotEmpty())
            $this->sendSellersReports($sellers, $reportService);
    }

    private function sendSellersReports(Collection $sellers, Service $reportService)
    {
        foreach ($sellers as $seller) {
            $this->sendSellerReport($seller, $reportService);
        }
    }

    private function sendSellerReport(Seller $seller, Service $reportService): void
    {
        $report = $reportService->getDailyOrdersReport($this->date, $seller->id);

        if ($report->quantity == 0) return;

        Mail::to($seller->email, $seller->name)
            ->send(new SellerDailyOrderReportMail($report, $seller->name));
    }
}
