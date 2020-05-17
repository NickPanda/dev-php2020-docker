# Запросы на 100000 записей (у установкой индексов)

## Простые запросы

```sql
EXPLAIN analyse SELECT id from public.seances s where s.format = '2D';
```

Добавлен индекс на format

```sql
CREATE INDEX seances_format_idx ON public.seances (format);
```

```
Bitmap Heap Scan on seances s  (cost=322.32..1293.84 rows=18842 width=4) (actual time=1.247..11.307 rows=16821 loops=1)
  Recheck Cond: ((format)::text = '2D'::text)
  Heap Blocks: exact=736
  ->  Bitmap Index Scan on seances_format_idx  (cost=0.00..317.61 rows=18842 width=0) (actual time=1.150..1.150 rows=16821 loops=1)
        Index Cond: ((format)::text = '2D'::text)
Planning Time: 0.209 ms
Execution Time: 12.020 ms
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.age_rating < 18;
```

Добавлен индекс на age_rating

```sql
CREATE INDEX movies_age_rating_idx ON public.movies (age_rating);
```

```
Seq Scan on movies m  (cost=0.00..1986.00 rows=92243 width=4) (actual time=0.017..26.697 rows=92252 loops=1)
  Filter: (age_rating < 18)
  Rows Removed by Filter: 7748
Planning Time: 0.278 ms
Execution Time: 34.567 ms
```

Добавлен индекс на duration

```sql
CREATE INDEX movies_duration_idx ON public.movies USING btree (duration);
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.duration < 120;
```

```
Seq Scan on movies m  (cost=0.00..1986.00 rows=54692 width=4) (actual time=0.011..20.792 rows=55215 loops=1)
  Filter: (duration < 120)
  Rows Removed by Filter: 44785
Planning Time: 0.136 ms
Execution Time: 27.151 ms
```

Добавлен индекс на duration

```sql
CREATE INDEX tariffs_price_idx ON public.tariffs USING btree (price);
```


```sql
EXPLAIN analyse SELECT id, "name" from public.tariffs t where t.price < 300;
```

```
Seq Scan on tariffs t  (cost=0.00..2016.00 rows=28566 width=21) (actual time=0.012..20.429 rows=28627 loops=1)
  Filter: (price < 300)
  Rows Removed by Filter: 71373
Planning Time: 0.174 ms
Execution Time: 21.626 ms
```

## "Сложные" запросы

Добавлены индексы на matv.movie_id, matv.attr_id, ma.type_id

```sql
CREATE INDEX seances_date_idx ON public.seances ("date");

CREATE INDEX movies_attr_type_value_movie_id_idx ON public.movies_attr_type_value (movie_id);
CREATE INDEX movies_attr_type_value_attr_id_idx ON public.movies_attr_type_value (attr_id);
CREATE INDEX movies_attr_type_id_idx ON public.movies_attr (type_id);

```

```sql
EXPLAIN analyse SELECT m.name AS "Фильм",
    mat.name AS "Тип атрибута",
    ma.name AS "Атрибут",
        CASE
            WHEN mat.slug::text = 'text'::text THEN matv.value_text
            WHEN mat.slug::text = 'bool'::text THEN matv.value_bool::text
            WHEN mat.slug::text = 'date'::text THEN matv.value_date::text
            WHEN mat.slug::text = 'real'::text THEN matv.value_real::text
            WHEN mat.slug::text = 'int'::text THEN matv.value_int::text
            ELSE NULL::text
        END AS "Значение"
   FROM movies m
     LEFT JOIN movies_attr_type_value matv ON m.id = matv.movie_id
     LEFT JOIN movies_attr ma ON matv.attr_id = ma.id
     LEFT JOIN movies_attr_type mat ON mat.id = ma.type_id
  WHERE matv.id IS NOT null
```

```
Hash Left Join  (cost=3638.12..11614.87 rows=100000 width=113) (actual time=82.767..407.579 rows=100000 loops=1)
  Hash Cond: (ma.type_id = mat.id)
  ->  Hash Left Join  (cost=3609.00..8321.93 rows=100000 width=98) (actual time=82.724..321.822 rows=100000 loops=1)
        Hash Cond: (matv.attr_id = ma.id)
        ->  Hash Join  (cost=3572.00..8021.51 rows=100000 width=66) (actual time=82.661..291.158 rows=100000 loops=1)
              Hash Cond: (matv.movie_id = m.id)
              ->  Seq Scan on movies_attr_type_value matv  (cost=0.00..1647.00 rows=100000 width=53) (actual time=0.017..46.718 rows=100000 loops=1)
                    Filter: (id IS NOT NULL)
              ->  Hash  (cost=1736.00..1736.00 rows=100000 width=21) (actual time=82.049..82.049 rows=100000 loops=1)
                    Buckets: 65536  Batches: 2  Memory Usage: 3243kB
                    ->  Seq Scan on movies m  (cost=0.00..1736.00 rows=100000 width=21) (actual time=0.014..40.616 rows=100000 loops=1)
        ->  Hash  (cost=22.00..22.00 rows=1200 width=40) (actual time=0.025..0.025 rows=13 loops=1)
              Buckets: 2048  Batches: 1  Memory Usage: 18kB
              ->  Seq Scan on movies_attr ma  (cost=0.00..22.00 rows=1200 width=40) (actual time=0.014..0.016 rows=13 loops=1)
  ->  Hash  (cost=18.50..18.50 rows=850 width=68) (actual time=0.013..0.013 rows=5 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies_attr_type mat  (cost=0.00..18.50 rows=850 width=68) (actual time=0.007..0.008 rows=5 loops=1)
Planning Time: 1.530 ms
Execution Time: 416.772 ms
```

