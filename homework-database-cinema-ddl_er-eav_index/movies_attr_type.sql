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
