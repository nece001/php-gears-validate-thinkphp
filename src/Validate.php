<?php

namespace Nece\Gears\Validate\ThinkPHP;

use Nece\Gears\IValidate;
use think\exception\ValidateException;
use think\Validate as ThinkValidate;

class Validate implements IValidate
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
            throw new Validate($e->getMessage(), $e->getCode());
        }
    }
}
