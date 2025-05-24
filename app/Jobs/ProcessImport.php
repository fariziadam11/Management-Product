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

    /**
     * The file path for the import.
     *
     * @var string
     */
    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param  string  $type
     * @param  array  $fields
     * @param  string  $filePath
     * @return void
     */
    public function __construct($type, $fields, $filePath)
    {
        $this->type = $type;
        $this->fields = $fields;
        $this->filePath = $filePath;
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
            
            // Here you would typically send a notification to the user
            // that their import has been completed
            // Notification::send(auth()->user(), new ImportCompleted($this->type));
            
            // Clean up the imported file
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
                return new ProductImport($this->fields);
            case 'reviews':
                return new ProductReviewImport($this->fields);
            default:
                return null;
        }
    }
}
