<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->dehydrated(fn ($state) => ! empty($state)),

                // Add more fields as needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable(),

                // Add more columns as needed
            ])
            ->filters([
                // Example filter for users created in the last 30 days
                Tables\Filters\Filter::make('Recent')
                    ->query(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(30))),

                // Add more filters as needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // Add more actions as needed
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                // Add more bulk actions as needed
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any related models here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
