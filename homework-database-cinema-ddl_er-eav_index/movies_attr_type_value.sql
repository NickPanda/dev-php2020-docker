-- Drop table

-- DROP TABLE public.movies_attr_type_value;

CREATE TABLE public.movies_attr_type_value (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	attr_id int4 NULL,
	movie_id int4 NULL, -- Фильм
	value_text text NULL, -- Текст
	value_bool bool NULL, -- Bool
	value_date timestamp NULL, -- Дата
	value_int int4 NULL, -- Целое
	value_real float4 NULL, -- Вещественное
	CONSTRAINT movies_attr_type_value_pk PRIMARY KEY (id),
	CONSTRAINT movies_attr_type_value_fk FOREIGN KEY (movie_id) REFERENCES movies(id),
	CONSTRAINT movies_attr_type_value_fk_1 FOREIGN KEY (attr_id) REFERENCES movies_attr(id)
);

-- Column comments

COMMENT ON COLUMN public.movies_attr_type_value.movie_id IS 'Фильм';
COMMENT ON COLUMN public.movies_attr_type_value.value_text IS 'Текст';
COMMENT ON COLUMN public.movies_attr_type_value.value_bool IS 'Bool';
COMMENT ON COLUMN public.movies_attr_type_value.value_date IS 'Дата';
COMMENT ON COLUMN public.movies_attr_type_value.value_int IS 'Целое';
COMMENT ON COLUMN public.movies_attr_type_value.value_real IS 'Вещественное';

-- Permissions

ALTER TABLE public.movies_attr_type_value OWNER TO postgres;
GRANT ALL ON TABLE public.movies_attr_type_value TO postgres;
