<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use App\Http\Resources\UploadResource;
use App\Models\Candidate;
use App\Models\Upload;
use Illuminate\Http\Request;
use DB;
use Validator;

class RecruitmentApiController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:candidates,email',
                'phone' => 'required|numeric|unique:candidates,phone',
                'birth_year' => 'required|numeric',
                'job_id' => 'required|numeric|exists:jobs,id',
                'skill_id' => 'required|array|min:1',
                'skill_id.*' => 'required|numeric|distinct|exists:skills,id',
            ];

            $messages = [];

            $attributes = [
                'name' => 'Nama',
                'email' => 'Email',
                'phone' => 'Telepon',
                'birth_year' => 'Tahun Lahir',
                'job_id' => 'Jabatan',
                'skill_id' => 'List Skill',
                'skill_id.*' => 'Skill'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            } else {
                $candidate = new Candidate();
                $candidate->name = $request->name;
                $candidate->email = $request->email;
                $candidate->phone = $request->phone;
                $candidate->birth_year = $request->birth_year;
                $candidate->job_id = $request->job_id;
                $candidate->save();

                $candidate->skills()->sync($request->skill_id);

                $this->responseCode = 200;
                $this->responseMessage = 'Data kandidat berhasil disimpan';
                $this->responseData['candidate'] = (!empty($candidate)) ? new CandidateResource($candidate->load(['job', 'skills'])) : null;
                DB::commit();
            }
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        // $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function uploadFile(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'candidate_id' => 'required|numeric|exists:candidates,id',
                'file' => 'required|array|min:1',
                'file.*' => 'required|file|mimes:pdf,jpg,jpeg,png'
            ];

            $messages = [];

            $attributes = [
                'candidate_id' => 'Kandidat',
                'file' => 'List Berkas Lamaran',
                'file.*' => 'Berkas Lamaran'
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
                $this->responseData['errors'] = $validator->errors();
                DB::rollBack();
            } else {
                foreach ($request->file as $key => $value) {
                    $changedName = time() . random_int(100, 999) . $value->getClientOriginalName();

                    $is_image = false;
                    if (substr($value->getClientMimeType(), 0, 5) == 'image') {
                        $is_image = true;
                    }

                    $path = 'candidate/' . $request->candidate_id;
                    $value->storeAs($path, $changedName);

                    $upload = new Upload();
                    $upload->candidate_id = $request->candidate_id;
                    $upload->name = $value->getClientOriginalName();
                    $upload->path = $path . '/' . $changedName;
                    $upload->size = $value->getSize();
                    $upload->ext = $value->getClientOriginalExtension();
                    $upload->is_image = $is_image;
                    $upload->save();
                }

                $upload = Upload::where('candidate_id', $request->candidate_id)->get();

                $this->responseCode = 200;
                $this->responseMessage = 'File berhasil diupload';
                $this->responseData['files'] = UploadResource::collection($upload);
                DB::commit();
            }
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            DB::rollBack();
        }
        // $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
