-- Залы
-- Очистка таблицы
TRUNCATE public.halls CASCADE;

-- Заполнение данными
INSERT INTO public.halls(id, name)
OVERRIDING SYSTEM VALUE
SELECT
    seq,
    'Зал #' || seq as name
FROM GENERATE_SERIES(1, 10000) seq;

-- Фильмы
-- Очистка таблицы
TRUNCATE public.movies CASCADE;

-- Заполнение данными
INSERT INTO public.movies (id, name, duration, age_rating)
OVERRIDING SYSTEM VALUE
SELECT
    seq,
    'Фильм #' || seq,
    FLOOR(RANDOM() * (200-20+1))+20,
    FLOOR(RANDOM() * (18-6+1))+6
    
FROM GENERATE_SERIES(1, 10000) seq;

-- Места
-- Очистка таблицы
TRUNCATE public.places CASCADE;

-- Заполнение данными
INSERT INTO public.places (id, place , hall_id)
OVERRIDING SYSTEM VALUE
SELECT
    seq,
    FLOOR(RANDOM() * (100-25+1))+25,
	FLOOR(RANDOM() * 9999 + 1)
    
FROM GENERATE_SERIES(1, 10000) seq;

-- Сеансы
-- Очистка таблицы
TRUNCATE public.seances CASCADE;

-- Заполнение данными
INSERT INTO public.seances (id, date, movie_id, hall_id, format)
OVERRIDING SYSTEM VALUE
SELECT
    seq,
    CURRENT_DATE + (RANDOM() * (10+1))::INT,
    
	FLOOR(RANDOM() * 9999 + 1),
	FLOOR(RANDOM() * 9999 + 1),	
	
	CASE (RANDOM() * 3)::INT
      WHEN 0 THEN '2D'
      WHEN 1 THEN '3D'
      WHEN 2 THEN 'IMAX 2D'
      WHEN 3 THEN 'IMAX 3D'
    END
    
FROM GENERATE_SERIES(1, 10000) seq;


-- Тарифы
-- Очистка таблицы
TRUNCATE public.tariffs CASCADE;

-- Заполнение данными
INSERT INTO public.tariffs (id, name , type, price)
OVERRIDING SYSTEM VALUE
SELECT
    seq, 
    'Тариф #' || seq,
    
	CASE (RANDOM() * 5)::INT
      WHEN 0 THEN 'child'
      WHEN 1 THEN 'adult'
      WHEN 2 THEN 'family'
      WHEN 3 THEN 'standart'
      WHEN 4 THEN 'vip'
      WHEN 5 THEN 'preferential'
    END,

    FLOOR(RANDOM() * (750-120+1))+120
    
FROM GENERATE_SERIES(1, 10000) seq;

--  Билеты
-- Очистка таблицы
TRUNCATE public.tickets CASCADE;

-- Заполнение данными
INSERT INTO public.tickets (id, seance_id, place_id, tariff_id)
OVERRIDING SYSTEM VALUE
SELECT
    seq,
    
	FLOOR(RANDOM() * 9999 + 1),
	FLOOR(RANDOM() * 9999 + 1),
	FLOOR(RANDOM() * 9999 + 1)
	
    
FROM GENERATE_SERIES(1, 10000) seq;


-- Типы атрибутов фильма
-- Очистка таблицы
TRUNCATE public.movies_attr_type CASCADE;

-- Текст
INSERT INTO public.movies_attr_type (id, name, slug)
OVERRIDING SYSTEM VALUE
VALUES (1, 'Текст','text');

-- Булевый тип
INSERT INTO public.movies_attr_type (id, name, slug)
OVERRIDING SYSTEM VALUE
VALUES (2, 'Булевый тип (1/0)','bool');

-- Дата
INSERT INTO public.movies_attr_type (id, name, slug)
OVERRIDING SYSTEM VALUE
VALUES (3, 'Дата','date');

-- Целое число
INSERT INTO public.movies_attr_type (id, name, slug)
OVERRIDING SYSTEM VALUE
VALUES (4, 'Целое','int');

-- Вещественное число
INSERT INTO public.movies_attr_type (id, name, slug)
OVERRIDING SYSTEM VALUE
VALUES (5, 'Вещественное','real');


-- Атрибуты фильма
-- Очистка таблицы
TRUNCATE public.movies_attr CASCADE;

-- Рецензии критиков
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (1, 'Рецензии критиков', 1);

-- Рецензии зрителей
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (2, 'Рецензии зрителей', 1);

-- Отзыв неизвестной киноакадемии
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (3, 'Отзыв неизвестной киноакадемии', 1);

-- Премия::Оскар
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (4, 'Премия::Оскар', 2);

-- Премия::Ника
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (5, 'Премия::Ника', 2);

-- Премия::Золотой орел
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (6, 'Премия::Золотой орел', 2);

-- Важные даты::Мировая премьера
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (7, 'Важные даты::Мировая премьера', 3);

-- Важные даты::Премьера в РФ
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (8, 'Важные даты::Премьера в РФ', 3);

-- Служебные даты::Начало продажи билетов
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (9, 'Служебные даты::Начало продажи билетов', 3);

-- Служебные даты::Запуск рекламы на ТВ
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (10, 'Служебные даты::Запуск рекламы на ТВ', 3);

-- Служебные даты::Предпоказ
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (11, 'Служебные даты::Предпоказ', 3);

-- Количество зрителей
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (12, 'Количество зрителей', 4);

-- Оценка
INSERT INTO public.movies_attr (id, name, type_id)
OVERRIDING SYSTEM VALUE
VALUES (13, 'Оценка', 5);

-- Очистка таблицы
TRUNCATE public.movies_attr_type_value CASCADE;


INSERT INTO public.movies_attr_type_value (attr_id, movie_id, value_text, value_bool, value_date, value_int, value_real)

WITH expanded AS (
    SELECT RANDOM(), seq, a.id AS attr_id, a.type_id AS attr_type_id
    FROM GENERATE_SERIES(1, 10000) seq, public.movies_attr a
), shuffled AS (
    SELECT e.*
    FROM expanded e
             INNER JOIN (
        SELECT ei.seq, MIN(ei.random) FROM expanded ei GROUP BY ei.seq
    ) em ON (e.seq = em.seq AND e.random = em.min)
    ORDER BY e.seq
)

SELECT
    s.attr_id,
    (random() * 9999 + 1)::INT,
    
    -- values
    (
        CASE (s.attr_type_id)::INT
            WHEN 1 THEN 'Текстовый блок'
            END
    ) AS val_text,
    
    (
        CASE (s.attr_type_id)::INT
            WHEN 2 THEN FLOOR(RANDOM() * 2)::int::bool
            END
    ) AS value_bool,
    
    (
        CASE (s.attr_type_id)::INT
            WHEN 3 THEN CURRENT_DATE + (RANDOM() * (500-2+1)-250)::INT
            END
    ) AS value_date,
    
    (
        CASE (s.attr_type_id)::INT
            WHEN 4 THEN FLOOR(RANDOM() * 2000)
            END
    ) AS value_int,
    
    (
       CASE (s.attr_type_id)::INT
            WHEN 5 THEN RANDOM() * 10
            END
    ) AS value_real

FROM shuffled s;
