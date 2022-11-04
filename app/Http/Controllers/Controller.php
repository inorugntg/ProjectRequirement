<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\HelperPublic;
use App\Models\UserLog;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $responseCode = 200;
    protected $responseStatus = null;
    protected $responseMessage = null;
    protected $responseData = [];

    public function getResponse()
    {
        return HelperPublic::helpResponse($this->responseCode, $this->responseData, $this->responseMessage, $this->responseStatus);
    }

    public function saveLog($response)
    {
        return UserLog::saveLog($response);
    }
}
