<?php

namespace App\Jobs;

use App\Exports\AuditExport;
use App\Exports\CategoryExport;
use App\Exports\ProductExport;
use App\Exports\ProductReviewExport;
use App\Exports\RoleExport;
use App\Exports\UserExport;
use App\Models\User;
use App\Notifications\ExportReady;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The type of export.
     *
     * @var string
     */
    protected $type;

    /**
     * The fields to export.
     *
     * @var array
     */
    protected $fields;

    /**
     * The file path for the export.
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
        $export = $this->getExportClass();

        if ($export) {
            Excel::store($export, $this->filePath, 'public');

            // Get the count of records exported
            $recordCount = 0;
            if ($this->type === 'users') {
                $recordCount = User::count();
            } elseif ($this->type === 'roles') {
                $recordCount = \App\Models\Role::count();
            } elseif ($this->type === 'categories') {
                $recordCount = \App\Models\Category::count();
            } elseif ($this->type === 'products') {
                $recordCount = \App\Models\Product::count();
            } elseif ($this->type === 'reviews') {
                $recordCount = \App\Models\ProductReview::count();
            } elseif ($this->type === 'audits') {
                $recordCount = \App\Models\Audit::count();
            }

            // Create a database entry for the export
            $exportRecord = \App\Models\Export::create([
                'type' => $this->type,
                'filename' => basename($this->filePath),
                'path' => $this->filePath,
                'user_id' => 1, // Default to admin user
                'status' => 'completed',
                'format' => pathinfo($this->filePath, PATHINFO_EXTENSION),
                'uuid' => Str::uuid(),
                'record_count' => $recordCount,
            ]);

            // Send notification to the user
            // Since we're in a queue job, we can't rely on auth() helper
            // We need to pass the user ID to the job when it's dispatched
            // For now, we'll use user ID 1 (admin)
            $user = User::find(1);
            if ($user) {
                $user->notify(new ExportReady($this->filePath, $this->type));
            }
        }
    }

    /**
     * Get the export class based on type.
     *
     * @return mixed
     */
    private function getExportClass()
    {
        switch ($this->type) {
            case 'roles':
                return new RoleExport($this->fields);
            case 'users':
                return new UserExport($this->fields);
            case 'categories':
                return new CategoryExport($this->fields);
            case 'products':
                return new ProductExport($this->fields);
            case 'reviews':
                return new ProductReviewExport($this->fields);
            case 'audits':
                return new AuditExport($this->fields);
            default:
                return null;
        }
    }
}
