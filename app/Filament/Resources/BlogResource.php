<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\BlogResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BlogResource\RelationManagers;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'sm' => 1,
                    'md' => 4,
                    'lg' => 5,
                ])
                ->schema([
                    Section::make([
                        Hidden::make('user_id')
                        ->default(auth()->user()->id)
                        ->dehydrated(),

                        TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(255)
                        ->placeholder(__('Title of your blog post'))
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                        ->label(__('Slug'))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->maxLength(255)
                        ->unique(Blog::class, 'slug', ignoreRecord: true),

                        RichEditor::make('content')
                        ->label(__('Content'))
                        ->required()
                        ->placeholder(__('The content of your blog'))
                        ->maxLength(4294967295),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ]),

                    Group::make([
                        Section::make()
                        ->schema([
                            FileUpload::make('featured_img')
                            ->label(__('Featured Image'))
                            ->image()
                            ->hiddenLabel()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                            ])->maxSize(2048)
                            ->columnSpanFull(),


                            Select::make('categories')
                            ->label(__('Categories'))
                            ->multiple()
                            ->relationship(name: 'categories', titleAttribute: 'cat_name')
                            ->preload()
                            ->searchable()
                            ->placeholder(__('Select categories'))
                            ->optionsLimit(6)
                            ->native(false),

                            Select::make('tags')
                            ->label(__('Tags'))
                            ->multiple()
                            ->relationship(name: 'tags', titleAttribute: 'tag_name')
                            ->preload()
                            ->searchable()
                            ->placeholder(__('Select tags'))
                            ->optionsLimit(6)
                            ->native(false),

                            ToggleButtons::make('status')
                            ->label(__('Status'))
                            ->default('published')
                            ->dehydrated()
                            ->options([
                                'draft' => __('Draft'),
                                'published' => __('Published'),
                            ])
                            ->colors([
                                'draft' => 'warning',
                                'published' => 'success',
                            ])
                            ->icons([
                                'draft' => 'heroicon-o-pencil',
                                'published' => 'heroicon-o-check-circle',
                            ])
                            ->inline(),

                            ToggleButtons::make('is_featured')
                            ->label(__('Featured'))
                            ->default(0)
                            ->dehydrated()
                            ->options([
                                0 => __('No'),
                                1 => __('Yes'),
                            ])
                            ->colors([
                                0 => 'danger',
                                1 => 'success',
                            ])
                            ->icons([
                                0 => 'heroicon-o-x-circle',
                                1 => 'heroicon-o-check-circle',
                            ])
                            ->inline(),
                            ToggleButtons::make('is_visible')
                            ->label(__('Visible'))
                            ->default(1)
                            ->dehydrated()
                            ->options([
                                0 => __('No'),
                                1 => __('Yes'),
                            ])
                            ->colors([
                                0 => 'danger',
                                1 => 'success',
                            ])
                            ->icons([
                                0 => 'heroicon-o-x-circle',
                                1 => 'heroicon-o-check-circle',
                            ])
                            ->inline(),
                        ]),

                        Section::make()
                        ->schema([
                            TextInput::make('meta_title')
                            ->label(__('Meta Title'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('Meta title of your blog post'))
                            ->live(onBlur: true),

                            TextInput::make('meta_description')
                            ->label(__('Meta Description'))

                        ])


                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ]),
                ])
                ->columnSpanFull()

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
                Tables\Actions\EditAction::make(),
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
                ->label(__('New Blog')),
            ])
            ->emptyStateIcon('heroicon-o-pencil-square')
            ->emptyStateHeading('No Blogs are created')
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
            'view' => Pages\ViewBlog::route('/{record}'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewBlog::class,
            Pages\EditBlog::class,
        ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([]);
    }
}
