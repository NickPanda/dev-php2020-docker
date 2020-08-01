# Запросы на 1000000 записей

## Простые запросы

```sql
EXPLAIN analyse SELECT id from public.seances s where s.format = '2D';
```

```
Seq Scan on seances s  (cost=0.00..19853.00 rows=171100 width=4) (actual time=0.342..292.495 rows=166284 loops=1)
  Filter: ((format)::text = '2D'::text)
  Rows Removed by Filter: 833716
Planning Time: 0.536 ms
Execution Time: 303.239 ms
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.age_rating < 18;
```

```
Seq Scan on movies m  (cost=0.00..19853.00 rows=922200 width=4) (actual time=0.017..187.327 rows=923394 loops=1)
  Filter: (age_rating < 18)
  Rows Removed by Filter: 76606
Planning Time: 0.064 ms
Execution Time: 237.064 ms
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.duration < 120;
```

```
Seq Scan on movies m  (cost=0.00..19853.00 rows=551713 width=4) (actual time=0.014..140.114 rows=552047 loops=1)
  Filter: (duration < 120)
  Rows Removed by Filter: 447953
Planning Time: 0.071 ms
Execution Time: 164.803 ms
```

```sql
EXPLAIN analyse SELECT id, "name" from public.tariffs t where t.price < 300;
```

```
Seq Scan on tariffs t  (cost=0.00..20166.00 rows=287147 width=22) (actual time=0.364..271.665 rows=285785 loops=1)
  Filter: (price < 300)
  Rows Removed by Filter: 714215
Planning Time: 0.679 ms
Execution Time: 288.943 ms
```

