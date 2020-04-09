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
