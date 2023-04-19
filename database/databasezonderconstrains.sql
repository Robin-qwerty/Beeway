-- ************************************** `Users`

CREATE TABLE `users`
(
 `userid`     int NOT NULL AUTO_INCREMENT,
 `schoolid`   int NOT NULL ,
 `voornaam`   varchar(55) NOT NULL ,
 `achternaam` varchar(55) NOT NULL ,
 `email`      varchar(255) NOT NULL ,
 `wachtwoord` varchar(100) NOT NULL ,
 `rol`        tinyint NOT NULL ,
 `createdat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`  int NOT NULL ,
 `updatedat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`  int NOT NULL ,
 `archive`    tinyint NOT NULL DEFAULT '0' ,
 `deletedat`  datetime NULL ,
 `deletedby`  int NULL ,

PRIMARY KEY (`userid`)
);

-- ************************************** `schoolen`

CREATE TABLE `schoolen`
(
 `schoolid`   int NOT NULL ,
 `naamschool` varchar(155) NOT NULL ,
 `createdat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`  int NOT NULL ,
 `updatedat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`  int NOT NULL ,
 `archive`    tinyint NOT NULL DEFAULT '0' ,
 `deletedat`  datetime NULL ,
 `deletedby`  int NULL ,

PRIMARY KEY (`schoolid`)
);

-- ************************************** `Vakgebied`

CREATE TABLE `vakgebied`
(
 `vakid`         int NOT NULL AUTO_INCREMENT,
 `naamvakgebied` varchar(55) NOT NULL ,
 `createdat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`     int NOT NULL ,
 `updatedat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`     int NOT NULL ,
 `archive`       tinyint NOT NULL DEFAULT '0' ,
 `deletedat`     datetime NULL ,
 `deletedby`     int NULL ,

PRIMARY KEY (`vakid`)
);

-- ************************************** `Hoofdthema`

CREATE TABLE `hoofdthema`
(
 `themaid`    int NOT NULL AUTO_INCREMENT,
 `naamthema`  varchar(55) NOT NULL ,
 `periode`    int(2) NOT NULL ,
 `schooljaar` varchar(10) NOT NULL ,
 `createdat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`  int NOT NULL ,
 `updatedat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`  int NOT NULL ,
 `archive`    tinyint NOT NULL DEFAULT '0' ,
 `deletedat`  datetime NULL ,
 `deletedby`  int NULL ,

PRIMARY KEY (`themaid`)
);

-- ************************************** `Klassen`

CREATE TABLE `groepen`
(
 `groepenid` int NOT NULL ,
 `groepen`   varchar(3) NOT NULL ,
 `createdat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`  int NOT NULL ,
 `updatedat`  datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`  int NOT NULL ,
 `archive`    tinyint NOT NULL DEFAULT '0' ,
 `deletedat`  datetime NULL ,
 `deletedby`  int NULL ,

PRIMARY KEY (`groepenid`)
);

-- ************************************** `Beeway`

CREATE TABLE `beeway`
(
 `beewayid`      int NOT NULL AUTO_INCREMENT ,
 `groepen`       varchar(9) NOT NULL ,
 `beewaynaam`    varchar(155) NOT NULL ,
 `begoed`        int(3) NULL ,
 `bevoldoende`   int(3) NULL ,
 `beonvoldoende` int(3) NULL ,
 `hoofdthemaid`  int NOT NULL ,
 `vakgebiedid`   int NOT NULL ,
 `concreetdoel`  varchar(2500) NULL ,
 `createdat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`     int NOT NULL ,
 `updatedat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`     int NOT NULL ,
 `archive`       tinyint NOT NULL DEFAULT '0' ,
 `deletedat`     datetime NULL ,
 `deletedby`     int NULL ,
 `locked`        tinyint NOT NULL DEFAULT '0' ,

PRIMARY KEY (`beewayid`)
);

-- ************************************** `BeewayObservatie`

CREATE TABLE `beewayobservatie`
(
 `observatieid` int NOT NULL AUTO_INCREMENT,
 `beewayid`     int NOT NULL ,
 `datales`       varchar(2500) NULL ,
 `leerdoel`      varchar(2500) NULL ,
 `evaluatie`     varchar(2500) NULL ,
 `werkdoel`      varchar(2500) NULL ,
 `actie`         varchar(2500) NULL ,
 `createdat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`     int NOT NULL ,
 `updatedat`     datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`     int NOT NULL ,
 `archive`       tinyint NOT NULL DEFAULT '0' ,
 `deletedat`     datetime NULL ,
 `deletedby`     int NULL ,

PRIMARY KEY (`observatieid`)
);

-- ************************************** `BeewayPlanning`

CREATE TABLE `beewayplanning`
(
 `planningid`      int NOT NULL AUTO_INCREMENT,
 `beewayid`        int NOT NULL ,
 `planning`         varchar(155) NULL ,
 `planningwat`      varchar(2500) NULL ,
 `planningwie`      varchar(2500) NULL ,
 `planningdeadline` datetime NULL ,
 `planninggedaan`   tinyint NULL ,
 `createdat`        datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `createdby`        int NOT NULL ,
 `updatedat`        datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `updatedby`        int NOT NULL ,
 `archive`          tinyint NOT NULL DEFAULT '0' ,
 `deletedat`        datetime NULL ,
 `deletedBy`        int NULL ,

PRIMARY KEY (`planningid`)
);


-- ************************************** `koppelinggroepen`

CREATE TABLE `koppelinggroepen`
(
 `beewayid`  int NOT NULL ,
 `groepenid` int NOT NULL
);

-- ************************************** `session`

CREATE TABLE `session`
(
 `sessionid` int NOT NULL AUTO_INCREMENT,
 `stmp`      int NOT NULL ,
 `token`     varchar(155) NOT NULL ,

PRIMARY KEY (`sessionid`)
);
