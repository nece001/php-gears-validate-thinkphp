<?php

namespace Nece\Gears\Validate\ThinkPHP;

use Nece\Gears\IValidator;
use Nece\Gears\ValidateException as GearsValidateException;
use think\exception\ValidateException;
use think\Validate as ThinkValidate;

class Validate implements IValidator
{
    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    public function validate(array $data, array $rules, array $message = [], bool $batch = false)
    {
        $v = new ThinkValidate();
        $v->rule($rules);

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        try {
            $v->failException(true)->check($data);
        } catch (ValidateException $e) {
            throw $this->buildException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 构建异常
     *
     * @Author nece001@163.com
     * @DateTime 2023-08-27
     *
     * @param string $message
     * @param string $code
     *
     * @return GearsValidateException
     */
    public function buildException($message, $code = ''): GearsValidateException
    {
        return new GearsValidateException($message, $code);
    }
}
