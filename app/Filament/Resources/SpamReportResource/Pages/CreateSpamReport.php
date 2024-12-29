<?php

namespace App\Filament\Resources\SpamReportResource\Pages;

use App\Filament\Resources\SpamReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSpamReport extends CreateRecord
{
    protected static string $resource = SpamReportResource::class;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
