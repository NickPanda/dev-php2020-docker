CREATE OR REPLACE VIEW public.view_marketing_data
AS SELECT m.name,
    mat.name AS typename,
    matv.value_award,
    ma.name AS att_name -- 
    -- dsd
   FROM movies m
     JOIN movies_attr_type_value matv ON matv.movie_id = m.id
     JOIN movies_attr ma ON matv.attr_id = ma.id
     JOIN movies_attr_type mat ON mat.id = ma.type_id;

-- Permissions

ALTER TABLE public.view_marketing_data OWNER TO postgres;
GRANT ALL ON TABLE public.view_marketing_data TO postgres;
