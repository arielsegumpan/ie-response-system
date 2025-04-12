<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\IncidentResource;

class ViewIncident extends ViewRecord
{
    protected static string $resource = IncidentResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var Incident */
        $record = $this->getRecord();
        return $record->incident_number;
    }

    protected function getActions(): array
    {
        return [];
    }

    public $location; // for use in infolist, in map picker
}
