-- Drop table

-- DROP TABLE public.movies;

CREATE TABLE public.movies (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	duration int4 NULL, -- время в минутах
	age_rating int4 NULL, -- возратсной рейтинг
	CONSTRAINT movies_pk PRIMARY KEY (id)
);

-- Column comments

COMMENT ON COLUMN public.movies.duration IS 'время в минутах';
COMMENT ON COLUMN public.movies.age_rating IS 'возратсной рейтинг';

-- Permissions

ALTER TABLE public.movies OWNER TO postgres;
GRANT ALL ON TABLE public.movies TO postgres;
