<?php

namespace App\Jobs;

use App\Models\Lelang;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LelangBerlangsungJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Lelang $lelang)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->lelang->status_lelang = 'berlangsung';
        $this->lelang->save();
    }
}
