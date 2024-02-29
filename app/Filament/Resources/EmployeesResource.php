<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeesResource\Pages;
use App\Filament\Resources\EmployeesResource\Widgets\EmployeesStatsOverview;
use App\Filament\Resources\EmployeesResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\Employees;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('firstname'),
                        TextInput::make('lastname'),
                        TextInput::make('address'),
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                        Select::make('state_id')->label('State')->options(function (callable $get) {
                            $country = Country::find($get('country_id'));
                            if (!$country) {
                                return State::all()->pluck('name', 'id');
                            }
                            return $country->states->pluck('name', 'id');
                        })->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                        Select::make('city_id')
                            ->label('City')->options(function (callable $get) {
                                $state = State::find($get('state_id'));
                                if (!$state) {
                                    return City::all()->pluck('name', 'id');
                                }
                                return $state->city->pluck('name', 'id');
                            })->reactive(),
                        Select::make('department_id')
                            ->relationship(name: 'department', titleAttribute: 'name'),
                        TextInput::make('zip_code'),
                        DatePicker::make('birth_date'),
                        DatePicker::make('date_hired'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname')->sortable()->searchable(),
                TextColumn::make('lastname')->sortable()->searchable(),
                TextColumn::make('address')->sortable()->searchable(),
                TextColumn::make('city.name'),
                TextColumn::make('state.name'),
                TextColumn::make('country.name'),
                TextColumn::make('department.name'),
                TextColumn::make('zip_code')->sortable()->searchable(),
                TextColumn::make('birth_date')->dateTime(),
                TextColumn::make('date_hired')->dateTime(),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime()
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
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
public static function getWidgets():array
{
    return [
        EmployeesStatsOverview::class
    ];
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployees::route('/create'),
            'edit' => Pages\EditEmployees::route('/{record}/edit'),
        ];
    }
}
