-- ************************************** `Users`

CREATE TABLE `Users`
(
 `UserId`     int NOT NULL AUTO_INCREMENT,
 `VoorNaam`   varchar(55) NOT NULL ,
 `AchterNaam` varchar(55) NOT NULL ,
 `Email`      varchar(255) NOT NULL ,
 `Wachtword`  varchar(100) NOT NULL ,
 `Rol`        tinyint NOT NULL ,
 `CreatedAt`  datetime NOT NULL ,
 `CreatedBy`  int NOT NULL ,
 `UpdatedAt`  datetime NOT NULL ,
 `UpdatedBy`  int NOT NULL ,
 `Archive`    tinyint NOT NULL ,
 `DeletedAt`  datetime NULL ,
 `DeletedBy`  int NULL ,

PRIMARY KEY (`UserId`)
);

-- ************************************** `Vakgebied`

CREATE TABLE `Vakgebied`
(
 `VakId`         int NOT NULL AUTO_INCREMENT,
 `NaamVakgebied` varchar(55) NOT NULL ,
 `CreatedAt`     datetime NOT NULL ,
 `CreatedBy`     int NOT NULL ,
 `UpdatedAt`     datetime NOT NULL ,
 `UpdatedBy`     int NOT NULL ,
 `Archive`       tinyint NOT NULL ,
 `DeletedAt`     datetime NULL ,
 `DeletedBy`     int NULL ,

PRIMARY KEY (`VakId`),
KEY `FK_2` (`CreatedBy`),
CONSTRAINT `FK_14` FOREIGN KEY `FK_2` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_3` (`UpdatedBy`),
CONSTRAINT `FK_17` FOREIGN KEY `FK_3` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_4` (`DeletedBy`),
CONSTRAINT `FK_21_1` FOREIGN KEY `FK_4` (`DeletedBy`) REFERENCES `Users` (`UserId`)
);

-- ************************************** `Hoofdthema`

CREATE TABLE `Hoofdthema`
(
 `ThemaId`    int NOT NULL AUTO_INCREMENT,
 `NaamThema`  varchar(55) NOT NULL ,
 `Periode`    int(2) NOT NULL ,
 `Schooljaar` varchar(10) NOT NULL ,
 `CreatedAt`  datetime NOT NULL ,
 `CreatedBy`  int NOT NULL ,
 `UpdatedAt`  datetime NOT NULL ,
 `UpdatedBy`  int NOT NULL ,
 `Archive`    tinyint NOT NULL ,
 `DeletedAt`  datetime NULL ,
 `DeletedBy`  int NULL ,

PRIMARY KEY (`ThemaId`),
KEY `FK_2` (`CreatedBy`),
CONSTRAINT `FK_13` FOREIGN KEY `FK_2` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_3` (`UpdatedBy`),
CONSTRAINT `FK_18` FOREIGN KEY `FK_3` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_4` (`DeletedBy`),
CONSTRAINT `FK_20` FOREIGN KEY `FK_4` (`DeletedBy`) REFERENCES `Users` (`UserId`)
);

-- ************************************** `Klassen`

CREATE TABLE `Klassen`
(
 `KlasId`    int NOT NULL AUTO_INCREMENT,
 `Klas`      varchar(3) NOT NULL ,
 `CreatedAt` datetime NOT NULL ,
 `CreatedBy` int NOT NULL ,
 `UpdatedAt` datetime NOT NULL ,
 `UpdatedBy` int NOT NULL ,
 `Archive`   tinyint NOT NULL ,
 `DeletedAt` datetime NULL ,
 `DeletedBy` int NULL ,

PRIMARY KEY (`KlasId`),
KEY `FK_2` (`CreatedBy`),
CONSTRAINT `FK_15` FOREIGN KEY `FK_2` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_3` (`UpdatedBy`),
CONSTRAINT `FK_19` FOREIGN KEY `FK_3` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_4` (`DeletedBy`),
CONSTRAINT `FK_22` FOREIGN KEY `FK_4` (`DeletedBy`) REFERENCES `Users` (`UserId`)
);

-- ************************************** `Beeway`

