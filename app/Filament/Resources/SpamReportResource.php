<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpamReportResource\Pages;
use App\Filament\Resources\SpamReportResource\RelationManagers;
use App\Models\SpamReport;
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

class SpamReportResource extends Resource
{
    protected static ?string $model = SpamReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Spam Report')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('phone_number')
                            ->required()
                            ->maxLength(32),
                        Forms\Components\Textarea::make('reason')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Reporter Infromation')
                    ->columns(2)
                    ->schema([
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
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->wrap(),
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
                ->requiresConfirmation()
                ->action(function (SpamReport $record) {
                    //check if contact has client
                    if ($record->client()->exists()) {
                        Notification::make()
                            ->title('Spam Report has Client')
                            ->danger()
                            ->send();
                        return false;
                    } else {
                        $record->delete();
                        Notification::make()
                            ->title('Spam Report Deleted')
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
            'index' => Pages\ListSpamReports::route('/'),
            'create' => Pages\CreateSpamReport::route('/create'),
            'edit' => Pages\EditSpamReport::route('/{record}/edit'),
        ];
    }
}
