<?php

namespace App\Jobs;

use App\Imports\CategoryImport;
use App\Imports\ProductImport;
use App\Imports\ProductReviewImport;
use App\Imports\RoleImport;
use App\Imports\UserImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProcessImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The type of import.
     *
     * @var string
     */
    protected $type;

    /**
     * The fields to import.
     *
     * @var array
     */
    protected $fields;
    protected $columnMap = [];
    public $errors = [];

    /**
     * The file path for the import.
     *
     * @var string
     */
    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $type
     * @param array $fields
     * @param string $filePath
     * @param array $columnMap (optional)
     */
    public function __construct($type, $fields, $filePath, $columnMap = [])
    {
        $this->type = $type;
        $this->fields = $fields;
        $this->filePath = $filePath;
        $this->columnMap = $columnMap;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $import = $this->getImportClass();

        if ($import) {
            Excel::import($import, storage_path('app/public/' . $this->filePath));
            // Collect errors if available
            if (method_exists($import, 'getErrors')) {
                $this->errors = $import->getErrors();
                // For demonstration, log errors (in production, you may want to store or notify)
                if (!empty($this->errors)) {
                    Log::warning('Import errors for ' . $this->type . ': ' . print_r($this->errors, true));
                }
            }
            // Notification::send(auth()->user(), new ImportCompleted($this->type, $this->errors));
            Storage::disk('public')->delete($this->filePath);
        }
    }

    /**
     * Get the import class based on type.
     *
     * @return mixed
     */
    private function getImportClass()
    {
        switch ($this->type) {
            case 'roles':
                return new RoleImport($this->fields);
            case 'users':
                return new UserImport($this->fields);
            case 'categories':
                return new CategoryImport($this->fields);
            case 'products':
                return new ProductImport($this->fields, $this->columnMap);
            case 'reviews':
                return new ProductReviewImport($this->fields);
            default:
                return null;
        }
    }
}
