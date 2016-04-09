<?php

namespace Domain\Service;

interface PasswordCipher
{
    /**
     * @param string $password
     *
     * @return string
     */
    public function cipher($password);
}
