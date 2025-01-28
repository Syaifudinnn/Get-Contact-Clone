<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SearchHistoryResource\Pages;
use App\Filament\Resources\SearchHistoryResource\RelationManagers;
use App\Models\SearchHistory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SearchHistoryResource extends Resource
{
    protected static ?string $model = SearchHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(32),
                Forms\Components\DateTimePicker::make('searched_at')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('searched_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('phone_number')
                    ->query(function ($query, $data) {
                        $phone = $data['search'];

                        // Normalisasi input untuk pencarian
                        if (str_starts_with($phone, '08')) {
                            $phone = '+62' . substr($phone, 1);
                        }

                        return $query->where('phone_number', 'LIKE', $phone . '%');
                    })
                    ->form([
                        TextInput::make('search')
                            ->label('Phone Number')
                            ->placeholder('Enter phone number (08 or +62)')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSearchHistories::route('/'),
            'create' => Pages\CreateSearchHistory::route('/create'),
            'edit' => Pages\EditSearchHistory::route('/{record}/edit'),
        ];
    }
}
