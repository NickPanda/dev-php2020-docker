<?php

namespace App\Controller;

use App\Database\RedisDB;
use App\Message\ResponseMessage;
use App\Repositories\EventRepository;
use JsonException;
use Klein\Request;

class EventController
{

    /**
     * Выборка наиболее подходящего событие по params.
     * 
     * @param Request $request
     * 
     * @return null
     */
    public function itemByParams(Request $request)
    {
        $eventsRepository = new EventRepository(new RedisDB());

        try {
            $event = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }
        $params = $event['params'];

        $event = $eventsRepository->find($params);

        try {
            return ResponseMessage::success(json_encode($event, JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }

    }

    /**
     * Добавления события в систему. 
     * 
     * @param Request $request
     * 
     * @return null
     */
    public function add(Request $request)
    {
        try {
            $event = json_decode($request->body(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }

        $eventsRepository = new EventRepository(new RedisDB());

        $key ='events:'. md5(uniqid('', true));

        try {
            $result = $eventsRepository->save($key, [json_encode($event, JSON_THROW_ON_ERROR)]);
        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }

        try {
            if (!$result) {
                return ResponseMessage::success(json_encode(['message' => 'Событие существует!',], JSON_THROW_ON_ERROR));
            }
            return ResponseMessage::success(json_encode(['message' => 'Событие добавлено!',], JSON_THROW_ON_ERROR));

        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }
    }

    /**
     * Очистка всех доступны событий.
     * 
     * @return null
     */
    public function deleteAll()
    {
        $eventsRepository = new EventRepository(new RedisDB());

        $eventsRepository->deleteAll();

        try {
            return ResponseMessage::success(json_encode(['message' => 'События очищены!',], JSON_THROW_ON_ERROR));
        } catch (JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }
    }
}