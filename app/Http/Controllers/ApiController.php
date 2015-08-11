<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;

abstract class ApiController extends Controller {

    protected $status = 200;
    protected $user = null;

    protected function setStatusCode($status)
    {
        $this->status = $status;
        return $this;
    }

    protected function respondError($message, $errorNb = false)
    {
        $payload = [
            "error"=>$message,
            "code"=>$this->status
        ];

        if ($errorNb) {
            $payload['errorNb'] = $errorNb;
        }

        return $this->respond($payload);
    }

    protected function respond($data, $headers = [])
    {
        return Response::json($data, $this->status, $headers);
    }

    protected function respondWithData($data)
    {
        $response = isset($data['data']) ? $data : ['data' => $data];

        return $this->respond($response);
    }

    protected function correctlyLinked(User $user, $item)
    {
        if (!$user || !$item || !$item->user)
            return false;

        if ($user->id != $item->user->id)
            return false;

        return true;
    }
}