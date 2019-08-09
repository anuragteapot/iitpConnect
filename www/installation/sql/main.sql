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
  address varchar(100) NOT NULL DEFAULT '',
  institute varchar(100) NOT NULL DEFAULT '',
  phonenumber varchar(15) NOT NULL DEFAULT 0,
  followers int(11) NOT NULL DEFAULT 0,
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
  ukid int(10) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  token varchar(255) NOT NULL,
  ip varchar(255) NOT NULL,
  isLoggedIn int(1) DEFAULT 0 NOT NULL,
  time TIMESTAMP(6) DEFAULT CURRENT_TIMESTAMP NOT NULL,
  PRIMARY KEY (ukid, uid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS posts (
  pid int(11) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  likes int(11) NOT NULL DEFAULT 0,
  shares int(11) NOT NULL DEFAULT 0,
  reports int(11) NOT NULL DEFAULT 0,
  title varchar(400) NOT NULL DEFAULT '',
  message text NOT NULL,
  type tinyint(4) NOT NULL DEFAULT 0,
  block tinyint(4) NOT NULL DEFAULT 0,
  entryDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  status tinyint(4) DEFAULT 0,
  PRIMARY KEY (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `clamed`
--

CREATE TABLE IF NOT EXISTS claim (
  cid int(11) NOT NULL AUTO_INCREMENT,
  uid int(11) NOT NULL,
  post_id int(11) NOT NULL,
  params text NOT NULL,
  claimDate datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (cid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `cabShare`
--

CREATE TABLE IF NOT EXISTS cabShare (
  cabid int(11) NOT NULL AUTO_INCREMENT,
  calendarid int(11) NOT NULL,
  uid int(11) NOT NULL,
  title varchar(400) NOT NULL DEFAULT '',
  location varchar(400) NOT NULL DEFAULT '',
  isAllday tinyint(4) NOT NULL DEFAULT 0,
  endDate varchar(100) NOT NULL DEFAULT '',
  startDate varchar(100) NOT NULL DEFAULT '',
  state varchar(50) NOT NULL DEFAULT '',
  useCreationPopup tinyint(4) NOT NULL DEFAULT 1,
  rawClass varchar(20) NOT NULL DEFAULT '',
  fullDate varchar(20) NOT NULL DEFAULT '',
  borderColor varchar(20) NOT NULL DEFAULT '',
  color varchar(20) NOT NULL DEFAULT '',
  dragBgColor varchar(20) NOT NULL DEFAULT '',
  checked tinyint(4) NOT NULL DEFAULT 0,
  category varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (cabid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS feedback (
   id int(11) AUTO_INCREMENT,
   name varchar(400) NOT NULL DEFAULT '',
   email varchar(400) NOT NULL DEFAULT '',
   message varchar(10000) NOT NULL DEFAULT '',
   PRIMARY KEY(id)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `employeeMaster`
--

CREATE TABLE IF NOT EXISTS employeeMaster (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(400) NOT NULL DEFAULT '',
  eid char(10) NOT NULL DEFAULT '',
  dept char(10) NOT NULL DEFAULT '',
  designation varchar(100) NOT NULL DEFAULT '',
  sex char(6) NOT NULL DEFAULT '',
  joiningDate datetime NOT NULL,
  cellPhone int(11) NOT NULL DEFAULT 0,
  empType char(10) NOT NULL DEFAULT '',
  PRIMARY KEY (id, eid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `holidayList`
--

CREATE TABLE IF NOT EXISTS holidayList (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(400) NOT NULL DEFAULT '',
  holidayDate datetime NOT NULL,
  type int(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `leaveType`
--

CREATE TABLE IF NOT EXISTS leaveType (
  id int(11) NOT NULL AUTO_INCREMENT,
  type char(10) NOT NULL,
  name varchar(400) NOT NULL DEFAULT '',
  maxday int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (id, type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `leaveHistory`
--

CREATE TABLE IF NOT EXISTS leaveHistory (
  leaveId int(11) NOT NULL AUTO_INCREMENT,
  empCode char(10) NOT NULL DEFAULT '',
  type char(10) NOT NULL DEFAULT '',
  dateFrom datetime NOT NULL,
  dayFrom char(10) NOT NULL DEFAULT '',
  dateUpto datetime NOT NULL,
  dayUpto char(10) NOT NULL DEFAULT '',
  sdateFrom datetime NOT NULL,
  sdayFrom char(10) NOT NULL DEFAULT '',
  sdateUpto datetime NOT NULL,
  sdayUpto char(10) NOT NULL DEFAULT '',
  numDays char(10) NOT NULL DEFAULT '',
  stationLeaveing varchar(200) NOT NULL DEFAULT '',
  applicationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  purpose varchar(200) NOT NULL DEFAULT '',
  leaveAddress varchar(200) NOT NULL DEFAULT '',
  leaveArrangement varchar(200) NOT NULL DEFAULT '',
  leaveStatus tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (leaveId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

create table Customer (
  CId int(11) primary key,
  CName varchar(100) not null,
  CEmail varchar(100) not null,
  CMobilePhone int(11) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

Create Table BusCity (
  BCId varchar(10) primary key,
  BName varchar(100) not null unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

Create Table BusType (
  BTId int(11) primary key,
  BType varchar(100) not null unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

Create Table BusInformation (
  BId varchar(10) primary key,
  BName varchar(100) not null unique,
  BNumOfSeats int(11) not null,
  BFromCity varchar(10) not null,
  BToCity varchar(10) not null,
  BPrice int(11) not null,
  BTId int(11),
  constraint Fk_BusInfo_BusType Foreign key(BTId) references BusType(BTId),
  constraint Fk_BusInfo_BusFromCity Foreign key(BFromCity) references BusCity(BCId),
  constraint Fk_BusInfo_BusToCity Foreign key(BToCity) references BusCity(BCId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

Create Table BookingDetails (
  BDId int(11) primary key,
  CId int(11),
  BId varchar(10),
  BDDateofTravel Date,
  BDFromCity varchar(10) not null,
  BDToCity varchar(10) not null,
  BDNumOfSeats int(11) not null,
  BDPrice int(11) not null,
  constraint Fk_BookingDetails_BusInformation Foreign key(BId)references BusInformation(BId),
  constraint Fk_BookingDetails_Customer Foreign key(CId)references Customer(CId),
  constraint Fk_BusDetails_BusFromCity Foreign key(BDFromCity) references BusCity(BCId),
  constraint Fk_BusDetails_BusToCity Foreign key(BDToCity) references BusCity(BCId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

Create Table BookedStatus (
  BSId int(11) primary key,
  BSAvailableSeats int(11) not null,
  BookedDate Date,
  IsAvailable int(4),
  BId varchar(10),
  constraint Fk_BookedStatus_BusInfo Foreign key(BId)references BusInformation(BId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Add foreign keys
--

-- alter table leaveHistory add foreign key (type) references leaveType(type) ON DELETE CASCADE;
alter table posts add foreign key (uid) references users(id) ON DELETE CASCADE;
alter table claim add foreign key (uid) references users(id) ON DELETE CASCADE;
alter table claim add foreign key (post_id) references posts(pid) ON DELETE CASCADE;
alter table user_keys add foreign key (uid) references users(id) ON DELETE CASCADE;

--
-- Insert into holidayList
--

insert into holidayList values (1, 'New Year\'s Day', '2019-01-01', 0);
insert into holidayList values (2, 'Guru Govind Singh\'s Birthday', '2019-01-13', 0);
insert into holidayList values (3, 'Makar Sankranti', '2019-01-14', 0);
insert into holidayList values (4, 'Pongal', '2019-01-15', 0);
insert into holidayList values (5, 'Republic Day', '2019-01-26', 1);
insert into holidayList values (6, 'Basant Panchami/Sri Panchami', '2019-02-10', 0);
insert into holidayList values (7, 'Guru Ravidas\'s Birthday', '2019-02-19', 0);
insert into holidayList values (8, 'Shivaji Jayanti', '2019-02-19', 0);
insert into holidayList values (9, 'Swami Dayananda Saraswati Jayanti', '2019-03-01', 0);
insert into holidayList values (10, 'Maha Shivaratri/Shivaratri', '2019-03-04', 1);
insert into holidayList values (11, 'Hazarat Ali\'s Birthday', '2019-03-19', 0);
insert into holidayList values (12, 'Holika Dahana', '2019-03-20', 0);
insert into holidayList values (13, 'Holi', '2019-03-21', 1);
insert into holidayList values (14, 'Chaitra Sukladi/Gudi Padava/Ugadi/Cheti Chand', '2019-04-06', 0);
insert into holidayList values (15, 'Mesadi', '2019-04-13', 0);
insert into holidayList values (16, 'Rama Navami', '2019-04-13', 1);
insert into holidayList values (17, 'Vaisakhi/Vishu', '2019-04-14', 0);
insert into holidayList values (18, 'Vaisakhadi(Bengal)/Bahag Bihu (Assam)', '2019-04-14', 0);
insert into holidayList values (19, 'Mahavir Jayanti', '2019-04-17', 1);
insert into holidayList values (20, 'Good Friday', '2019-04-19', 1);
insert into holidayList values (21, 'Easter Day', '2019-04-21', 0);
insert into holidayList values (22, 'Guru Rabindranath\'s birthday', '2019-05-09', 0);
insert into holidayList values (23, 'Buddha Purnima/Vesak', '2019-05-18', 1);
insert into holidayList values (24, 'Jamat Ul-Vida', '2019-05-31', 0);
insert into holidayList values (25, 'Idu\'l Fitr', '2019-06-05', 1);
insert into holidayList values (26, 'Rath Yatra', '2019-07-04', 0);
insert into holidayList values (27, 'Id-ul-Zuha(Bakrid)', '2019-08-12', 1);
insert into holidayList values (28, 'Independence Day', '2019-08-15', 1);
insert into holidayList values (29, 'Raksha Bandhan (Rakhi)', '2019-08-15', 0);
insert into holidayList values (30, 'Parsi New Year\'s day/Nauraj', '2019-08-17', 0);
insert into holidayList values (31, 'Janmashtarni (Vaishnav)', '2019-08-24', 1);
insert into holidayList values (32, 'Ganesh Chaturthi/Vinayaka Chaturthi', '2019-09-02', 0);
insert into holidayList values (33, 'Muharram/Ashura', '2019-09-10', 1);
insert into holidayList values (34, 'Onam', '2019-09-11', 0);
insert into holidayList values (35, 'Mahatma Gandhi Jayanti', '2019-10-02', 1);
insert into holidayList values (36, 'Dussehra', '2019-10-07', 1);
insert into holidayList values (37, 'Maharishi Valmiki\'s Birthday', '2019-10-13', 0);
insert into holidayList values (38, 'Karaka Chaturthi (Karva Chouth)', '2019-10-17', 0);
insert into holidayList values (39, 'Deepavali (South India)', '2019-10-27', 0);
insert into holidayList values (40, 'Naraka Chaturdasi', '2019-10-27', 0);
insert into holidayList values (41, 'Diwali (Deepavali)', '2019-10-27', 1);
insert into holidayList values (42, 'Govardhan Puja', '2019-10-28', 0);
insert into holidayList values (43, 'Bhai Duj', '2019-10-29', 0);
insert into holidayList values (44, 'Pratihar Sashthi or Surya Sashthi (Chhat Puja)', '2019-11-02', 0);
insert into holidayList values (45, 'Milad-un-Nabi or Id-e- Milad (birthday of Prophet Mohammad)', '2019-11-10', 1);
insert into holidayList values (46, 'Guru Nanak\'s Birthday', '2019-11-12', 1);
insert into holidayList values (47, 'Guru Teg Bahadur\'s Martyrdom Day', '2019-11-24', 0);
insert into holidayList values (48, 'Christmas Eve', '2019-12-24', 0);
insert into holidayList values (49, 'Christmas Day', '2019-12-25', 1);


--
-- Insert into holidayList
--

insert into leaveType values (1, 'SL', 'Station Leave', 0);
insert into leaveType values (2, 'CL', 'Casual Leave', 8);
insert into leaveType values (3, 'EL', 'Earned Leave', 300);
insert into leaveType values (4, 'V', 'Vacation', 60);
insert into leaveType values (5, 'ML', 'Medical Leave', 0);
insert into leaveType values (6, 'DL', 'Duty Leave', 0);
insert into leaveType values (7, 'SCL', 'Special Casual Leave', 15);
insert into leaveType values (8, 'LPW', 'Leave for Project Work', 0);
insert into leaveType values (9, '_SL', 'Sabatical Leave', 0);
insert into leaveType values (10, 'EOL', 'Extra Ordinary leave', 0);
insert into leaveType values (11, 'RH', 'Restricted Holiday', 2);
