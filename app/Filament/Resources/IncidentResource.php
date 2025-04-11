<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Incident;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\IncidentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\IncidentResource\RelationManagers;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                // Incident Location
                Section::make()
                ->schema([

                    Group::make([
                        TextInput::make('latitude')
                        ->label('Latitude')
                        ->required()
                        ->maxLength(255),

                        TextInput::make('longitude')
                        ->label('Longitude')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2

                    ]),

                    Map::make('location')
                    ->label('Map Picker')
                    ->columnSpanFull()
                    // Basic Configuration
                    ->defaultLocation(latitude: 10.901002750609775, longitude: 123.07139009929351)
                    ->draggable(true)
                    ->clickable(true)
                    ->zoom(14)
                    ->minZoom(2)
                    ->maxZoom(19)
                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                    ->detectRetina(true)

                    // Marker Configuration
                    ->showMarker(true)

                    // Controls
                    ->showFullscreenControl(true)
                    ->showZoomControl(true)

                    // Location Features
                    ->liveLocation(true, true, 5000)
                    ->showMyLocationButton(true)
                    ->rangeSelectField('distance')

                    // Extra Customization
                    ->extraStyles([
                        'min-height: 50vh',
                        'border-radius: 1rem'
                    ])
                    ->extraControl(['customControl' => true])
                    ->extraTileControl(['customTileOption' => 'value'])

                    // State Management
                    ->afterStateUpdated(function (Set $set, ?array $state): void {
                        $set('latitude', $state['lat']);
                        $set('longitude', $state['lng']);
                    }),

                    Group::make([
                        RichEditor::make('location_description')
                        ->label('Location Description')
                        ->maxLength(65535)
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'orderedList',
                            'redo',
                            'underline',
                            'undo',
                        ]),

                        RichEditor::make('landmark')
                        ->label('Landmark')
                        ->maxLength(65535)
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'orderedList',
                            'redo',
                            'underline',
                            'undo',
                        ]),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2

                    ]),


                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->tooltip('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                ->icon('heroicon-m-plus')
                ->label(__('New Incident')),
            ])
            ->emptyStateIcon('heroicon-o-exclamation-triangle')
            ->emptyStateHeading('No Incidents are created')
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListIncidents::route('/'),
            'create' => Pages\CreateIncident::route('/create'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}
