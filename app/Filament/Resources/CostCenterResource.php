<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CostCenterResource\Pages;
use App\Models\CostCenter;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;

class CostCenterResource extends Resource
{
    protected static ?string $model = CostCenter::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'TE Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('manager')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('manager')->sortable(),
                Tables\Columns\TextColumn::make('email')->sortable(),
                Tables\Columns\TextColumn::make('department')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostCenters::route('/'),
            'create' => Pages\CreateCostCenter::route('/create'),
            'edit' => Pages\EditCostCenter::route('/{record}/edit'),
            'view' => Pages\ViewCostCenter::route('/{record}'),
        ];
    }
}
