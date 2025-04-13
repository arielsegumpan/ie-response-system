<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Incident;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\PriorityEnum;
use Illuminate\Support\Str;
use App\Models\IncidentType;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Enums\IncidentStatusEnum;
use Dotswan\MapPicker\Fields\Map;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Dotswan\MapPicker\Infolists\MapEntry;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\IncidentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Group as InfoGroup;
use Filament\Infolists\Components\Section as InfoSection;
use App\Filament\Resources\IncidentResource\RelationManagers;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 4,
                    'lg' => 5,
                ])
                ->schema([
                    Group::make([
                        Section::make()
                        ->schema([

                            Hidden::make('user_id')
                            ->default(auth()->user()->id)
                            ->dehydrated(),

                            TextInput::make('incident_number')
                            ->label('Incident Number')
                            ->required()
                            ->unique(Incident::class, 'incident_number', ignoreRecord: true)
                            ->maxLength(255)
                            ->disabled()
                            ->default('INC#' . '-' . strtoupper(Str::random(6)) . '-' . rand(500, 9999))
                            ->dehydrated(),

                            Select::make('incident_type_id')
                            ->label('Incident Type')
                            ->relationship(name: 'type', titleAttribute: 'inc_name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->optionsLimit(6)
                            ->native(false)
                            ->createOptionForm([
                                Section::make()
                                ->schema([
                                    Group::make([
                                        TextInput::make('inc_name')
                                        ->required()
                                        ->label(__('Incident Name'))
                                        ->unique(IncidentType::class, 'inc_name', ignoreRecord: true)
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('inc_slug', Str::slug($state))),

                                        TextInput::make('inc_slug')
                                        ->label(__('Slug'))
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(IncidentType::class, 'inc_slug', ignoreRecord: true),
                                    ])
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 2,
                                        'lg' => 2
                                    ]),

                                    Textarea::make('inc_description')
                                    ->label(__('Description'))
                                    ->rows(5)
                                    ->maxLength(1024)
                                    ->columnSpanFull(),

                                ])
                            ]),

                            RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->maxLength(65535),

                            ToggleButtons::make('status')
                            ->label('Status')
                            ->options(IncidentStatusEnum::class)
                            ->inline()
                            ->default(IncidentStatusEnum::REPORTED)
                            ->dehydrated()
                            ->required(),

                            ToggleButtons::make('priority')
                            ->label('Priority')
                            ->options(PriorityEnum::class)
                            ->inline()
                            ->default(PriorityEnum::MEDIUM)
                            ->dehydrated()
                            ->required(),

                        ]),

                        Section::make('Upload Attachments')
                        ->schema([

                            Repeater::make('images')
                            ->hiddenlabel()
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('image_path')
                                ->hiddenlabel()
                                ->image()
                                ->imageEditor()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1920')
                                ->imageResizeTargetHeight('1080')
                                ->reorderable()
                                ->appendFiles()
                                ->uploadingMessage('Uploading attachment...')
                                ->maxSize(2048)
                                ->maxFiles(5)
                            ])
                            ->addActionLabel('Add Attachment')
                            ->reorderable()
                            ->reorderableWithButtons()
                            ->reorderableWithDragAndDrop()
                            ->collapsible()
                            ->grid([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 2
                            ])


                        ])
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3
                    ]),

                    // Incident Location
                    Section::make()
                    ->relationship('location')
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

                            Textarea::make('geojson')
                            ->hidden()
                            ->rows(6),

                        ])
                        ->columns([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 2

                        ]),

                        Map::make('location')
                        ->label(__('Incident Location'))
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
                        ->showMyLocationButton(true, true, 5000)
                        ->rangeSelectField('distance')

                         // GeoMan Integration
                        ->geoMan(true)
                        ->geoManEditable(true)
                        ->geoManPosition('topleft')
                        ->rotateMode(true)
                        ->drawMarker(true)
                        ->drawRectangle(true)
                        ->drawText(true)
                        ->dragMode(true)
                        ->setColor('#3388ff')
                        ->setFilledColor('#cad9ec')
                        ->snappable(true, 20)

                        // Extra Customization
                        ->extraStyles([
                            'min-height: 70vh',
                            'border-radius: 1rem'
                        ])
                        ->extraControl(['customControl' => true])
                        ->extraTileControl(['customTileOption' => 'value'])

                        // State Management
                        ->afterStateUpdated(function (Set $set, ?array $state): void {
                            if ($state && isset($state['lat']) && isset($state['lng'])) {
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);

                                // Check if geojson key exists before trying to access it
                                if (isset($state['geojson'])) {
                                    $set('geojson', json_encode($state['geojson']));
                                }
                            }
                        })

                        ->afterStateHydrated(function ($state, $record, Set $set): void {
                            if ($record && isset($record->latitude) && isset($record->longitude)) {
                                $set('location', [
                                    'lat' => $record->latitude,
                                    'lng' => $record->longitude,
                                    'geojson' => $record->geojson ? json_decode(strip_tags($record->geojson)) : null
                                ]);
                            }
                        }),


                        Group::make([
                            Textarea::make('location_description')
                            ->label('Location Description')
                            ->maxLength(65535)
                            ->rows(6),

                            Textarea::make('landmark')
                            ->label('Landmark')
                            ->maxLength(65535)
                            ->rows(6),
                        ])



                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2
                    ])

                ])
                ->columnSpanFull()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('images.image_path')
                ->label(__(''))
                ->circular()
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(isSeparate: true)
                ->wrap()
                ->ring(3),

                TextColumn::make('incident_number')
                ->label('Incident #')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => strtoupper($state))
                ->weight(FontWeight::Bold)
                ->badge()
                ->color('primary'),

                TextColumn::make('type.inc_name')
                ->label('Incident Type')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->weight(FontWeight::Bold),

                TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->weight(FontWeight::Bold)
                ->badge()
                ->color(function (string $state): string {
                    return match ($state) {
                        'reported' => 'warning',
                        'verified' => 'info',
                        'in_progress' => 'primary',
                        'resolved' => 'success',
                        'closed' => 'danger',
                        default => 'secondary',
                    };
                })
                ->icon(function (string $state): string {
                    return match ($state) {
                        'reported' => 'heroicon-s-flag',
                        'verified' => 'heroicon-s-check-circle',
                        'in_progress' => 'heroicon-s-cog',
                        'resolved' => 'heroicon-s-check-circle',
                        'closed' => 'heroicon-s-x-circle',
                        default => 'heroicon-s-clock',
                    };
                }),

                TextColumn::make('priority')
                ->label('Priority')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->weight(FontWeight::Bold)
                ->badge()
                ->color(function (string $state): string {
                    return match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'critical' => 'danger',
                    };
                })
                ->icon(function (string $state): string {
                    return match ($state) {
                        'low' => 'heroicon-o-arrow-trending-down',
                        'medium' => 'heroicon-o-arrows-right-left',
                        'high' => 'heroicon-o-arrow-trending-up',
                        'critical' => 'heroicon-o-arrow-trending-up',
                    };
                }),

                TextColumn::make('created_at')
                ->label('Reported At')
                ->sortable()
                ->searchable()
                ->date()
                ->since()


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
            'view' => Pages\ViewIncident::route('/{record}'),
        ];
    }


    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewIncident::class,
            Pages\EditIncident::class,
        ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                InfoSection::make()
                ->schema([

                    InfoGroup::make([
                        TextEntry::make('incident_number')
                        ->label('Incident #')
                        ->weight(FontWeight::Bold)
                        ->size(TextEntry\TextEntrySize::Large)
                        // ->badge()
                        ->color('primary'),

                        TextEntry::make('status')
                        ->label('Status')
                        ->weight(FontWeight::Bold)
                        ->size(TextEntry\TextEntrySize::Large)
                        ->badge()
                        ->color(function (string $state): string {
                            return match ($state) {
                                'reported' => 'warning',
                                'verified' => 'info',
                                'in_progress' => 'primary',
                                'resolved' => 'success',
                                'closed' => 'danger',
                                default => 'secondary',
                            };
                        })
                        ->icon(function (string $state): string {
                            return match ($state) {
                                'reported' => 'heroicon-s-flag',
                                'verified' => 'heroicon-s-check-circle',
                                'in_progress' => 'heroicon-s-cog',
                                'resolved' => 'heroicon-s-check-circle',
                                'closed' => 'heroicon-s-x-circle',
                                default => 'heroicon-s-clock',
                            };
                        }),

                        TextEntry::make('priority')
                        ->label('Priority')
                        ->weight(FontWeight::Bold)
                        ->size(TextEntry\TextEntrySize::Large)
                        ->badge()
                        ->color(function (string $state): string {
                            return match ($state) {
                                'low' => 'success',
                                'medium' => 'warning',
                                'high' => 'danger',
                                'critical' => 'danger',
                            };
                        })
                        ->icon(function (string $state): string {
                            return match ($state) {
                                'low' => 'heroicon-o-arrow-trending-down',
                                'medium' => 'heroicon-o-arrows-right-left',
                                'high' => 'heroicon-o-arrow-trending-up',
                                'critical' => 'heroicon-o-arrow-trending-up',
                            };
                        }),
                    ])
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3
                    ]),

                    MapEntry::make('location')
                    ->hiddenlabel()
                    // Basic Configuration
                    ->defaultLocation(latitude: 40.4168, longitude: -3.7038)
                    ->draggable(false) // Usually false for infolist view
                    ->zoom(15)
                    ->minZoom(0)
                    ->maxZoom(28)
                    ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                    ->detectRetina(true)

                    // Marker Configuration
                    ->showMarker(true)
                    // Controls
                    ->showFullscreenControl(true)
                    ->showZoomControl(true)

                    // Styling
                    ->extraStyles([
                        'min-height: 50vh',
                        'border-radius: 1rem'
                    ])
                    // State Management
                    ->state(fn ($record) => [
                        'lat' => $record?->location?->latitude,
                        'lng' => $record?->location?->longitude,
                        'geojson' => $record?->location?->geojson ? json_decode($record->location?->geojson) : null
                    ]),


                    TextEntry::make('description')
                    ->html()
                    ->markdown()
                    ->columnSpanFull(),




                ])

            ]);
    }
}
