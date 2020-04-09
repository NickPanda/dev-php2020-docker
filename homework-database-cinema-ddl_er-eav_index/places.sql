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
