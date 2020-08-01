<?php

namespace PhpDev2020HT7;

use PhpDev2020HT7\Interfaces\EmailValidateInterface;
use Dotenv\Dotenv;
use Exception;

class EmailValidate implements EmailValidateInterface
{

    /**
     * @var string
     */
    private $patternEmail;
    /**
     * @var bool
     */
    private $checkEmail;
    /**
     * @var string
     */
    private $email;
    /**
     * @var array
     */
    private $preparyData;

    /** 
     * Верификация списка email.
     * 
     * @param string $data
     * @param array $params
     *  Параметры: 
     *   format (формат)
     *   glue(разделитель, в случае если строка)
     */
    public function verifyEmailList(string $data, array $params = []): array {
       $this->prapareDataListEmail($data, $params);
       return $this->verifyArrayEmail();
    }

    /**
     * Подготовка данных со списком email для верификации.
     */
    private function prapareDataListEmail(string $data, array $extraParams = []): void
    {
        $defaultParams = [
            'format' => 'string',
            'glue' => ',',
        ];
        $params = array_merge($defaultParams,$extraParams);

        switch($params['format']) {
            case 'string':
                $this->preparyData = explode($data, $params['glue']);
                break;
            case 'json':
                $this->preparyData = json_decode($data, true);
                break;
            default: 
                throw new Exception('Передан недопустимый формат.');
        }
        if (!is_array($this->preparyData)) {
            throw new Exception('Переданы некорректные данные.');
        }
    }

    /**
     * Верификация массива email.
     * 
     * @return array
     */
    private function verifyArrayEmail(): array {

        $this->checkEnv();

        $this->patternEmail = getenv('PATTERN_EMAIL_VERIFY');

        $verRes = [];
        foreach($this->preparyData as $email) {
            $this->email = $email;
            $this->verifyEmail();
            $this->verifyMxRecord();
            $verRes[$email] = $this->checkEmail;
        }

        if(empty($verRes) || !is_array($verRes)) {
            throw new Exception('Пустые данные верификации');
        }

        return $verRes;
    }

    /**
     * Верификация email по регулярному выражению.
     * Используя $patternEmail
     * 
     * @return void
     */
    private function verifyEmail() : void {
        $this->checkEmail = (bool) preg_match($this->patternEmail, $this->email);
    }

    /**
     * Верификация DNS mx записи домена.
     * 
     * @return void
     */
    private function verifyMxRecord() : void {
        if($this->checkEmail) {
            $hostname = $this->getHostnameByEmail();
            $this->checkEmail = getmxrr($hostname, $mxhosts);
        }
    }

    /**
     * Возвращает домен (hostname) почты.
     * 
     * @return string
     */
    private function getHostnameByEmail(): string {
        return substr($this->email, stripos($this->email, '@')+1);
    }

    /**
     * Проверка окружения.
     */
    private function checkEnv() {
        if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }

        (Dotenv::createImmutable(dirname(__DIR__), '/.env'))->load();

        if(!getenv('PATTERN_EMAIL_VERIFY')) {
            throw new Exception('В файле .env отсутствует "PATTERN_EMAIL_VERIFY".');
        }
    }
}
