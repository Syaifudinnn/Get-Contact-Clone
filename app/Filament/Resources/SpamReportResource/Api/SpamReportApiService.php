<?php
namespace App\Filament\Resources\SpamReportResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SpamReportResource;
use Illuminate\Routing\Router;


class SpamReportApiService extends ApiService
{
    protected static string | null $resource = SpamReportResource::class;

    public static function handlers() : array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
