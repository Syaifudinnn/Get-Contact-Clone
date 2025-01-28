<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Contact Infromation')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('contact_name')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\TextInput::make('contact_phone')
                            ->required()
                            ->maxLength(32),
                    ]),
                Section::make('Client Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->searchable()
                            ->preload()
                            ->relationship('user', 'name')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('contact_phone')
                    ->query(function ($query, $data) {
                        $phone = $data['search'];

                        if (str_starts_with($phone, '08')) {
                            $phone = '+62' . substr($phone, 1);
                        }

                        return $query->where('contact_phone', 'LIKE', $phone . '%');
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
                    ->requiresConfirmation()
                    ->action(function (Contact $record) {
                        //check if contact has client
                        if ($record->client()->exists()) {
                            Notification::make()
                                ->title('Contact has Client')
                                ->danger()
                                ->send();
                            return false;
                        } else {
                            $record->delete();
                            Notification::make()
                                ->title('Contact Deleted')
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
