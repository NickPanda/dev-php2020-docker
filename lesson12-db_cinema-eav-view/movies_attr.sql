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
