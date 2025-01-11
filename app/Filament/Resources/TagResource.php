<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tag')
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make('contact_id')
                            ->label('phone number')
                            ->relationship('contact', 'contact_phone')
                            ->preload()
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('tag')
                            ->required()
                            ->maxLength(32),
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact.contact_phone')
                    ->label('Phone Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact.contact_name')
                    ->label('Owner Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tag')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->action(function (Tag $record) {
                    //check if contact has client
                    if ($record->client()->exists()) {
                        Notification::make()
                            ->title('Tag has Client')
                            ->danger()
                            ->send();
                        return false;
                    } else {
                        $record->delete();
                        Notification::make()
                            ->title('Tag Deleted')
                            ->success()
                            ->send();
                    }
                })
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
