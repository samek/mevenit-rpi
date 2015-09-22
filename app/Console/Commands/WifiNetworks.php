<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\wifi_data;



class WifiNetworks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'WifiNetworks:scan';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan for WifiNetworks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {



        $output=array();
        //Inf loop of scanning//
        $iw = shell_exec('iwlist wlan0 scan');
        if (strlen($iw)<30) {
            echo "-";
            exit(1);
        }
        ///We should have the output ...//
        $iw = explode("\n",$iw);

        $x=-1;
        foreach ($iw as $line) {
            //this should be the first line//
            if (stristr($line,"Cell ")) {
                if ($x>=0) {
                    //We need to save it//
                    $output[$x]=$iwo;
                }
                $x++;
                $iwo = new ifw();
            }
            //WPA2
            if (stristr($line,"IE: IEEE")) {
                $sec = explode("/", $line);
                $sec = explode(" ",$sec[1]);
                $sec = $sec[0];
                $iwo->sec=$sec;
            }

            //IE: WPA
            if (stristr($line,"IE: WPA")) {
                $iwo->sec="WPA";
            }
            if (stristr($line,"Quality=")) {
                $qual = explode("=",$line);
                $qual = explode('/',$qual[1]);
                $qual =round( ($qual[0]/70)*100); // in percent//
                $iwo->signal=$qual;
            }
            if (stristr($line,"ESSID:")) {
                $name = explode(":",$line);
                $name = str_replace('"',"",$name[1]);
                $iwo->name=$name;

            }
            if (stristr($line,"Encryption key")) {
                if (stristr($line,":on")) {
                    $iwo->secure=1;
                } else {
                    $iwo->secure=-1;
                }
            }
        }
        $output[$x]=$iwo;
        $json = json_encode($output);


        if (strlen($json)==0)
            exit(1);

        $c = wifi_data::where('key','=','networks')->get()->count();

        if ($c==0) {
            $wdata = new wifi_data();
            $wdata->key="networks";

        } else {
            $wdata = wifi_data::where('key','=','networks')->first();

        }
        //dd($wdata);



        $wdata->value=$json;

        $wdata->save();


        //print_r($output);
        echo  "+";

    }
}
class ifw {
    public $name="";
    public $secure="";
    public $signal;
    public $sec="";

}