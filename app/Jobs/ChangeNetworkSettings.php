<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Repositories\NetworkRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\InterfacesHelper;



class ChangeNetworkSettings extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $ifHelper;
    protected $networkRepo;


    public function __construct()
    {
        $this->ifHelper    = new InterfacesHelper();
        $this->networkRepo = new NetworkRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //We need to update all files for all devices//
        $devices=array("eth0","wlan0");
        $wpaSuplicant ="";
        $ifacesFile = $this->ifHelper->createLocalInterfacesConfig();
        foreach ($devices as $device) {
            $data = $this->networkRepo->get($device);
            $this->ifHelper->fillData($data);
            if ($device=="wlan0") {
                $wpaSuplicant = $this->ifHelper->createWpaSupplicant();
            }

            //
            $ifacesFile.= $this->ifHelper->createInterfacesConfig();

        }

        $this->ifHelper->writeInterFaces($ifacesFile);
        $this->ifHelper->writeWpa($wpaSuplicant);
        $this->ifHelper->restart();

        //shell_exec("echo date ".$this->deviceId." >> /tmp/queue");
    }
}
