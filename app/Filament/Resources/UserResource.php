<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("first_name")->label('First Name')->required()->maxLength(25),
                TextInput::make("last_name")->label('Last Name')->required()->maxLength(25),
                TextInput::make("email")->label('Email Address')
                ->unique()
                ->email()
                ->required()
                ->maxLength(255),
                TextInput::make("password")->label('Password')->password()->required()->maxLength(25)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')  ->getStateUsing(function (Model $record): string {
                    return $record->first_name ." ".$record->last_name;
                })->sortable(['first_name', 'last_name']) 
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                }),
                TextColumn::make("email")->sortable("email")->searchable('email'),
                TextColumn::make("status")->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'in-active' => 'danger',
                })->sortable("status")->searchable('status'),
            ])
            ->filters([
                SelectFilter::make("status")
                ->options([
                    'active' => 'active',
                    'in-active' => 'in-active',
                ]),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
