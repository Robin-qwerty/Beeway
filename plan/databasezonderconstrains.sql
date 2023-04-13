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

PRIMARY KEY (`VakId`)
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

PRIMARY KEY (`ThemaId`)
);

-- ************************************** `Klassen`

CREATE TABLE `Klassen`
(
 `KlasId`    int NOT NULL AUTO_INCREMENT ,
 `Klas`      varchar(3) NOT NULL ,
 `CreatedAt` datetime NOT NULL ,
 `CreatedBy` int NOT NULL ,
 `UpdatedAt` datetime NOT NULL ,
 `UpdatedBy` int NOT NULL ,
 `Archive`   tinyint NOT NULL ,
 `DeletedAt` datetime NULL ,
 `DeletedBy` int NULL ,

PRIMARY KEY (`KlasId`)
);

-- ************************************** `Beeway`

CREATE TABLE `Beeway`
(
 `BeewayId`      int NOT NULL AUTO_INCREMENT ,
 `StartDatum`    datetime NULL ,
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

PRIMARY KEY (`BeewayId`)
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

PRIMARY KEY (`BObservatieId`)
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

PRIMARY KEY (`BPlanningId`)
);


-- ************************************** `Koppeling_Klassen`

CREATE TABLE `Koppeling_Klassen`
(
 `User_Id`    int NOT NULL AUTO_INCREMENT,
 `Klassen_Id` int NOT NULL ,

PRIMARY KEY (`User_Id`, `Klassen_Id`)
);
