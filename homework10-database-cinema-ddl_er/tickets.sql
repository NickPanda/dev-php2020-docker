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
