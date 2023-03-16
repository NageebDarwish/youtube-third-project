<?php

namespace App\Traits;

trait HttpResponses {
    protected function sucess($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Reqest Was Succesful',
            'message' => $message,
            'data' => $data,
        ],$code);
    }
    protected function error($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Error Has Occurred',
            'message' => $message,
            'data' => $data,
        ],$code);
    }
}
