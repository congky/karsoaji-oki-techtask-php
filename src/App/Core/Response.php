<?php


namespace App\App\Core;


use Symfony\Component\HttpFoundation\JsonResponse;

class Response
{

    const STATUS_OK = "OK";
    const STATUS_FAIL = "FAIL";

    public static function isOk($response, $code=200){
        return new JsonResponse([
            "code" => $code,
            "status" => self::STATUS_OK,
            "response" => $response
        ]);
    }

    public static function isFail(\Exception $ex, $code=200){
        return new JsonResponse([
            "code" => $code,
            "status" => self::STATUS_FAIL,
            "message" => $ex->getMessage()
        ]);
    }

}