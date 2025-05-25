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
        } elseif ($type === 'audits') {
            // For audits, we might want to include users for filtering
            $users = User::all();
            return view('export-import.export-form', compact('type', 'fields', 'users', 'previousExports'));
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
        
        // For immediate export (not using queue)
        if ($type === 'audits') {
            // Create export record
            $export = new \App\Models\Export([
                'type' => $type,
                'filename' => $fileName,
                'path' => $filePath,
                'status' => 'completed',
                'uuid' => Str::uuid(),
                'record_count' => \App\Models\Audit::count(),
                'format' => 'xlsx'
            ]);
            $export->save();
            
            // Generate export file
            Excel::store(new \App\Exports\AuditExport($fields), 'public/' . $filePath);
            
            return redirect()->route('export.download', $fileName)
                ->with('success', 'Your export has been generated successfully.');
        } else {
            // Dispatch export job to queue for other types
            ProcessExport::dispatch($type, $fields, $filePath);
            
            return redirect()->route('dashboard')
                ->with('success', 'Export is being processed in the background. You will be notified when it is ready for download.');
        }
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
            'import_file' => 'required|file|mimes:xlsx,xls',
            'fields' => 'required|array',
            'fields.*' => 'string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('import.form', $type)
                ->withErrors($validator)
                ->withInput();
        }
        
        $fields = $request->input('fields');
        $file = $request->file('import_file');
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
        $headers = array_keys($fields); // Use field keys as headers, not values
        $data = [];
        
        // Add sample data based on type with correct column names
        if ($type === 'users') {
            $data[] = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'role_id' => 1,
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $data[] = [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role_id' => 2,
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
        } elseif ($type === 'products') {
            $data[] = [
                'name' => 'Sample Product 1',
                'category_id' => 'Electronics', // Use category name, not ID
                'price' => 19.99,
                'stock' => 100,
                'description' => 'Description for product 1',
                'is_featured' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $data[] = [
                'name' => 'Sample Product 2',
                'category_id' => 'Clothing', // Use category name, not ID
                'price' => 29.99,
                'stock' => 50,
                'description' => 'Description for product 2',
                'is_featured' => 0,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
        } elseif ($type === 'categories') {
            $data[] = [
                'name' => 'Electronics',
                'description' => 'Electronic products',
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $data[] = [
                'name' => 'Clothing',
                'description' => 'Clothing products',
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
        } elseif ($type === 'reviews') {
            $data[] = [
                'product_id' => 'Sample Product 1', // Use product name, not ID
                'user_id' => 'john@example.com', // Use email, not ID
                'rating' => 5,
                'title' => 'Great product!',
                'content' => 'This product exceeded my expectations.',
                'is_verified' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $data[] = [
                'product_id' => 'Sample Product 2', // Use product name, not ID
                'user_id' => 'jane@example.com', // Use email, not ID
                'rating' => 4,
                'title' => 'Good value',
                'content' => 'Good product for the price.',
                'is_verified' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
        } elseif ($type === 'roles') {
            $data[] = [
                'name' => 'Administrator',
                'description' => 'Full access to all features',
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $data[] = [
                'name' => 'Editor',
                'description' => 'Can edit content but not settings',
                'is_active' => 1,
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
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
                $orderedRow = [];
                foreach ($headers as $header) {
                    $orderedRow[] = $row[$header] ?? '';
                }
                fputcsv($file, $orderedRow);
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
                $colIndex = 0;
                foreach ($headers as $header) {
                    $value = $rowData[$header] ?? '';
                    $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
                    $colIndex++;
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
            case 'audits':
                return [
                    'id' => 'ID',
                    'user_id' => 'User ID',
                    'event' => 'Event',
                    'auditable_type' => 'Model Type',
                    'auditable_id' => 'Model ID',
                    'old_values' => 'Old Values',
                    'new_values' => 'New Values',
                    'url' => 'URL',
                    'ip_address' => 'IP Address',
                    'user_agent' => 'User Agent',
                    'created_at' => 'Created At',
                ];
            default:
                return [];
        }
    }
}
