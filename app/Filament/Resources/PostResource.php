<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Area; // Import the Area model
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder; // Ensure this is imported

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase'; // Update to briefcase icon
    protected static ?string $navigationGroup = 'TE Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter post name'),

                Select::make('area_id')
                    ->label('Area')
                    ->options(
                        Area::all()->pluck('name', 'id')->toArray()
                    )
                    ->nullable()
                    ->searchable() // Allow searching in the select options
                    ->preload() // Optional: preload options for faster selection
                    ->placeholder('Select an area'),

                // Add more fields as needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('area.name')
                    ->label('Area')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Corrected filter callback with appropriate type hinting
                Tables\Filters\Filter::make('Recent')
                    ->query(function (Builder $query) {
                        return $query->where('created_at', '>=', now()->subDays(30));
                    }),

                // Add additional filters as needed
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(), // Optional: adds a view action if you have a view page
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),

                // Add more bulk actions if needed
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
        ];
    }
}
