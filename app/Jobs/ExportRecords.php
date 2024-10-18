<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use League\Csv\Writer;
use App\User;
use Storage;
use Auth;
use App\Payment;

class ExportRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        public $jobId;
    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }
    public function handle()
    {

        
        $csv = Writer::createFromPath('php://temp', 'w+');

        $people =Payment::all();
        $p = new \App\Payment('live');
        $people=$p->get();

        $csv->insertOne(array_keys($people[0]->getAttributes()));
        foreach ($people as $person) {
            $csv->insertOne($person->toArray());
        }

        $filename = 'transaction_' . uniqid() . '.csv';
        Storage::disk('public')->put($filename, $csv->toString());
        //return Storage::path($filename);
        $exportedFilePath = $filename;
        $this->markAsComplete($exportedFilePath);

        return $this->jobId;
        
    }
    public function markAsComplete($exportedFilePath)
    {
        DB::table('admin_exported_files')->insert([
            'job_id' => $this->jobId,
            'file_path' => $exportedFilePath,
        ]);
    }
}

