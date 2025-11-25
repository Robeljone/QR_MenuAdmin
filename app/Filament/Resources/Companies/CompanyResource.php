<?php

namespace App\Filament\Resources\Companies;

use App\Filament\Resources\Companies\Pages\ManageCompanies;
use App\Models\Company;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Company';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Company Name')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('bot_token')
                    ->label('Telegram Bot')
                    ->required()
                    ->maxLength(255),
                    Textarea::make('greeting')
                    ->label('Telegram Start Message')
                    ->required()
                    ->columnSpanFull(),
                    TextInput::make('location')
                    ->label('location x,y')
                    ->required()
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Company')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('bot_token')
                    ->searchable(),
                TextColumn::make('greeting')
                    ->searchable(),
                TextColumn::make('location')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCompanies::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
{
    return 'Settings';
}
}
