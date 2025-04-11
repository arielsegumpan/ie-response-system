<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Volunteer;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Enums\AvailabilityStatusEnum;
use App\Enums\VerificationStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\VolunteerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VolunteerResource\RelationManagers;
use Filament\Forms\Components\RichEditor;

class VolunteerResource extends Resource
{
    protected static ?string $model = Volunteer::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    Select::make('user_id')
                    ->relationship(name: 'user', titleAttribute: 'name', ignoreRecord: true)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(6)
                    ->native(false)
                    ->getOptionLabelUsing(fn($record) => ucwords($record->name)),

                    Select::make('organization_id')
                    ->relationship(name: 'organization', titleAttribute: 'org_name', ignoreRecord: true)
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(6)
                    ->native(false),

                    ToggleButtons::make('availability_status')
                    ->options(AvailabilityStatusEnum::class)
                    ->inline()
                    ->default(AvailabilityStatusEnum::AVAILABLE)
                    ->dehydrated()
                    ->required(),

                    ToggleButtons::make('verification_status')
                    ->options(VerificationStatusEnum::class)
                    ->inline()
                    ->default(VerificationStatusEnum::PENDING)
                    ->dehydrated()
                    ->required(),

                    RichEditor::make('notes')
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->required(),

                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 3
                ]),

                Section::make()
                ->schema([
                    TextInput::make('certification_info.certification_name')
                    ->maxLength(255)
                    ->label(__('Certification Name')),

                    TextInput::make('certification_info.issuer')
                    ->maxLength(255)
                    ->label(__('Issuer')),

                    DatePicker::make('certification_info.issued_date')
                    ->native(false)
                    ->label(__('Issued Date'))
                    ->closeOnDateSelection(),

                    DatePicker::make('certification_info.expiration_date')
                    ->native(false)
                    ->label(__('Expiration Date'))
                    ->closeOnDateSelection(),
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 2
                ])

            ])
            ->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 5
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
                ->label(__('New Volunteer')),
            ])
            ->emptyStateIcon('heroicon-o-face-smile')
            ->emptyStateHeading('No Volunteers are created')
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
            'index' => Pages\ListVolunteers::route('/'),
            'create' => Pages\CreateVolunteer::route('/create'),
            'edit' => Pages\EditVolunteer::route('/{record}/edit'),
        ];
    }
}
