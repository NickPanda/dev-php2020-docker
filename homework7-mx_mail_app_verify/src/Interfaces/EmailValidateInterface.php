<?php

namespace PhpDev2020HT7\Interfaces;

interface EmailValidateInterface
{
    /** 
     * Верификация списка email
     * 
     * @param string $data
     * @param array $params
     *  Параметры: 
     *   format (формат)
     *   glue(разделитель, в случае если строка)
     */
    public function verifyEmailList(string $data, array $params = []): array;
}
