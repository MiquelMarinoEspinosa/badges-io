<?php

namespace Interactor\Exception;

class BaseException extends \Exception
{
    /**
     * @param int $code
     *
     * @return BaseException
     */
    protected function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function code()
    {
        return $this->code;
    }

    /**
     * @param string $message
     *
     * @return BaseException
     */
    protected function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
