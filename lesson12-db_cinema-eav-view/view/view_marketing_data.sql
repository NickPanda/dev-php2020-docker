CREATE OR REPLACE VIEW public.view_marketing_data
AS SELECT m.name AS "Фильм",
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
  WHERE matv.id IS NOT NULL;