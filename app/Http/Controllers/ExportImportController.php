<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Exports\ProductExport;
use App\Exports\ProductReviewExport;
use App\Exports\RoleExport;
use App\Exports\UserExport;
use App\Imports\CategoryImport;
use App\Imports\ProductImport;
use App\Imports\ProductReviewImport;
use App\Imports\RoleImport;
use App\Imports\UserImport;
use App\Jobs\ProcessExport;
use App\Jobs\ProcessImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{
    /**
     * Show the export form.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function showExportForm($type)
    {
        $fields = $this->getFieldsForType($type);
        
        // Get previous exports for this type
        $previousExports = \App\Models\Export::where('type', $type)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        if ($type === 'products') {
            $categories = Category::where('is_active', true)->get();
            return view('export-import.export-form', compact('type', 'fields', 'categories', 'previousExports'));
        } elseif ($type === 'reviews') {
            $products = Product::all();
            return view('export-import.export-form', compact('type', 'fields', 'products', 'previousExports'));
        } elseif ($type === 'users') {
            $roles = Role::all();
            return view('export-import.export-form', compact('type', 'fields', 'roles', 'previousExports'));
        } elseif ($type === 'categories') {
            $categories = Category::where('is_active', true)->get();
            return view('export-import.export-form', compact('type', 'fields', 'categories', 'previousExports'));
        }
        
        return view('export-import.export-form', compact('type', 'fields', 'previousExports'));
    }
    
    /**
     * Process the export request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array',
            'fields.*' => 'string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('export.form', $type)
                ->withErrors($validator)
                ->withInput();
        }
        
        $fields = $request->input('fields');
        $fileName = $type . '_export_' . Str::random(10) . '.xlsx';
        $filePath = 'exports/' . $fileName;
        
        // Dispatch export job to queue
        ProcessExport::dispatch($type, $fields, $filePath);
        
        return redirect()->route('dashboard')
            ->with('success', 'Export is being processed in the background. You will be notified when it is ready for download.');
    }
    
    /**
     * Download the exported file.
     *
     * @param  string  $fileName
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($fileName)
    {
        $path = storage_path('app/public/exports/' . $fileName);
        
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        
        return response()->download($path);
    }
    
    /**
     * Show the import form.
     *
     * @param  string  $type
     * @return \Illuminate\View\View
     */
    public function showImportForm($type)
    {
        $fields = $this->getFieldsForType($type);
        
        // Get related data based on type
        $previousImports = [];
        
        if ($type === 'products') {
            $categories = Category::where('is_active', true)->get();
            return view('export-import.import-form', compact('type', 'fields', 'categories', 'previousImports'));
        } elseif ($type === 'reviews') {
            $products = Product::all();
            return view('export-import.import-form', compact('type', 'fields', 'products', 'previousImports'));
        } elseif ($type === 'users') {
            $roles = Role::all();
            return view('export-import.import-form', compact('type', 'fields', 'roles', 'previousImports'));
        } elseif ($type === 'categories') {
            $categories = Category::where('is_active', true)->get();
            return view('export-import.import-form', compact('type', 'fields', 'categories', 'previousImports'));
        }
        
        return view('export-import.import-form', compact('type', 'fields', 'previousImports'));
    }
    
    /**
     * Process the import request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls',
            'fields' => 'required|array',
            'fields.*' => 'string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('import.form', $type)
                ->withErrors($validator)
                ->withInput();
        }
        
        $fields = $request->input('fields');
        $file = $request->file('file');
        $fileName = $type . '_import_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('imports', $fileName, 'public');
        
        // Dispatch import job to queue
        ProcessImport::dispatch($type, $fields, $filePath);
        
        return redirect()->route('dashboard')
            ->with('success', 'Import is being processed in the background. You will be notified when it is completed.');
    }
    
    /**
     * Get the fields for a specific type.
     *
     * @param  string  $type
     * @return array
     */
    /**
     * Get a sample template for import.
     *
     * @param  string  $type
     * @param  string  $format
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getSampleTemplate($type, $format)
    {
        $fields = $this->getFieldsForType($type);
        $headers = array_values($fields);
        $data = [];
        
        // Add sample data based on type
        if ($type === 'users') {
            $data[] = ['John Doe', 'john@example.com', 1, 1, now()->format('Y-m-d H:i:s')];
            $data[] = ['Jane Smith', 'jane@example.com', 2, 1, now()->format('Y-m-d H:i:s')];
        } elseif ($type === 'products') {
            $data[] = ['Sample Product 1', 1, 19.99, 100, 'Description for product 1', 1, now()->format('Y-m-d H:i:s')];
            $data[] = ['Sample Product 2', 2, 29.99, 50, 'Description for product 2', 0, now()->format('Y-m-d H:i:s')];
        } elseif ($type === 'categories') {
            $data[] = ['Electronics', 'Electronic products', 1, now()->format('Y-m-d H:i:s')];
            $data[] = ['Clothing', 'Clothing products', 1, now()->format('Y-m-d H:i:s')];
        } elseif ($type === 'reviews') {
            $data[] = [1, 1, 5, 'Great product!', 'This product exceeded my expectations.', 'John Doe', 'john@example.com', 'approved', now()->format('Y-m-d H:i:s')];
            $data[] = [2, 2, 4, 'Good value', 'Good product for the price.', 'Jane Smith', 'jane@example.com', 'approved', now()->format('Y-m-d H:i:s')];
        } elseif ($type === 'roles') {
            $data[] = ['Administrator', 'Full access to all features', 1, now()->format('Y-m-d H:i:s')];
            $data[] = ['Editor', 'Can edit content but not settings', 1, now()->format('Y-m-d H:i:s')];
        }
        
        // Create a temporary file
        $fileName = $type . '_template.' . $format;
        $tempFile = storage_path('app/public/exports/' . $fileName);
        
        // Ensure the directory exists
        if (!file_exists(dirname($tempFile))) {
            mkdir(dirname($tempFile), 0755, true);
        }
        
        // Generate the file based on format
        if ($format === 'csv') {
            $file = fopen($tempFile, 'w');
            fputcsv($file, $headers);
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        } elseif ($format === 'xlsx') {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Add headers
            foreach ($headers as $colIndex => $header) {
                $sheet->setCellValueByColumnAndRow($colIndex + 1, 1, $header);
            }
            
            // Add data
            foreach ($data as $rowIndex => $rowData) {
                foreach ($rowData as $colIndex => $value) {
                    $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
                }
            }
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($tempFile);
        }
        
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
    
    /**
     * Download the import error log.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadImportLog($id)
    {
        // In a real application, you would fetch the import log from the database
        // For this example, we'll create a sample error log file
        $logFile = storage_path('app/public/imports/logs/import_' . $id . '_errors.csv');
        
        // Ensure the directory exists
        if (!file_exists(dirname($logFile))) {
            mkdir(dirname($logFile), 0755, true);
        }
        
        // Create a sample error log if it doesn't exist
        if (!file_exists($logFile)) {
            $file = fopen($logFile, 'w');
            fputcsv($file, ['Row', 'Column', 'Error']);
            fputcsv($file, [2, 'email', 'The email format is invalid.']);
            fputcsv($file, [3, 'price', 'The price must be a number.']);
            fclose($file);
        }
        
        return response()->download($logFile, 'import_errors.csv');
    }

    private function getFieldsForType($type)
    {
        switch ($type) {
            case 'roles':
                return [
                    'id' => 'ID',
                    'uuid' => 'UUID',
                    'name' => 'Name',
                    'description' => 'Description',
                    'is_active' => 'Active Status',
                    'permissions' => 'Permissions',
                    'last_used_at' => 'Last Used At',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ];
            case 'users':
                return [
                    'id' => 'ID',
                    'uuid' => 'UUID',
                    'name' => 'Name',
                    'email' => 'Email',
                    'role_id' => 'Role ID',
                    'is_active' => 'Active Status',
                    'preferences' => 'Preferences',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ];
            case 'categories':
                return [
                    'id' => 'ID',
                    'uuid' => 'UUID',
                    'name' => 'Name',
                    'description' => 'Description',
                    'is_active' => 'Active Status',
                    'metadata' => 'Metadata',
                    'published_at' => 'Published At',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ];
            case 'products':
                return [
                    'id' => 'ID',
                    'uuid' => 'UUID',
                    'category_id' => 'Category ID',
                    'name' => 'Name',
                    'description' => 'Description',
                    'price' => 'Price',
                    'stock' => 'Stock',
                    'is_featured' => 'Featured Status',
                    'specifications' => 'Specifications',
                    'available_from' => 'Available From',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ];
            case 'reviews':
                return [
                    'id' => 'ID',
                    'uuid' => 'UUID',
                    'product_id' => 'Product ID',
                    'user_id' => 'User ID',
                    'title' => 'Title',
                    'content' => 'Content',
                    'rating' => 'Rating',
                    'is_verified' => 'Verified Status',
                    'additional_data' => 'Additional Data',
                    'verified_at' => 'Verified At',
                    'created_at' => 'Created At',
                    'updated_at' => 'Updated At',
                ];
            default:
                return [];
        }
    }
}
