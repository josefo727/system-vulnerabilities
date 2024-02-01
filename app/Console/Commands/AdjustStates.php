<?php

namespace App\Console\Commands;

use App\Actions\AdjustStatusAction;
use App\Models\AssociatedVulnerability;
use App\Models\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AdjustStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adjust:states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adjust the status of the associated vulnerabilities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $staticStatusCode = collect(Status::STATICS)
                ->map(fn($status) => $status["code"])
                ->toArray();

            $associatedVulnerabilities = AssociatedVulnerability::query()
                ->where('id', 135)
                ->whereDoesntHave("status", function ($status) use ($staticStatusCode) {
                    $status->whereIn("code", $staticStatusCode);
                })
                ->get();

            foreach ($associatedVulnerabilities as $associatedVulnerability) {
                app(AdjustStatusAction::class)->handle($associatedVulnerability);
            }

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
