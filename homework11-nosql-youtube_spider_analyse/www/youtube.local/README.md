# YouTube NoSQL App

Реализовано на базе Mongo DB

## Список всех доступных методов
- uri: /
- method: GET

## "Паук" для получения и сохранения данных по API YouTube.
- uri: /spider
- method: GET
- Необходимо в .env указать YOUTUBE_API_KEY

## Суммарное кол-во лайков и дизлайков всех видео на канале
- uri: /statistics-channel-videos
- method: GET

## ТОП N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков
- uri: /top-channels
- method: GET
- param: limit_n (по умолчанию 5) N каналов

## Удаление каналов из БД
- uri: /channels
- method: DELETE
