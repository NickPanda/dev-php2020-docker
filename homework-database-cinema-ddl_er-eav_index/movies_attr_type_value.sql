-- Drop table

-- DROP TABLE public.movies_attr_type_value;

CREATE TABLE public.movies_attr_type_value (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	attr_id int4 NULL,
	movie_id int4 NULL, -- Рецензии
	value_review text NULL, -- Премии
	value_award bool NULL, -- Важные даты
	value_important_dates timestamp NULL, -- Служебные даты
	value_service_dates timestamp NULL,
	CONSTRAINT movies_attr_type_value_pk PRIMARY KEY (id),
	CONSTRAINT movies_attr_type_value_fk FOREIGN KEY (movie_id) REFERENCES movies(id),
	CONSTRAINT movies_attr_type_value_fk_1 FOREIGN KEY (attr_id) REFERENCES movies_attr(id)
);

-- Column comments

COMMENT ON COLUMN public.movies_attr_type_value.movie_id IS 'Рецензии';
COMMENT ON COLUMN public.movies_attr_type_value.value_review IS 'Премии';
COMMENT ON COLUMN public.movies_attr_type_value.value_award IS 'Важные даты';
COMMENT ON COLUMN public.movies_attr_type_value.value_important_dates IS 'Служебные даты';

-- Permissions

ALTER TABLE public.movies_attr_type_value OWNER TO postgres;
GRANT ALL ON TABLE public.movies_attr_type_value TO postgres;
