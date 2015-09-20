<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Helpers\InterfacesHelper;

class factoryReset extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {

        //Reset networks files//
        $ifHelper = new InterfacesHelper();
        $ifHelper->reset();
        //Delete Database//
        \Artisan::call('migrate:refresh');
        //Reboot

    }
}
