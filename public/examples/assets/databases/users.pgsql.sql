--
-- Table structure for table users
--te
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id integer NOT NULL,
    username character varying(250) NOT NULL,
    password character varying(250) NOT NULL,
    email character varying(250) NOT NULL,
    access character varying(250) NOT NULL
);

ALTER TABLE public.users OWNER TO popuser;

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;

ALTER TABLE public.users_id_seq OWNER TO popuser;
ALTER SEQUENCE users_id_seq OWNED BY users.id;

--
-- Dumping data for table users
--
INSERT INTO users (id, username, password, email, access) VALUES
(1, 'test1', 'password1', 'test1@test.com', 'reader'),
(2, 'test2', 'password2', 'test2@test.com', 'editor'),
(3, 'test3', 'password3', 'test3@test.com', 'publisher'),
(4, 'test4', 'password4', 'test4@test.com', 'admin'),
(5, 'test5', 'password5', 'test5@test.com', 'reader'),
(6, 'test6', 'password6', 'test6@test.com', 'editor'),
(7, 'test7', 'password7', 'test7@test.com', 'publisher'),
(8, 'test8', 'password8', 'test8@test.com', 'admin');