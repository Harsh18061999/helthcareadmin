<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Filament\Resources\DoctorResource\Widgets\DoctorOverview;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make("Basic Info")
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('email')
                            ->label('Email address')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('phone_number')
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date of birth')
                            ->maxDate('today'),

                        Textarea::make('address')->label('Address')->columnSpan('full'),
                        Forms\Components\MarkdownEditor::make('about_my_self')
                            ->columnSpan('full'),
                    ])->columns(2)->collapsible(),

                   
                ])->columnSpan(2)->columns(3),
                Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Forms\Components\Toggle::make('status')
                                ->label('Active')
                                ->helperText("Manage the doctor status available or unavailable")
                                ->default(true)
                        ])->collapsible(),
                        Forms\Components\Section::make('Profile Image')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('profile_image')
                                ->collection('profile_image')
                                ->responsiveImages()
                                ->hiddenLabel(),
                        ])
                        ->collapsible(),
                ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('profile_image')
                    ->label('Image')
                    ->collection('profile_image'),
                TextColumn::make('full_name')->getStateUsing(function (Model $record): string {
                    return $record->first_name . " " . $record->last_name;
                })->sortable(['first_name', 'last_name'])
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    }),
                TextColumn::make("email")->sortable("email")->searchable('email'),
                TextColumn::make("phone_number")->sortable("phone_number")->searchable('phone_number'),
                TextColumn::make("status")->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'in-active' => 'danger',
                    })->sortable("status")->searchable('status'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SkillRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            DoctorOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
