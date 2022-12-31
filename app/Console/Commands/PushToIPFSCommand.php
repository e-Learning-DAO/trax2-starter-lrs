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

            $maxStatementId = PushToIPFS::max('statement_id');
            if($maxStatementId == null) $maxStatementId = 0;

            $statments = Statement::where('id', '>', $maxStatementId)->get();

            foreach ($statments as $statment) {

                $dataArr = get_object_vars($statment->data);
                $response = Pinata::pinJSONToIPFS($dataArr);

                $tableName = new PushToIPFS();
                $tableName->wallet_address = "dummy";
                $tableName->statement_id = $statment->id;
                $tableName->hash = $response['IpfsHash'];
                $tableName->status = 1;
                $tableName->processed_time = date("Y-m-d H:i:s");
                $tableName->error = "";
                $tableName->save();

                $this->info($statment->id . " [".$response['IpfsHash'] . "] => posted");
            }

            $time = time() - $start;

            $this->info("Posting completed");

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
