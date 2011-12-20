--
-- Table structure for table users
--
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id SERIAL NOT NULL,
    username character varying(250) NOT NULL,
    password character varying(250) NOT NULL,
    email character varying(250) NOT NULL,
    access character varying(250) NOT NULL
);

ALTER TABLE public.users OWNER TO popuser;

--
-- Dumping data for table users
--
INSERT INTO users (username, password, email, access) VALUES
('test1', 'password1', 'test1@test.com', 'reader'),
('test2', 'password2', 'test2@test.com', 'editor'),
('test3', 'password3', 'test3@test.com', 'publisher'),
('test4', 'password4', 'test4@test.com', 'admin'),
('test5', 'password5', 'test5@test.com', 'reader'),
('test6', 'password6', 'test6@test.com', 'editor'),
('test7', 'password7', 'test7@test.com', 'publisher'),
('test8', 'password8', 'test8@test.com', 'admin');