<?php

namespace App\Console\Commands;

use App\Models\PushToIPFS;
use Illuminate\Console\Command;
use Pinata\Facades\Pinata;
use Trax\XapiStore\Stores\Statements\Statement;

class PushToIPFSCommand extends Command
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

            $maxId = PushToIPFS::max('id');

            if($maxId == null) $maxId = 0;

            $statements = Statement::where('id', '>', $maxId)->get();

            foreach ($statements as $statement) {

                $data = get_object_vars($statement->data);
                $response = Pinata::pinJSONToIPFS($data);

                $pushToIPFS = new PushToIPFS();
                $pushToIPFS->statement_id = $statement->id;
                $pushToIPFS->hash = $response['IpfsHash'];
                $pushToIPFS->status = 1;
                $pushToIPFS->processed_time = date("Y-m-d H:i:s");
                $pushToIPFS->error = "";
                $pushToIPFS->save();
                $this->info($response['IpfsHash'] . " Posted");
            }

            $time = time() - $start;

            $this->info(" ($time seconds)");

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