```sql
EXPLAIN analyse SELECT m.name AS "Фильм",
    string_agg(
        CASE
            WHEN matv.value_date::date = now()::date THEN ma.name
            ELSE NULL::character varying
        END::text, '; '::text) AS "Задачи на сегодня",
    string_agg(
        CASE
            WHEN matv.value_date::date = (now() + '20 days'::interval)::date THEN ma.name
            ELSE NULL::character varying
        END::text, '; '::text) AS "Задачи через 20 дней"
   FROM movies m
     LEFT JOIN movies_attr_type_value matv ON m.id = matv.movie_id
     LEFT JOIN movies_attr ma ON matv.attr_id = ma.id
     LEFT JOIN movies_attr_type mat ON mat.id = ma.type_id
  WHERE mat.slug::text = 'date'::text
  GROUP BY m.id;
```

```
GroupAggregate  (cost=1520.96..1543.33 rows=471 width=85) (actual time=161.680..209.547 rows=31731 loops=1)
  Group Key: m.id
  ->  Sort  (cost=1520.96..1522.14 rows=471 width=61) (actual time=161.655..168.356 rows=38279 loops=1)
        Sort Key: m.id
        Sort Method: external merge  Disk: 3752kB
        ->  Nested Loop  (cost=21.26..1500.05 rows=471 width=61) (actual time=0.067..129.601 rows=38279 loops=1)
              ->  Nested Loop  (cost=20.97..1334.97 rows=471 width=44) (actual time=0.045..22.496 rows=38279 loops=1)
                    ->  Hash Join  (cost=20.68..45.84 rows=6 width=36) (actual time=0.025..0.065 rows=5 loops=1)
                          Hash Cond: (ma.type_id = mat.id)
                          ->  Seq Scan on movies_attr ma  (cost=0.00..22.00 rows=1200 width=40) (actual time=0.006..0.020 rows=13 loops=1)
                          ->  Hash  (cost=20.62..20.62 rows=4 width=4) (actual time=0.011..0.012 rows=1 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Seq Scan on movies_attr_type mat  (cost=0.00..20.62 rows=4 width=4) (actual time=0.007..0.008 rows=1 loops=1)
                                      Filter: ((slug)::text = 'date'::text)
                                      Rows Removed by Filter: 4
                    ->  Index Scan using movies_attr_type_value_attr_id_idx on movies_attr_type_value matv  (cost=0.29..137.94 rows=7692 width=16) (actual time=0.015..3.167 rows=7656 loops=5)
                          Index Cond: (attr_id = ma.id)
              ->  Index Scan using movies_pk on movies m  (cost=0.29..0.35 rows=1 width=21) (actual time=0.002..0.002 rows=1 loops=38279)
                    Index Cond: (id = matv.movie_id)
Planning Time: 0.496 ms
Execution Time: 212.427 ms
```

Добавлен индекс на date

```sql
CREATE INDEX seances_date_idx ON public.seances ("date");
```

```sql
EXPLAIN analyse SELECT COUNT(s.id)
	FROM movies m
	JOIN seances s ON s.movie_id = m.id
	WHERE s.format = '3D' AND s."date" > CURRENT_DATE+7
	GROUP BY m.id;
```

```
HashAggregate  (cost=5887.41..5992.41 rows=10500 width=12) (actual time=85.807..88.885 rows=10066 loops=1)
  Group Key: m.id
  ->  Hash Join  (cost=3958.95..5834.91 rows=10500 width=8) (actual time=51.620..80.221 rows=10565 loops=1)
        Hash Cond: (s.movie_id = m.id)
        ->  Bitmap Heap Scan on seances s  (cost=581.95..1955.35 rows=10500 width=8) (actual time=2.402..14.077 rows=10565 loops=1)
              Recheck Cond: (date > (CURRENT_DATE + 7))
              Filter: ((format)::text = '3D'::text)
              Rows Removed by Filter: 21356
              Heap Blocks: exact=736
              ->  Bitmap Index Scan on seances_date_idx  (cost=0.00..579.32 rows=31870 width=0) (actual time=2.278..2.278 rows=31921 loops=1)
                    Index Cond: (date > (CURRENT_DATE + 7))
        ->  Hash  (cost=1736.00..1736.00 rows=100000 width=4) (actual time=48.945..48.946 rows=100000 loops=1)
              Buckets: 131072  Batches: 2  Memory Usage: 2781kB
              ->  Seq Scan on movies m  (cost=0.00..1736.00 rows=100000 width=4) (actual time=0.020..19.478 rows=100000 loops=1)
Planning Time: 1.216 ms
Execution Time: 89.804 ms
```
