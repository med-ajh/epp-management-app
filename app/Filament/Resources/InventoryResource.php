<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Models\Area;
use App\Models\Post;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube'; // Choose an appropriate icon

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),

                TextInput::make('description')
                    ->required()
                    ->maxLength(255),

                TextInput::make('size')
                    ->required()
                    ->maxLength(50),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('status', $state > 0 ? 'Available' : 'Not Available');
                    }),

                TextInput::make('image')
                    ->nullable()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Available' => 'Available',
                        'Not Available' => 'Not Available',
                    ])
                    ->reactive()
                    ->disabled(), // Disable if you want it to be controlled by quantity

                Select::make('area_id')
                    ->label('Area')
                    ->options(
                        Area::all()->pluck('name', 'id')
                    )
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('post_id', null); // Reset post_id when area_id changes
                    }),

                Select::make('post_id')
                    ->label('Post')
                    ->options(function ($get) {
                        return Post::where('area_id', $get('area_id'))->pluck('name', 'id');
                    })
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('label')->sortable(),
                TextColumn::make('description')->sortable(),
                TextColumn::make('size')->sortable(),
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('image')->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state === 'Available'
                            ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded">' . $state . '</span>'
                            : '<span class="bg-red-100 text-red-800 px-2 py-1 rounded">' . $state . '</span>';
                    })
                    ->html(),
                TextColumn::make('area.name')->label('Area'),
                TextColumn::make('post.name')->label('Post'),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                // Add any filters you want to apply here
            ])
            ->actions([
                // Define actions (e.g., view, edit, delete) if needed
            ])
            ->bulkActions([
                // Define bulk actions (e.g., delete) if needed
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
            'view' => Pages\ViewInventory::route('/{record}'),
        ];
    }
}
