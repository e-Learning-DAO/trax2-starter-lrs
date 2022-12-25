<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pinata\Facades\Pinata;

class PushToIPFS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trax:push2ipfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push statements to IPFS and record their hash.';

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
     * @return int
     */
    public function handle()
    {
        try {
            $start = time();
            //$feedback = "Pinata push will be implemented here.";

            // Test JSON.
            $json = json_decode('{"id":"dec6c8e8-310e-40dd-ba95-137badbde219","timestamp":"2022-12-21T10:00:15.550Z","actor":{"objectType":"Agent","mbox":"mailto:your.email.address@example.com"},"verb":{"id":"http:\/\/adlnet.gov\/expapi\/verbs\/attempted","display":{"und":"attempted"}},"object":{"id":"https:\/\/experienceapi.com\/activities\/sending-my-first-statement","objectType":"Activity"},"authority":{"objectType":"Agent","account":{"name":"authority","homePage":"http:\/\/traxlrs.com"}},"stored":"2022-12-21T10:00:16.3582Z","version":"1.0.0"}', true);

            $response = Pinata::pinJSONToIPFS($json);

            $time = time() - $start;

            $this->info($response['IpfsHash'] . " ($time seconds)");

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
