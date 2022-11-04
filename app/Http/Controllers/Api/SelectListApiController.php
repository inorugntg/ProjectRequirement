<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Http\Resources\SkillResource;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;
      
class SelectListApiController extends Controller
{
    public function job(Request $request)
    {
        try {
            $job = Job::query();

            if ($request->filled('search')) {
                $job = $job->where(function ($query) use ($request) {
                    $query->orWhere('name', 'ILIKE', "%{$request->search}%");
                });
            }

            $job = $job->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data job berhasil ditampilkan';
            $this->responseData['jobs'] = JobResource::collection($job);
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        // $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function skill(Request $request)
    {
        try {
            $skill = Skill::query();

            if ($request->filled('search')) {
                $skill = $skill->where(function ($query) use ($request) {
                    $query->orWhere('name', 'ILIKE', "%{$request->search}%");
                });
            }

            $skill = $skill->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data skill berhasil ditampilkan';
            $this->responseData['skills'] = SkillResource::collection($skill);
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        // $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
