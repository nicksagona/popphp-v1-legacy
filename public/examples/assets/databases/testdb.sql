--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `access` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `access`) VALUES
('test1', 'password1', 'test1@test.com', 'reader'),
('test2', 'password2', 'test2@test.com', 'editor'),
('test3', 'password3', 'test3@test.com', 'publisher'),
('test4', 'password4', 'test4@test.com', 'admin'),
('test5', 'password5', 'test5@test.com', 'reader'),
('test6', 'password6', 'test6@test.com', 'editor'),
('test7', 'password7', 'test7@test.com', 'publisher'),
('test8', 'password8', 'test8@test.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `user_id` int(8) NOT NULL,
  `event` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`user_id`, `event`) VALUES
(1, 'User 1 Event'),
(1, 'Another Event for User 1'),
(2, 'User 2 Event');
