<?php

namespace App;

use Exception;

/**
 * Класс Server
 * 
 * @package App
 */
class Server
{
    /**
     * Запуск сервера.
     * 
     * @return void
     * 
     * @throws Exception
     */
    public function run(): void
    {
        if (file_exists(getenv('FILE_PATH_SOCKET_SERVER'))) {
            unlink(getenv('FILE_PATH_SOCKET_SERVER'));
        }

        $socket = new Socket(getenv('FILE_PATH_SOCKET_SERVER'));

        $socket->create();

        $socket->bind();

        Message::writeStdOut('Сервер запущен!');

        while(1)
        {
            $socket->block();

            $bucket = $socket->receive();

            Message::writeStdOut('Клиент: ' . $bucket);

            $socket->unblock();

            $socket->send('Сообщение принято!', getenv('FILE_PATH_SOCKET_CLIENT'));

        }

        Message::writeStdOut('Сервер остановлен!');

        $socket->close();
    }
}
