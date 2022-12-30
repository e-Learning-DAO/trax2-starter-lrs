<?php

namespace App\Http\Controllers;

use App\Models\PushToIPFS;
use Illuminate\Http\Request;

class xAPIDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingdata(Request $request)
    {
        $walletAddress = $request->get("walletaddress");

        $hashes = PushToIPFS::all()->where("wallet_address", "=", $walletAddress);
        return response()->json($hashes);
    }
}
