CREATE TABLE `ldes` (
	`lid` varchar(5) PRIMARY KEY,
	`ldes` varchar(10),
	`xpos` int NOT NULL,
	`ypos` int NOT NULL
);

CREATE TABLE `location` (
	`lid` varchar(5) ,
	`date` date,
	`usernum` int unsigned DEFAULT 0,
	`bikenum` int unsigned DEFAULT 0,
	`transnum` int unsigned DEFAULT 0,
	PRIMARY KEY(`lid`,`date`),
	FOREIGN KEY (`lid`) REFERENCES `ldes`(`lid`)
);


CREATE TABLE `user` (
  `username` varchar(10) NOT NULL PRIMARY KEY,
  `passwd` varchar(20) NOT NULL,
  `money` int DEFAULT 0,
  `lid` varchar(5),
   FOREIGN KEY (`lid`) REFERENCES `ldes`(`lid`)
);

CREATE TABLE `type` (
  `typeid` varchar(4) NOT NULL PRIMARY KEY,
  `color` varchar(8) NOT NULL,
  `makepay` int check(`makepay`>0),
  `price` int NOT NULL check(`price`>0)
);

CREATE TABLE `bike` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `passwd` varchar(10) DEFAULT NULL,
  `flag` char(1) DEFAULT 0,
  `typeid` varchar(4)  ,
  `xpos` int DEFAULT NULL,
  `ypos` int DEFAULT NULL,
  `lid` varchar(5) ,
  FOREIGN  KEY (`typeid`) REFERENCES `type`(`typeid`),
  FOREIGN KEY (`lid`) REFERENCES `ldes`(`lid`)
);

CREATE TABLE `trans` (
  `tid` int unsigned AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(10) ,
  `bikeid` int unsigned ,
  `transfee` int unsigned NOT NULL,
  `stime` datetime DEFAULT NULL,
  `etime` datetime DEFAULT NULL,
  `sxpos` int DEFAULT NULL,
  `sypos` int DEFAULT NULL,
  `expos` int DEFAULT NULL,
  `eypos` int DEFAULT NULL,
  `lid` varchar(5) ,
  FOREIGN KEY (`username`) REFERENCES `user`(`username`),
  FOREIGN KEY (`bikeid`) REFERENCES `bike`(`id`),
  FOREIGN KEY (`lid`) REFERENCES `ldes`(`lid`)
);


CREATE TABLE `billing` (
	`bid` int unsigned  NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`username` varchar(10) ,
	`money` int,
	`btime` datetime,
	FOREIGN KEY (`username`) REFERENCES `user`(`username`)
);


