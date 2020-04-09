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
