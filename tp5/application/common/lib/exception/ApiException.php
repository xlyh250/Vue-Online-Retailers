<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/6
 * Time: 上午2:57
 */
namespace app\common\lib\exception;
use think\Exception;

class ApiException extends Exception {

    public $code = 0;
    public $message = '';
    public $httpCode = 500;
    /**
     * @param string $message
     * @param int $httpCode
     * @param int $code
     */
    public function __construct($code=0,$message = '', $httpCode = 500) {
        $this->message = $message;
        $this->httpCode = $httpCode;
        $this->code = $code;
    }
}