<?php

namespace App\Filament\Resources;

use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\PostResource\Pages;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->columnSpan(3),
                ColorPicker::make('color'),
                TextInput::make('slug')->required(),
                TextInput::make('price')->required(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->directory('post')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->directory('post')
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ]),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ,
                RichEditor::make('content')->required()
                    ->hint('Translatable')
                    ->hintColor('primary')->columnSpan(3),
                Toggle::make('published')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('success')
                    ->offColor('danger'),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail'),
                TextColumn::make('category.name')->sortable()->searchable(),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('price')->sortable()->searchable(),
                TextColumn::make('color'),

                CheckboxColumn::make('published'),
                ImageColumn::make('Image'),
                TextColumn::make('created_at')->label('Date')->date()->sortable()->searchable()
             ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
        ];
    }
}
