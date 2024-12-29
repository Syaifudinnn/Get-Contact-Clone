<?php

namespace App\Filament\Resources\SpamReportResource\Pages;

use App\Filament\Resources\SpamReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpamReport extends EditRecord
{
    protected static string $resource = SpamReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
