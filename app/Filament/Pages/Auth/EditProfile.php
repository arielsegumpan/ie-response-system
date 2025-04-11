<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;

use Filament\Pages\Page;
use Woenel\Prpcmblmts\Philippines;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Woenel\Prpcmblmts\Models\PhilippineBarangay;
use Woenel\Prpcmblmts\Models\PhilippineCity;
use Woenel\Prpcmblmts\Models\PhilippineRegion;

class EditProfile extends BaseEditProfile
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $layout = 'filament-panels::components.layout.index';

    protected static string $view = 'filament.pages.auth.edit-profile';

    /**
     * Get the label for the page.
     */
    public static function getLabel(): string
    {
        return 'Profile';
    }

    /**
     * Get the title for the page.
     */
    public function getTitle(): string
    {
        return '';
    }

    public function form(Form $form): Form
    {
        $philippines = new Philippines;

        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->columnSpanFull(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                ]),

                Section::make('Address Information')
                    ->schema([

                        Select::make('region_id')
                        ->label('Region')
                        ->searchable()
                        ->getSearchResultsUsing(fn (string $query) => $philippines->regions()->where('name', 'like', "%{$query}%")->pluck('name', 'code'))
                        ->getOptionLabelUsing(fn ($value): ?string => $philippines->regions()->firstWhere('code', $value)?->getAttribute('name'))
                        ->native(false)
                        ->optionsLimit(6)
                        ->preload()
                        ->placeholder('Search Region (ex. Region III)')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (callable $set) => $set('province_id', null))
                        ->dehydrated()
                        ->default('REGION VI (WESTERN VISAYAS)')
                        ->dehydrateStateUsing(fn ($state) => $state ?? 'REGION VI (WESTERN VISAYAS)'),

                        Select::make('province_id')
                        ->label('Province')
                        ->searchable()
                        ->preload()
                        ->optionsLimit(6)
                        ->options(function (callable $get) use ($philippines) {
                            $regionId = $get('region_id');

                            if (!$regionId) {
                                return [];
                            }

                            return $philippines->provinces()
                                ->where('region_code', $regionId)
                                ->pluck('name', 'code');
                        })
                        ->placeholder('Select a region first')
                        ->live(onBlur: true)
                        ->disabled(fn (callable $get) => !$get('region_id'))
                        ->native(false)
                        ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),

                        Select::make('city_id')
                        ->label('City/Municipality')
                        ->searchable()
                        ->preload()
                        ->optionsLimit(6)
                        ->options(function (callable $get) use ($philippines) {
                            $provinceId = $get('province_id');

                            if (!$provinceId) {
                                return [];
                            }

                            return $philippines->cities()
                                ->where('province_code', $provinceId)
                                ->pluck('name', 'code');
                        })
                        ->placeholder('Select a province first')
                        ->native(false)
                        ->disabled(fn (callable $get) => !$get('province_id'))
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (callable $set) => $set('barangay_id', null)),

                        Select::make('barangay_id')
                        ->label('Barangay')
                        ->searchable()
                        ->preload()
                        ->optionsLimit(6)
                        ->options(function (callable $get) use ($philippines) {
                            $cityId = $get('city_id');

                            if (!$cityId) {
                                return [];
                            }

                            return $philippines->barangays()
                                ->where('city_code', $cityId)
                                ->pluck('name', 'id');
                        })
                        ->placeholder('Select a city/municipality first')
                        ->native(false)
                        ->disabled(fn (callable $get) => !$get('city_id')),

                        TextInput::make('street')
                            ->label('Street Address')
                            ->columnSpanFull(),

                        Textarea::make('additional_info')
                            ->label('Additional Information')
                            ->columnSpanFull(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                ]),
                Section::make('Emergency Contact')
                    ->schema([
                        TextInput::make('emergency_contact')
                            ->label('Contact Name'),
                        TextInput::make('emergency_contact_phone')
                            ->label('Contact Phone')
                            ->tel(),
                ]),

                Section::make()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent()
                        ->columnSpanFull(),
                        $this->getPasswordConfirmationFormComponent()
                        ->columnSpanFull(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                ]),


            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['profile'] = auth()->user()->profile?->toArray() ?? [];

        dd($data);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $profileData = $data['profile'] ?? [];
        unset($data['profile']);

        dd($profileData);
        return $data;
    }

    public function save(): void
    {

        dd($this->form->getState());

        $this->validate();

        $data = $this->form->getState();

        $user = auth()->user();

        $profileData = $data['profile'] ?? [];
        unset($data['profile']);

        $user->update($data);

        if (!$user->profile) {
            $user->profile()->create($profileData);
        } else {
            $user->profile->update($profileData);
        }

        $this->getSavedNotification()?->send();

        $this->redirect($this->getRedirectUrl());
    }
}
