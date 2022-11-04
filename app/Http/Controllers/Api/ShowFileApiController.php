<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use File;

class ShowFileApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $file = null;
            if ($request->category == 'candidate') {
                $file = Upload::find($request->id);
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Kategori tidak diketahui';
                // $this->saveLog($this->getResponse());
                return response()->json($this->getResponse(), $this->responseCode);
            }

            if (!empty($file)) {
                $path = storage_path('app/' . $file->path);

                if (File::exists($path)) {
                    $this->responseCode = 200;
                    $this->responseMessage = 'File ditemukan';

                    if ($file->is_image == true || $file->ext == 'pdf') {
                        if ($request->filled('preview')) {
                            if (filter_var($request->preview, FILTER_VALIDATE_BOOLEAN) == true) {
                                return response()->file($path);
                            } else {
                                return response()->download($path, $file->name);
                            }
                        } else {
                            return response()->download($path, $file->name);
                        }
                    } else {
                        return response()->download($path, $file->name);
                    }
                } else {
                    $this->responseCode = 404;
                    $this->responseMessage = 'File tidak ditemukan';
                    // $this->saveLog($this->getResponse());
                    return response()->json($this->getResponse(), $this->responseCode);
                }
            } else {
                $this->responseCode = 404;
                $this->responseMessage = 'Data tidak ditemukan';
                // $this->saveLog($this->getResponse());
                return response()->json($this->getResponse(), $this->responseCode);
            }
        } catch (\Exception $ex) {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
            // $this->saveLog($this->getResponse());
            return response()->json($this->getResponse(), $this->responseCode);
        }
    }
}
