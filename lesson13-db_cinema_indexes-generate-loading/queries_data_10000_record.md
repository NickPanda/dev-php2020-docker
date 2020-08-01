# Запросы на 10000 записей

## Простые запросы

```sql
EXPLAIN analyse SELECT id from public.seances s where s.format = '2D';
```

```
Seq Scan on seances s  (cost=0.00..199.00 rows=1608 width=4) (actual time=0.378..11.849 rows=1608 loops=1)
  Filter: ((format)::text = '2D'::text)
  Rows Removed by Filter: 8392
Planning Time: 6.179 ms
Execution Time: 20.126 ms
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.age_rating < 18;
```

```
Seq Scan on movies m  (cost=0.00..199.00 rows=9208 width=4) (actual time=0.685..50.160 rows=9208 loops=1)
  Filter: (age_rating < 18)
  Rows Removed by Filter: 792
Planning Time: 2.954 ms
Execution Time: 99.480 ms
```

```sql
EXPLAIN analyse SELECT id from public.movies m where m.duration < 120;
```

```
Seq Scan on movies m  (cost=0.00..199.00 rows=5486 width=4) (actual time=0.458..30.369 rows=5519 loops=1)
  Filter: (duration < 120)
  Rows Removed by Filter: 4481
Planning Time: 2.694 ms
Execution Time: 57.091 ms
```

```sql
EXPLAIN analyse SELECT id, "name" from public.tariffs t where t.price < 300;
```

```
Seq Scan on tariffs t  (cost=0.00..200.00 rows=2823 width=20) (actual time=0.968..16.995 rows=2843 loops=1)
  Filter: (price < 300)
  Rows Removed by Filter: 7157
Planning Time: 1.573 ms
Execution Time: 30.607 ms
```

## "Сложные" запросы

```sql
SELECT m.name AS "Фильм",
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
Hash Left Join  (cost=377.72..931.66 rows=10000 width=106) (actual time=109.043..504.872 rows=10000 loops=1)
  Hash Cond: (ma.type_id = mat.id)
  ->  Hash Left Join  (cost=332.40..560.02 rows=10000 width=107) (actual time=108.523..385.956 rows=10000 loops=1)
        Hash Cond: (matv.attr_id = ma.id)
        ->  Hash Join  (cost=299.00..500.26 rows=10000 width=65) (actual time=107.831..279.200 rows=10000 loops=1)
              Hash Cond: (matv.movie_id = m.id)
              ->  Seq Scan on movies_attr_type_value matv  (cost=0.00..175.00 rows=10000 width=53) (actual time=0.634..61.492 rows=10000 loops=1)
                    Filter: (id IS NOT NULL)
              ->  Hash  (cost=174.00..174.00 rows=10000 width=20) (actual time=107.149..107.153 rows=10000 loops=1)
                    Buckets: 16384  Batches: 1  Memory Usage: 671kB
                    ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=20) (actual time=0.531..52.470 rows=10000 loops=1)
        ->  Hash  (cost=20.40..20.40 rows=1040 width=50) (actual time=0.664..0.668 rows=13 loops=1)
              Buckets: 2048  Batches: 1  Memory Usage: 18kB
              ->  Seq Scan on movies_attr ma  (cost=0.00..20.40 rows=1040 width=50) (actual time=0.469..0.592 rows=13 loops=1)
  ->  Hash  (cost=25.70..25.70 rows=1570 width=24) (actual time=0.489..0.493 rows=5 loops=1)
        Buckets: 2048  Batches: 1  Memory Usage: 17kB
        ->  Seq Scan on movies_attr_type mat  (cost=0.00..25.70 rows=1570 width=24) (actual time=0.415..0.443 rows=5 loops=1)
Planning Time: 7.593 ms
Execution Time: 555.255 ms
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
GroupAggregate  (cost=267.53..267.82 rows=6 width=84) (actual time=247.079..310.163 rows=3133 loops=1)
  Group Key: m.id
  ->  Sort  (cost=267.53..267.55 rows=6 width=70) (actual time=247.044..267.636 rows=3775 loops=1)
        Sort Key: m.id
        Sort Method: quicksort  Memory: 627kB
        ->  Nested Loop  (cost=53.08..267.46 rows=6 width=70) (actual time=3.220..224.856 rows=3775 loops=1)
              ->  Hash Join  (cost=52.79..265.39 rows=6 width=54) (actual time=3.165..125.869 rows=3775 loops=1)
                    Hash Cond: (matv.attr_id = ma.id)
                    ->  Seq Scan on movies_attr_type_value matv  (cost=0.00..175.00 rows=10000 width=16) (actual time=1.116..54.931 rows=10000 loops=1)
                    ->  Hash  (cost=52.78..52.78 rows=1 width=46) (actual time=1.972..1.976 rows=5 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Hash Join  (cost=29.64..52.78 rows=1 width=46) (actual time=1.848..1.938 rows=5 loops=1)
                                Hash Cond: (ma.type_id = mat.id)
                                ->  Seq Scan on movies_attr ma  (cost=0.00..20.40 rows=1040 width=50) (actual time=0.799..0.861 rows=13 loops=1)
                                ->  Hash  (cost=29.62..29.62 rows=1 width=4) (actual time=0.949..0.954 rows=1 loops=1)
                                      Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                      ->  Seq Scan on movies_attr_type mat  (cost=0.00..29.62 rows=1 width=4) (actual time=0.908..0.920 rows=1 loops=1)
                                            Filter: ((slug)::text = 'date'::text)
                                            Rows Removed by Filter: 4
              ->  Index Scan using movies_pk on movies m  (cost=0.29..0.34 rows=1 width=20) (actual time=0.010..0.010 rows=1 loops=3775)
                    Index Cond: (id = matv.movie_id)
Planning Time: 9.304 ms
Execution Time: 325.080 ms
```

```sql
EXPLAIN analyse SELECT COUNT(s.id)
	FROM movies m
	JOIN seances s ON s.movie_id = m.id
	WHERE s.format = '3D' AND s."date" > CURRENT_DATE+7
	GROUP BY m.id;
```

```
HashAggregate  (cost=580.79..591.00 rows=1021 width=12) (actual time=126.361..130.990 rows=955 loops=1)
  Group Key: m.id
  ->  Hash Join  (cost=299.00..575.68 rows=1021 width=8) (actual time=105.657..121.737 rows=995 loops=1)
        Hash Cond: (s.movie_id = m.id)
        ->  Seq Scan on seances s  (cost=0.00..274.00 rows=1021 width=8) (actual time=0.480..7.114 rows=995 loops=1)
              Filter: (((format)::text = '3D'::text) AND (date > (CURRENT_DATE + 7)))
              Rows Removed by Filter: 9005
        ->  Hash  (cost=174.00..174.00 rows=10000 width=4) (actual time=105.133..105.139 rows=10000 loops=1)
              Buckets: 16384  Batches: 1  Memory Usage: 480kB
              ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=4) (actual time=0.349..54.090 rows=10000 loops=1)
Planning Time: 2.257 ms
Execution Time: 135.947 ms
```
