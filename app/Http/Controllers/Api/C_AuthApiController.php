<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Validator;
use GuzzleHttp\client;
use App\Http\Resources\PenggunaResources;

use App\Http\Resources\UserResource;

class C_AuthApiController extends Controller
{
    public function pengguna(Request $request)
    {
        try {
            $rules = [
                // "id" => "required",
                'name' => 'required',
                'birth_year' => 'required|numeric',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'job' => 'required|exists:job',
                'skill' => 'required|array',
                'skill.*' => 'required|distinct|exists:skill',
            ];
            
            // $register = DB::pengguna('register * from pengguna where active = ?');
            $pengguna = new Pengguna(); //GuzzleHttp\Client
        $url = "https://api.github.com/users/kingsconsult/repos";


        $response = $pengguna->request('GET', $url, [
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        return view('projects.apiwithoutkey', compact('responseBody'));
////////////////////////////////////////////////////////////////////
        $pengguna = new Pengguna();
        $url = "https://dev.to/api/articles/me/published";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];

        $response = $pengguna->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        return view('projects.pengguna', compact('responseBody'));
////////////////////////////////////////////////////////////////
            return view('register.index', ['register' => $register]);
            $messages = [];

            $attributes = [
                // "id" => "required",  
                "nama" => "required",
                "birth_year" => "required",
                "email" => "required",
                "phone" => "required",
                "job" => "required",
                "skill" => "required"
            ];

            $validator = Validator::make($request->all(), $rules, $messages, $attributes);

            if ($validator->fails()) {
                $this->responseCode = 422;
                $this->responseMessage = "Silahkan isi form dengan benar terlebih dahulu";
                $this->responseData["errors"] = $validator->errors();
            } else {
                $credentials = $request->only("nama", "birth_year","email","job","skill");
                $token = auth("api")->attempt($credentials);

                if (!empty($token)) {
                    $penggunaAuth = Pengguna::find(auth("api")->pengguna());

                    if (!empty($penggunaAuth)) {
                        $this->responseCode = 200;
                        $this->responseMessage = "Pengguna berhasil login";
                        $this->responseData["pengguna"] = new PenggunaResource($penggunaAuth);
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
            $penggunaAuth = Pengguna::find(auth("api")->pengguna()->id);

            if (!empty($penggunaAuth)) {
                $this->responseCode = 200;
                $this->responseMessage = "User berhasil ditampilkan";
                $this->responseData["user"] = new PenggunaResource($penggunaAuth);
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
            $this->responseMessage = "Pengguna berhasil logout";
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
        return view('result', ['pengguna' => $request['pengguna']]);
    }
}



// ////////////////////
// public function apiWithoutKey()
//     {
//         $client = new Client(); //GuzzleHttp\Client
//         $url = "https://api.github.com/users/kingsconsult/repos";


//         $response = $client->request('GET', $url, [
//             'verify'  => false,
//         ]);

//         $responseBody = json_decode($response->getBody());

//         return view('projects.apiwithoutkey', compact('responseBody'));
//     }

//     public function apiWithKey()
//     {
//         $client = new Client();
//         $url = "https://dev.to/api/articles/me/published";

//         $params = [
//             //If you have any Params Pass here
//         ];

//         $headers = [
//             'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
//         ];

//         $response = $client->request('GET', $url, [
//             // 'json' => $params,
//             'headers' => $headers,
//             'verify'  => false,
//         ]);

//         $responseBody = json_decode($response->getBody());

//         return view('projects.apiwithkey', compact('responseBody'));
//     }