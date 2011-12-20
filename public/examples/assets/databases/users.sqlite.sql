--
-- Table structure for table users
--
DROP TABLE IF EXISTS 'users';
CREATE TABLE IF NOT EXISTS 'users' (
  id INTEGER PRIMARY KEY,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  email TEXT NOT NULL,
  access TEXT NOT NULL
);

--
-- Dumping data for table users
--
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test1', 'password1', 'test1@test.com', 'reader');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test2', 'password2', 'test2@test.com', 'editor');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test3', 'password3', 'test3@test.com', 'publisher');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test4', 'password4', 'test4@test.com', 'admin');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test5', 'password5', 'test5@test.com', 'reader');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test6', 'password6', 'test6@test.com', 'editor');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test7', 'password7', 'test7@test.com', 'publisher');
INSERT INTO 'users' ('username', 'password', 'email', 'access') VALUES ('test8', 'password8', 'test8@test.com', 'admin');