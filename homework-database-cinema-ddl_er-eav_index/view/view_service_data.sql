CREATE OR REPLACE VIEW public.view_service_data
AS SELECT m.name AS "Фильм",
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