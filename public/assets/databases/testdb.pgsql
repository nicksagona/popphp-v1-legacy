--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: users; Type: TABLE; Schema: public; Owner: testuser; Tablespace:
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying(250) NOT NULL,
    password character varying(250) NOT NULL,
    email character varying(250) NOT NULL,
    access character varying(250) NOT NULL
);

ALTER TABLE public.users OWNER TO testuser;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: testuser
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO testuser;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: testuser
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: events; Type: TABLE; Schema: public; Owner: testuser; Tablespace:
--

CREATE TABLE events (
    user_id integer NOT NULL,
    event character varying(250) NOT NULL
);


ALTER TABLE public.events OWNER TO testuser;

--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: testuser
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);
--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: testuser
--

COPY users (id, username, password, email, access) FROM stdin;
1	test1	password1	test1@test.com	reader
2	test2	password2	test2@test.com	editor
3	test3	password3	test3@test.com	publisher
4	test4	password4	test4@test.com	admin
5	test5	password5	test5@test.com	reader
6	test6	password6	test6@test.com	editor
7	test7	password7	test7@test.com	publisher
8	test8	password8	test8@test.com	admin
\.

--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: testuser
--

SELECT pg_catalog.setval('users_id_seq', 8, true);

--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: testuser
--

COPY events (user_id, event) FROM stdin;
1	'User 1 Event'
1	'Another Event for User 1'
2	'User 2 Event'
\.


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: testuser; Tablespace:
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: testuser
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM testuser;
GRANT ALL ON SCHEMA public TO testuser;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

