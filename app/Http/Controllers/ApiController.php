<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
abstract class ApiController extends Controller {

    /**
     * @var int
     */
    protected $status = 200;
    /**
     * @var null
     */
    protected $user = null;

    /**
     *
     */
    function __construct()
    {
        $this->middleware("cors");
    }


    /**
     * @param $status
     * @return $this
     */
    protected function setStatusCode($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param $message
     * @param bool $errorNb
     * @return mixed
     */
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

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    protected function respond($data, $headers = [])
    {
        return Response::json($data, $this->status, $headers);
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function respondWithData($data)
    {

        $response = isset($data['data']) ? $data : ['data' => $data];

        return $this->respond($response);
    }

    /**
     * @param User $user
     * @param $item
     * @return bool
     */
    protected function correctlyLinked(User $user, $item)
    {
        if (!$user || !$item || !$item->user)
            return false;

        if ($user->id != $item->user->id)
            return false;

        return true;
    }
}