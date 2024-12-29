<?php

namespace App\Filament\Resources\SpamReportResource\Pages;

use App\Filament\Resources\SpamReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpamReports extends ListRecords
{
    protected static string $resource = SpamReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
