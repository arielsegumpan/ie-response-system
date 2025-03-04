<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('post_title')
                ->label('Title')
                ->required()
                ->maxLength(255),

                FileUpload::make('featured_image')
                ->HiddenLabel()
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->maxSize(2048)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('featured_image')
                ->label('Image')
                ->extraImgAttributes(['loading' => 'lazy'])
                ->square()
                ->size(50),

                TextColumn::make('post_title')
                ->label('Title')
                ->weight(FontWeight::Bold)
                ->searchable()
                ->sortable()
                ->description(fn (Post $record): string => $record->post_slug),

                IconColumn::make('is_featured')
                ->label('Is Featured?')
                ->boolean()
                ->trueColor('info')
                ->falseColor('danger'),

                CheckboxColumn::make('is_published')
                ->label('Is Published?'),

                TextColumn::make('postCategory.cat_name')
                ->label('Category')
                ->formatStateUsing(fn (string $state): string => ucwords($state))
                ->badge()
                ->color('warning'),

                TextColumn::make('post_content')
                ->label('Content')
                ->wrap()
                ->markdown()
                ->limit(70)
                ->toggleable(isToggledHiddenByDefault: true),


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
                ->label(__('Create Post')),
            ])
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('No posts are created')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewPost::class,
            Pages\EditPost::class,
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                 TextEntry::make('post_slug')
                ->hiddenLabel()
                ->label('Slug')
                ->icon('heroicon-o-link')
                ->color('info')
                ->size(TextEntry\TextEntrySize::Small)
                ->columnSpanFull(),

                TextEntry::make('postCategory.cat_name')
                ->hiddenLabel()
                ->badge()
                ->formatStateUsing(fn (string $state): string => ucwords($state))
                ->color('success'),


                ImageEntry::make('featured_image')
                ->hiddenLabel()
                ->extraImgAttributes(['loading' => 'lazy'])
                ->width(725)
                ->height(450),


                TextEntry::make('post_content')
                ->markdown()
                ->hiddenLabel()
                ->columnSpanFull(),

                TextEntry::make('tags.tag_name')
                ->hiddenLabel()
                ->badge()
                ->separator(',')
                ->formatStateUsing(fn (string $state): string => ucwords($state))
                ->color('warning')



            ])
            ->columns(1);
    }
}
