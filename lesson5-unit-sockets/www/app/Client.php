<?php

namespace App;

/**
 * Класс Client
 * 
 * @package App
 */
class Client
{

    private $isConnected = true;

    /**
     * Запуск клиента.
     * 
     * @return void
     */
    public function run(): void
    {
        if (file_exists(getenv('FILE_PATH_SOCKET_CLIENT'))) {
            unlink(getenv('FILE_PATH_SOCKET_CLIENT'));
        }

        $socket = new Socket(getenv('FILE_PATH_SOCKET_CLIENT'));

        $socket->create();

        $socket->bind();

        $socket->unblock();

        Message::writeStdOut('Клиент запущен');

        Message::writeStdOut('Введите сообщение (чтобы отключиться, наберите "exit")');

        $message = $this->readInput();

        while ($this->isConnected) {

            if (empty($message)) {
                Message::writeStdOut('Сообщение не может быть пустым!');
                $message = $this->readInput();
                continue;
            }

            if($message == 'exit') {
                $this->isConnected = false;
                continue;
            }

            $socket->send($message, getenv('FILE_PATH_SOCKET_SERVER'));

            $socket->block();

            $bucket = $socket->receive();

            Message::writeStdOut('Сервер: ' . $bucket);

            $message = $this->readInput();
        }

        $socket->close();

        Message::writeStdOut('Клиент отключен');
    }

    /**
     * Получение сообщения из консоли.
     *
     * @return string
     */
    private function readInput(): string
    {
        return readline('> ');
    }
}
