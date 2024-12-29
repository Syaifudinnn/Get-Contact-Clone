<?php
namespace App\Filament\Resources\SearchHistoryResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SearchHistoryResource;
use Illuminate\Routing\Router;


class SearchHistoryApiService extends ApiService
{
    protected static string | null $resource = SearchHistoryResource::class;

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
