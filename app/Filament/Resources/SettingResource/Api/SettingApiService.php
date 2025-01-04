<?php
namespace App\Filament\Resources\SettingResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SettingResource;
use Illuminate\Routing\Router;


class SettingApiService extends ApiService
{
    protected static string | null $resource = SettingResource::class;

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
