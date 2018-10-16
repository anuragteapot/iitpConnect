SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(400) NOT NULL DEFAULT '',
  username varchar(150) NOT NULL DEFAULT '',
  email varchar(100) NOT NULL DEFAULT '',
  password varchar(100) NOT NULL DEFAULT '',
  block tinyint(4) NOT NULL DEFAULT 0,
  sendEmail tinyint(4) DEFAULT 0,
  admin tinyint(4) NOT NULL DEFAULT 0,
  location varchar(100) NOT NULL DEFAULT '',
  institute varchar(100) NOT NULL DEFAULT '',
  phonenumber int(11) NOT NULL DEFAULT 0,
  registerDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  lastvisitDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  params text NOT NULL,
  lastResetTime datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  resetCount int(11) NOT NULL DEFAULT 0 COMMENT 'Count of password resets since lastResetTime',
  otpKey varchar(1000) NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  otep varchar(1000) NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  requireReset tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Require user to reset password on next login',
  activation tinyint(4) DEFAULT 0,
  PRIMARY KEY (id, username, email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `user_keys`
--

CREATE TABLE IF NOT EXISTS user_keys (
  id int(10) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  token varchar(255) NOT NULL,
  series varchar(191) NOT NULL,
  time varchar(200) NOT NULL,
  PRIMARY KEY (id, uid),
  CONSTRAINT UN_series UNIQUE (series)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS posts (
  id int(11) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  title varchar(400) NOT NULL DEFAULT '',
  params text NOT NULL,
  type tinyint(4) NOT NULL DEFAULT 0,
  entryDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  status tinyint(4) DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `clamed`
--

CREATE TABLE IF NOT EXISTS claim (
  id int(11) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  post_id int(11) NOT NULL,
  params text NOT NULL,
  claimDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Add foreign keys
--

alter table posts add foreign key (uid) references users(id) ON DELETE CASCADE;
alter table claim add foreign key (uid) references users(id) ON DELETE CASCADE;
alter table claim add foreign key (post_id) references posts(id) ON DELETE CASCADE;
alter table user_keys add foreign key (uid) references users(id) ON DELETE CASCADE;
