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
