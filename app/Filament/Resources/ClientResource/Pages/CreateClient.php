<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    // Override the getRedirectUrl method to redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Customize after save to add default settings for the new client
    protected function afterSave(): void
    {
        parent::afterSave();

        // Get the newly created client
        $client = $this->record;

        // Check if a setting already exists for the client, if not, create default settings
        if (!$client->setting) {
            Setting::create([
                'client_id' => $client->id,
                'spam_protection_enabled' => false,  // Default value
                'tag_visibility' => 'public',      // Default value
            ]);
        }
    }
}
