<?php

namespace App\Jobs;



use App\Helpers\InterfacesHelper;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class factoryReset extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
	$this->delete();

        shell_exec("/usr/bin/supervisorctl stop laravel_wifi");
        sleep(1);
        
        \Artisan::call('migrate:refresh',['--force' => true, '-n' => true]);

//        \Artisan::call('migrate:refresh',['--force' => true, '-n' => true]);

        //Reboot
        shell_exec("/sbin/reboot");
    }
}
