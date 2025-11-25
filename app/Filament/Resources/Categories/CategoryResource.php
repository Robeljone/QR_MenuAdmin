<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\ManageCategories;
use App\Models\Category;
use App\Models\Company;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Category';

    public static function getEloquentQuery(): Builder
       {
           $query = parent::getEloquentQuery();

           $user = auth()->user();

           if ($user->role = 'owner') {
               // Limit categories based on owner’s company
               $query->where('company_id', $user->company_id);
           }

           return $query;
       }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('company_id')
                ->label('Restaurant')
                ->options(function () {
                 $user = auth()->user();
                 if ($user->company_id) {
                     return Company::where('id', $user->company_id)
                         ->pluck('name', 'id')
                         ->toArray();
                 }
                 return Company::pluck('name', 'id')->toArray();
                             }),
                Select::make('status')
                    ->options([
                        '1' => 'Active',
                        '2' => 'Passive'
                    ])
                     ]);
                 }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Category')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

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
            'index' => ManageCategories::route('/'),
        ];
    }

        public static function getNavigationGroup(): ?string
{
    return 'Management';
}
}