## "Сложные" запросы

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
Hash Left Join  (cost=35779.12..115530.49 rows=1000000 width=114) (actual time=511.141..2449.057 rows=1000000 loops=1)
  Hash Cond: (ma.type_id = mat.id)
  ->  Hash Left Join  (cost=35750.00..82863.28 rows=1000000 width=99) (actual time=511.107..2001.609 rows=1000000 loops=1)
        Hash Cond: (matv.attr_id = ma.id)
        ->  Hash Join  (cost=35713.00..80192.01 rows=1000000 width=67) (actual time=511.055..1722.201 rows=1000000 loops=1)
              Hash Cond: (matv.movie_id = m.id)
              ->  Seq Scan on movies_attr_type_value matv  (cost=0.00..16462.00 rows=1000000 width=53) (actual time=24.387..250.890 rows=1000000 loops=1)
                    Filter: (id IS NOT NULL)
              ->  Hash  (cost=17353.00..17353.00 rows=1000000 width=22) (actual time=486.297..486.297 rows=1000000 loops=1)
                    Buckets: 65536  Batches: 16  Memory Usage: 3931kB
                    ->  Seq Scan on movies m  (cost=0.00..17353.00 rows=1000000 width=22) (actual time=0.031..196.731 rows=1000000 loops=1)
        ->  Hash  (cost=22.00..22.00 rows=1200 width=40) (actual time=0.025..0.025 rows=13 loops=1)
              Buckets: 2048  Batches: 1  Memory Usage: 18kB
              ->  Seq Scan on movies_attr ma  (cost=0.00..22.00 rows=1200 width=40) (actual time=0.012..0.014 rows=13 loops=1)
  ->  Hash  (cost=18.50..18.50 rows=850 width=68) (actual time=0.014..0.014 rows=5 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on movies_attr_type mat  (cost=0.00..18.50 rows=850 width=68) (actual time=0.008..0.008 rows=5 loops=1)
Planning Time: 0.503 ms
JIT:
  Functions: 28
  Options: Inlining false, Optimization false, Expressions true, Deforming true
  Timing: Generation 3.915 ms, Inlining 0.000 ms, Optimization 1.027 ms, Emission 22.842 ms, Total 27.784 ms
Execution Time: 2506.620 ms
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
GroupAggregate  (cost=14962.53..15186.07 rows=4706 width=86) (actual time=2940.539..3368.646 rows=319585 loops=1)
  Group Key: m.id
  ->  Sort  (cost=14962.53..14974.30 rows=4706 width=62) (actual time=2940.512..3031.489 rows=384943 loops=1)
        Sort Key: m.id
        Sort Method: external merge  Disk: 37728kB
        ->  Gather  (cost=1046.34..14675.46 rows=4706 width=62) (actual time=2.465..2482.149 rows=384943 loops=1)
              Workers Planned: 2
              Workers Launched: 2
              ->  Nested Loop  (cost=46.34..13204.86 rows=1961 width=62) (actual time=2.937..1682.094 rows=128314 loops=3)
                    ->  Hash Join  (cost=45.91..12257.91 rows=1961 width=44) (actual time=2.898..304.177 rows=128314 loops=3)
                          Hash Cond: (matv.attr_id = ma.id)
                          ->  Parallel Seq Scan on movies_attr_type_value matv  (cost=0.00..10628.67 rows=416667 width=16) (actual time=0.029..111.188 rows=333333 loops=3)
                          ->  Hash  (cost=45.84..45.84 rows=6 width=36) (actual time=0.087..0.087 rows=5 loops=3)
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                ->  Hash Join  (cost=20.68..45.84 rows=6 width=36) (actual time=0.078..0.082 rows=5 loops=3)
                                      Hash Cond: (ma.type_id = mat.id)
                                      ->  Seq Scan on movies_attr ma  (cost=0.00..22.00 rows=1200 width=40) (actual time=0.025..0.026 rows=13 loops=3)
                                      ->  Hash  (cost=20.62..20.62 rows=4 width=4) (actual time=0.030..0.030 rows=1 loops=3)
                                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                            ->  Seq Scan on movies_attr_type mat  (cost=0.00..20.62 rows=4 width=4) (actual time=0.022..0.023 rows=1 loops=3)
                                                  Filter: ((slug)::text = 'date'::text)
                                                  Rows Removed by Filter: 4
                    ->  Index Scan using movies_pk on movies m  (cost=0.42..0.48 rows=1 width=22) (actual time=0.010..0.010 rows=1 loops=384943)
                          Index Cond: (id = matv.movie_id)
Planning Time: 0.544 ms
Execution Time: 3392.217 ms
```

```sql
EXPLAIN analyse SELECT COUNT(s.id)
	FROM movies m
	JOIN seances s ON s.movie_id = m.id
	WHERE s.format = '3D' AND s."date" > CURRENT_DATE+7
	GROUP BY m.id;
```

```
Finalize GroupAggregate  (cost=33861.88..46191.52 rows=104803 width=12) (actual time=1077.623..1249.209 rows=100863 loops=1)
  Group Key: m.id
  ->  Gather Merge  (cost=33861.88..44706.81 rows=87336 width=12) (actual time=1077.616..1205.950 rows=100863 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial GroupAggregate  (cost=32861.86..33626.05 rows=43668 width=12) (actual time=957.278..979.814 rows=33621 loops=3)
              Group Key: m.id
              ->  Sort  (cost=32861.86..32971.03 rows=43668 width=8) (actual time=957.269..960.921 rows=35461 loops=3)
                    Sort Key: m.id
                    Sort Method: quicksort  Memory: 3083kB
                    Worker 0:  Sort Method: quicksort  Memory: 2998kB
                    Worker 1:  Sort Method: quicksort  Memory: 3003kB
                    ->  Parallel Hash Join  (cost=16232.18..29496.30 rows=43668 width=8) (actual time=365.743..923.468 rows=35461 loops=3)
                          Hash Cond: (m.id = s.movie_id)
                          ->  Parallel Seq Scan on movies m  (cost=0.00..11519.67 rows=416667 width=4) (actual time=0.020..184.876 rows=333333 loops=3)
                          ->  Parallel Hash  (cost=15686.33..15686.33 rows=43668 width=8) (actual time=360.243..360.244 rows=35461 loops=3)
                                Buckets: 131072  Batches: 1  Memory Usage: 5248kB
                                ->  Parallel Seq Scan on seances s  (cost=0.00..15686.33 rows=43668 width=8) (actual time=0.047..317.123 rows=35461 loops=3)
                                      Filter: (((format)::text = '3D'::text) AND (date > (CURRENT_DATE + 7)))
                                      Rows Removed by Filter: 297873
Planning Time: 0.334 ms
Execution Time: 1258.981 ms
```
