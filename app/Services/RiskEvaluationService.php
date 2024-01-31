<?php

namespace App\Services;

use App\Enums\Criticality;
use App\Enums\Severity;
use App\Models\Asset;
use App\Models\Report;
use App\Models\RiskLevel;
use App\Models\Status;
use App\Models\Vulnerability;
use Carbon\Carbon;

class RiskEvaluationService
{
    /**
     * @return array<string,null>
     */
    public function handle(string|int|null $reportId, string|int|null $assetId, string|int|null $vulnerabilityId): array
    {
        if (empty($reportId) || empty($assetId) || empty($vulnerabilityId)) {
            return $this->returnNull();
        }

        $criticality = optional(Asset::query()->select('criticality')->find($assetId))->criticality;

        if (is_null($criticality)) {
            return $this->returnNull();
        }

        $criticalityValue = Criticality::{$criticality}->value;

        if (is_null($criticalityValue)) {
            return $this->returnNull();
        }

        $severity = optional(Vulnerability::query()->select('severity')->find($vulnerabilityId))->severity;

        if (is_null($severity)) {
            return $this->returnNull();
        }

        $severityValue = Severity::{$severity}->value();

        if (is_null($severityValue)) {
            return $this->returnNull();
        }

        $riskValue = $criticalityValue + $severityValue - 1;

        $detectedAt = optional(Report::query()->select('detected_at')->find($reportId))->detected_at;

        if (is_null($detectedAt)) {
            return $this->returnNull();
        }

        $riskLevel = RiskLevel::query()->whereJsonContains('values', $riskValue)->first();

        $patchMaxAt = Carbon::parse($detectedAt)->addDays($riskLevel->days_to_add);

        $lowRisk = RiskLevel::query()->take(2)->pluck('values')->collapse();

        $statusId = $lowRisk->contains($riskValue)
            ? Status::getNoImpactStatusId()
            : ($patchMaxAt->isFuture() ? Status::getOnScheduleStatusId() : Status::getPendingStatusId());

        return [$riskLevel->id, $patchMaxAt->format('Y-m-d'), $statusId];
    }

    /**
     * @return array<null>
     */
    private function returnNull(): array
    {
        return [null, null, null];
    }
}
