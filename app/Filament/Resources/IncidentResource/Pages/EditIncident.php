<?php

namespace App\Filament\Resources\IncidentResource\Pages;

use App\Filament\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncident extends EditRecord
{
    protected static string $resource = IncidentResource::class;

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
        // // If we have image uploads
        // if (isset($data['image_path']) && is_array($data['image_path'])) {
        //     // The record being edited
        //     $incident = $this->getRecord();

        //     // Clear existing images if needed, or handle updates
        //     // Option 1: Delete all existing images and re-create them
        //     $incident->images()->delete();

        //     // Create new image records for each uploaded file
        //     foreach ($data['image_path'] as $imagePath) {
        //         $incident->images()->create([
        //             'image_path' => $imagePath,
        //         ]);
        //     }

        //     // Remove image_path from the data array since we've handled it manually
        //     unset($data['image_path']);
        // }

        return $data;
    }
}
