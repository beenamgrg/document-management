<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCSV;


class ProcessCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file_path;
    protected $file_name;


    /**
     * Create a new job instance.
     */
    public function __construct($file_path, $file_name)
    {
        $this->file_path = $file_path;
        $this->file_name = $file_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $full_file_path = public_path($this->file_path);

        
        //Import the csv file and read the contents for the json conversion
        Excel::import(new ImportCSV($this->file_name), $full_file_path);
    }
}