CREATE TABLE `Beeway`
(
 `BeewayId`      int NOT NULL AUTO_INCREMENT,
 `WerkWeek`      varchar(45) NULL ,
 `Groepen`       varchar(9) NULL ,
 `BeGoed`        int(3) NULL ,
 `BeVoldoende`   int(3) NULL ,
 `BeOnvoldoende` int(3) NULL ,
 `Hoofdthema_Id` int NULL ,
 `Vakgebied_Id`  int NULL ,
 `Concreetdoel`  varchar(2500) NULL ,
 `CreatedAt`     datetime NOT NULL ,
 `CreatedBy`     int NOT NULL ,
 `UpdatedAt`     datetime NOT NULL ,
 `UpdatedBy`     int NOT NULL ,
 `archive`       tinyint NOT NULL ,
 `DeletedAt`     datetime NULL ,
 `DeletedBy`     int NULL ,

PRIMARY KEY (`BeewayId`),
KEY `FK_2` (`Vakgebied_Id`),
CONSTRAINT `FK_1` FOREIGN KEY `FK_2` (`Vakgebied_Id`) REFERENCES `Vakgebied` (`VakId`),
KEY `FK_4` (`Hoofdthema_Id`),
CONSTRAINT `FK_5` FOREIGN KEY `FK_4` (`Hoofdthema_Id`) REFERENCES `Hoofdthema` (`ThemaId`),
KEY `FK_5` (`CreatedBy`),
CONSTRAINT `FK_8` FOREIGN KEY `FK_5` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_6` (`UpdatedBy`),
CONSTRAINT `FK_9` FOREIGN KEY `FK_6` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_7` (`DeletedBy`),
CONSTRAINT `FK_21` FOREIGN KEY `FK_7` (`DeletedBy`) REFERENCES `Users` (`UserId`)
);


-- ************************************** `BeewayObservatie`

CREATE TABLE `BeewayObservatie`
(
 `BObservatieId` int NOT NULL AUTO_INCREMENT,
 `Beeway_Id`     int NOT NULL ,
 `DataLes`       varchar(2500) NULL ,
 `Leerdoel`      varchar(2500) NULL ,
 `Evaluatie`     varchar(2500) NULL ,
 `Werkdoel`      varchar(2500) NULL ,
 `Actie`         varchar(2500) NULL ,
 `CreatedAt`     datetime NOT NULL ,
 `CreatedBy`     int NOT NULL ,
 `UpdatedAt`     datetime NOT NULL ,
 `UpdatedBy`     int NOT NULL ,
 `archive`       tinyint NOT NULL ,
 `DeletedAt`     datetime NULL ,
 `DeletedBy`     int NULL ,

PRIMARY KEY (`BObservatieId`),
KEY `FK_2` (`DeletedBy`),
CONSTRAINT `FK_3` FOREIGN KEY `FK_2` (`DeletedBy`) REFERENCES `Beeway` (`BeewayId`),
KEY `FK_3` (`CreatedBy`),
CONSTRAINT `FK_12` FOREIGN KEY `FK_3` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_4` (`UpdatedBy`),
CONSTRAINT `FK_16` FOREIGN KEY `FK_4` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_5` (`Beeway_Id`),
CONSTRAINT `FK_23` FOREIGN KEY `FK_5` (`Beeway_Id`) REFERENCES `Users` (`UserId`)
);

-- ************************************** `BeewayPlanning`

CREATE TABLE `BeewayPlanning`
(
 `BPlanningId`      int NOT NULL AUTO_INCREMENT,
 `Beeway_Id`        int NOT NULL ,
 `Planning`         varchar(155) NULL ,
 `PlanningWat`      varchar(2500) NULL ,
 `PlanningWie`      varchar(2500) NULL ,
 `PlanningDeadline` datetime NULL ,
 `PlanningGedaan`   tinyint NULL ,
 `CreatedAt`        datetime NOT NULL ,
 `CreatedBy`        int NOT NULL ,
 `UpdatedAt`        datetime NOT NULL ,
 `UpdatedBy`        int NOT NULL ,
 `archive`          tinyint NOT NULL ,
 `DeletedAt`        datetime NULL ,
 `DeletedBy`        int NULL ,

PRIMARY KEY (`BPlanningId`),
KEY `FK_2` (`Beeway_Id`),
CONSTRAINT `FK_2` FOREIGN KEY `FK_2` (`Beeway_Id`) REFERENCES `Beeway` (`BeewayId`),
KEY `FK_3` (`UpdatedBy`),
CONSTRAINT `FK_10` FOREIGN KEY `FK_3` (`UpdatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_4` (`CreatedBy`),
CONSTRAINT `FK_11` FOREIGN KEY `FK_4` (`CreatedBy`) REFERENCES `Users` (`UserId`),
KEY `FK_5` (`DeletedBy`),
CONSTRAINT `FK_24` FOREIGN KEY `FK_5` (`DeletedBy`) REFERENCES `Users` (`UserId`)
);


-- ************************************** `Koppeling_Klassen`

CREATE TABLE `Koppeling_Klassen`
(
 `User_Id`    int NOT NULL AUTO_INCREMENT,
 `Klassen_Id` int NOT NULL ,

PRIMARY KEY (`User_Id`, `Klassen_Id`),
KEY `FK_2` (`User_Id`),
CONSTRAINT `FK_6` FOREIGN KEY `FK_2` (`User_Id`) REFERENCES `Users` (`UserId`),
KEY `FK_3` (`Klassen_Id`),
CONSTRAINT `FK_7` FOREIGN KEY `FK_3` (`Klassen_Id`) REFERENCES `Klassen` (`KlasId`)
);
