-- Drop table

-- DROP TABLE public.tariffs;

CREATE TABLE public.tariffs (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	"type" varchar NULL, -- child/adult/family/standart/vip/preferential
	price int2 NULL,
	CONSTRAINT tariffs_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tariffs IS 'Тарифы';

-- Column comments

COMMENT ON COLUMN public.tariffs."type" IS 'child/adult/family/standart/vip/preferential';

-- Permissions

ALTER TABLE public.tariffs OWNER TO postgres;
GRANT ALL ON TABLE public.tariffs TO postgres;


-- Drop table

-- DROP TABLE public.halls;

CREATE TABLE public.halls (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	CONSTRAINT halls_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.halls IS 'Залы';

-- Permissions

ALTER TABLE public.halls OWNER TO postgres;
GRANT ALL ON TABLE public.halls TO postgres;


-- Drop table

-- DROP TABLE public.movies;

CREATE TABLE public.movies (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	duration int4 NULL, -- время в минутах
	age_rating int2 NULL, -- возратсной рейтинг
	CONSTRAINT movies_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.movies IS 'Фильмы';

-- Column comments

COMMENT ON COLUMN public.movies.duration IS 'время в минутах';
COMMENT ON COLUMN public.movies.age_rating IS 'возратсной рейтинг';

-- Permissions

ALTER TABLE public.movies OWNER TO postgres;
GRANT ALL ON TABLE public.movies TO postgres;


-- Drop table

-- DROP TABLE public.places;

CREATE TABLE public.places (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	place varchar NULL,
	hall_id int4 NULL,
	CONSTRAINT places_pk PRIMARY KEY (id),
	CONSTRAINT places_fk FOREIGN KEY (hall_id) REFERENCES halls(id)
);

-- Permissions

ALTER TABLE public.places OWNER TO postgres;
GRANT ALL ON TABLE public.places TO postgres;


-- Drop table

-- DROP TABLE public.seances;

CREATE TABLE public.seances (
	movie_id int4 NULL,
	"date" timestamp NULL, -- Дата/время сеанса
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	hall_id int4 NULL,
	format varchar NULL, -- 2D/3D/IMAX 3D/IMAX 2D
	CONSTRAINT seances_pk PRIMARY KEY (id),
	CONSTRAINT seances_fk FOREIGN KEY (movie_id) REFERENCES movies(id),
	CONSTRAINT seances_fk_1 FOREIGN KEY (hall_id) REFERENCES halls(id)
);
COMMENT ON TABLE public.seances IS 'Сеансы';

-- Column comments

COMMENT ON COLUMN public.seances."date" IS 'Дата/время сеанса';
COMMENT ON COLUMN public.seances.format IS '2D/3D/IMAX 3D/IMAX 2D';

-- Permissions

ALTER TABLE public.seances OWNER TO postgres;
GRANT ALL ON TABLE public.seances TO postgres;


-- Drop table

-- DROP TABLE public.tickets;

CREATE TABLE public.tickets (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	seance_id int4 NULL,
	place_id int4 NULL,
	tariff_id int4 NULL DEFAULT 1,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_fk FOREIGN KEY (seance_id) REFERENCES seances(id),
	CONSTRAINT tickets_fk_1 FOREIGN KEY (place_id) REFERENCES places(id),
	CONSTRAINT tickets_fk_2 FOREIGN KEY (tariff_id) REFERENCES tariffs(id)
);
COMMENT ON TABLE public.tickets IS 'Билеты';

-- Permissions

ALTER TABLE public.tickets OWNER TO postgres;
GRANT ALL ON TABLE public.tickets TO postgres;


-- EAV


-- Drop table

-- DROP TABLE public.movies_attr_type;

CREATE TABLE public.movies_attr_type (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	slug varchar NULL,
	CONSTRAINT movies_attr_type_pk PRIMARY KEY (id)
);

-- Permissions

ALTER TABLE public.movies_attr_type OWNER TO postgres;
GRANT ALL ON TABLE public.movies_attr_type TO postgres;


-- Drop table

-- DROP TABLE public.movies_attr;

CREATE TABLE public.movies_attr (
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	"name" varchar NULL,
	type_id int4 NULL,
	CONSTRAINT movies_attr_pk PRIMARY KEY (id),
	CONSTRAINT movies_attr_fk FOREIGN KEY (type_id) REFERENCES movies_attr_type(id)
);

-- Permissions

ALTER TABLE public.movies_attr OWNER TO postgres;
GRANT ALL ON TABLE public.movies_attr TO postgres;


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
