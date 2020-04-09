-- Drop table

-- DROP TABLE public.clients_tickets;

CREATE TABLE public.clients_tickets (
	ticket_id int4 NULL,
	client varchar NULL,
	id int4 NOT NULL GENERATED ALWAYS AS IDENTITY,
	date_sell timestamp NULL, -- Дата продажи
	CONSTRAINT clients_tickets_pk PRIMARY KEY (id),
	CONSTRAINT clients_tickets_fk FOREIGN KEY (ticket_id) REFERENCES tickets(id)
);

-- Column comments

COMMENT ON COLUMN public.clients_tickets.date_sell IS 'Дата продажи';

-- Permissions

ALTER TABLE public.clients_tickets OWNER TO postgres;
GRANT ALL ON TABLE public.clients_tickets TO postgres;
