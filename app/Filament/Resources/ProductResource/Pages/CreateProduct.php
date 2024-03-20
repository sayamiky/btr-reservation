<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductFile;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create($data);

        // Create a new Guardian model instance
        $file = new ProductFile();
        // Assuming 'student_id' is the foreign key linking to students
        $file->product_id = $record->id; 
        $file->file = $data['file'];

        // Save the Guardian model to insert the data
        $file->save();

        return $record;
    }
}
