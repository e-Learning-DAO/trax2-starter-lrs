<?php

namespace App\Http\Controllers;

use App\Models\PushToIPFS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xAPIDataController extends Controller
{
    /**
     * getting the pending data which can be saved to Cardano.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingData(Request $request)
    {
        $walletAddress = $request->get("walletaddress");
        $limit = $request->get("limit", 10);

        $hashes = PushToIPFS::all()
        ->where("wallet_address", "=", $walletAddress)
        ->where("status", "=", 1)
        ->take($limit);
        return response()->json([
            'errorcode' => 0,
            'message' => "",
            'hashes' => $hashes
        ]);
    }

    /**
     * getting the all data which can be saved to Cardano.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllData(Request $request)
    {
        $walletAddress = $request->get("walletaddress");
        $limit = $request->get("limit", 10);

        $hashes = PushToIPFS::all()
        ->where("wallet_address", "=", $walletAddress)
        ->take($limit);
        return response()->json([
            'errorcode' => 0,
            'message' => "",
            'hashes' => $hashes
        ]);
    }

    public function saveStatus(Request $request)
    {
        $cardanoHash = $request->post("cardano_hash");
        $hashIds = json_decode($request->post("hash_ids", "[]"));
        if(trim($cardanoHash) == "")
            return response()->json(["errorcode" => 1, "message" => "Cardano Hash is needed to update the status."]);

        $hashes = PushToIPFS::all()->whereIn("id", $hashIds);
        if(count($hashes) <= 0)
            return response()->json(["errorcode" => 1, "message" => "HashIds are needed to update the status."]);

        DB::beginTransaction();
        foreach($hashes as $k=>$v) {
            $v->status = 2;
            $v->cardano_hash = $cardanoHash;
            if(!$v->save()) {
                DB::rollback();
                return response()->json(["errorcode" => 1, "message" => "Cardano Hash is needed to update the status."]);
            }
        }
        DB::commit();

        return response()->json(["errorcode" => 0, "message" => "xAPI Statments statuses are updated."]);
    }
}
