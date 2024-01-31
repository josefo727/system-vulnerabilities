<?php

namespace App\Actions;

use App\Models\AssociatedVulnerability;
use App\Services\RiskEvaluationService;
use Illuminate\Support\Facades\Log;

class AdjustStatusAction
{
    public function handle(AssociatedVulnerability $associatedVulnerability): void
    {
        try {
            [ , , $statusId] = app(RiskEvaluationService::class)
                ->handle(
                    $associatedVulnerability->report_id,
                    $associatedVulnerability->asset_id,
                    $associatedVulnerability->id
                );

            $associatedVulnerability->status_id = $statusId;
            $associatedVulnerability->save();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
}
