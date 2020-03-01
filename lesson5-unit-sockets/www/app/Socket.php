<?php

namespace App;

use Exception;
use RuntimeException;

/**
 * Класс Socket
 * 
 * @package App
 */
class Socket
{
    private $socket;
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Создание сокета.
     * 
     * @return void
     * 
     * @throws Exception
     */
    public function create(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new Exception('Не удалось создать сокет AF_UNIX');
        }

        $this->socket = $socket;
    }


    /**
     * Привязка имени к сокету.
     * 
     * @return void
     * 
     * @throws Exception
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->filePath))
            throw new Exception('Не удалось привязаться к ' . $this->filePath);
    }

    /**
     * Установка блокирующего режима на ресурсе сокета.
     * 
     * @return void
     * 
     * @throws RuntimeException
     */
    public function block(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException("Не удалось установить блокирующий режим на ресурсе сокета.");
        }
    }

    /**
     * Получение данные из сокета.
     * 
     * @return string
     */
    public function receive(): string
    {
        $data = '';
        $from = '';

        if (socket_recvfrom($this->socket, $buf, 65536, MSG_WAITALL, $from) === false) {
            throw new RuntimeException('Ошибка при получении данных из сокета.');
        }
        return "{$buf}";
    }

    /**
     * Снятие блокировки сокета.
     * 
     * @return void
     */
    public function unblock(): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Не удалось снять блокировку сокета');
        }
    }

    /**
     * Отправка сообщения в сокет.
     * 
     * @param string $data
     * @param string $address
     * 
     * @return void
     */
    public function send(string $data, string $address): void
    {
        $len = strlen($data);
        $bytesSent = socket_sendto($this->socket, $data, $len, MSG_WAITALL, $address);
        if ($bytesSent === false) {
            throw new RuntimeException('При отправке данных в сокет возникла ошибка.');
        } elseif ($bytesSent != $len) {
            throw new RuntimeException($bytesSent . ' байт отправлено, ожидается ' . $len . ' байт');
        }
    }

    /**
     * Закрытие ресурса сокета.
     * 
     * @return void
     */
    public function close(): void
    {
        socket_close($this->socket);
        unlink($this->filePath);
    }
}
