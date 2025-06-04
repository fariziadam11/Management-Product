<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading, SkipsEmptyRows
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        // Only create if all required fields are present
        if (!isset($row['name'], $row['sku'], $row['price'], $row['stock'])) {
            return null;
        }

        return new Product([
            'name'  => $row['name'],
            'sku'   => $row['sku'],
            'price' => $row['price'],
            'stock' => $row['stock'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name'  => ['required', 'string', 'max:255'],
            '*.sku'   => ['required', 'string', 'max:100'],
            '*.price' => ['required', 'numeric', 'min:0'],
            '*.stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function chunkSize(): int
    {
        return 500; // Adjust as needed for performance
    }
}
