<?php

namespace App\Filament\Resources\IncidentTypeResource\Pages;

use App\Filament\Resources\IncidentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
class EditIncidentType extends EditRecord
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['inc_name'] = Str::ucwords($data['inc_name']);

        return $data;
    }

}
