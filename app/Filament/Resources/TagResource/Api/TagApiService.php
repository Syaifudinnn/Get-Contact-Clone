<?php
namespace App\Filament\Resources\TagResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\TagResource;
use Illuminate\Routing\Router;


class TagApiService extends ApiService
{
    protected static string | null $resource = TagResource::class;

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
