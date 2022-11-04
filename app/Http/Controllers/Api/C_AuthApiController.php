<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

use App\Http\Resources\UserResource;

class C_AuthApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $rules = [
                "id" => "required",
                "nama" => "required",
                "date" => "required",
                "gmail" => "required",
                "jobs" => "required",
                "skill" => "required"
            ];

            $messages = [];

            $attributes = [
                "id" => "required",
                "nama" => "required",
                "date" => "required",
                "egmail" => "required",
                "job" => "required",
                "skill" => "required"
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = "Silahkan isi form dengan benar terlebih dahulu";
                $this->responseData["errors"] = $validator->errors();
            } else {
                $credentials = $request->only("id", "nama", "date", "gmail", "job", "skill");
                $token = auth("api")->attempt($credentials);

                if (!empty($token)) {
                    $userAuth = User::find(auth("api")->user()->id);

                    if (!empty($userAuth)) {
                        $this->responseCode = 200;
                        $this->responseMessage = "User berhasil login";
                        $this->responseData["user"] = new UserResource($userAuth);
                        $this->responseData["token"] = $this->respondWithToken($token);
                    } else {
                        auth("api")->invalidate();
                        $this->responseCode = 404;
                        $this->responseMessage = "User tidak ditemukan";
                    }
                } else {
                    $this->responseCode = 404;
                    $this->responseMessage = "User tidak ditemukan";
                }
            }
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function me()
    {
        try {
            $userAuth = User::find(auth("api")->user()->id);

            if (!empty($userAuth)) {
                $this->responseCode = 200;
                $this->responseMessage = "User berhasil ditampilkan";
                $this->responseData["user"] = new UserResource($userAuth);
            } else {
                $this->responseCode = 404;
                $this->responseMessage = "User tidak ditemukan";
            }
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function logout()
    {
        try {
            auth("api")->invalidate();
            $this->responseCode = 200;
            $this->responseMessage = "User berhasil logout";
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function refresh()
    {
        try {
            $this->responseCode = 200;
            $this->responseMessage = "Refresh Token berhasil di generate";
            $this->responseData["refresh_token"] = $this->respondWithToken(auth("api")->refresh());
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function checkTokenIsValid()
    {
        try {
            $this->responseCode = 200;
            $this->responseMessage = "User berhasil ditampilkan";
            $this->responseData["token_valid"] = auth("api")->check();
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        $this->saveLog($this->getResponse());
        return response()->json($this->getResponse(), $this->responseCode);
    }

    protected function respondWithToken($token)
    {
        return [
            "access_token" => $token,
            "token_type" => "bearer",
            "expires_in" => auth("api")->factory()->getTTL() * 60,
        ];
    }
}
