
INSERT INTO `users`
(`UserId`, `VoorNaam`, `AchterNaam`, `Email`, `Wachtword`, `Rol`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `Archive`, `DeletedAt`, `DeletedBy`)
VALUES ('1', 'Robin', 'Hollaar', 'test@test.nl', 'qwerty', '1', '2023-03-27 10:15:34', '1', '2023-03-27 10:15:34', '1', '0', NULL, NULL)

INSERT INTO `vakgebied`
(`VakId`, `NaamVakgebied`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `Archive`, `DeletedAt`, `DeletedBy`)
VALUES ('1', 'rekenen', '2023-03-27 10:16:38', '1', '2023-03-27 10:16:38', '1', '0', NULL, NULL)

INSERT INTO `hoofdthema`
(`ThemaId`, `NaamThema`, `Periode`, `Schooljaar`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `Archive`, `DeletedAt`, `DeletedBy`)
VALUES ('1', 'rekenen', '1', '1', '2023-03-27 10:17:32', '1', '2023-03-27 10:17:32', '1', '0', NULL, NULL)

INSERT INTO `klassen`
(`KlasId`, `Klas`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `Archive`, `DeletedAt`, `DeletedBy`)
VALUES ('1', '4a', '2023-03-27 10:17:03', '1', '2023-03-27 10:17:03', '1', '0', NULL, NULL)

INSERT INTO `beeway`
(`BeewayId`, `WerkWeek`, `Groepen`, `BeGoed`, `BeVoldoende`, `BeOnvoldoende`, `Hoofdthema_Id`, `Vakgebied_Id`, `Concreetdoel`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `archive`, `DeletedAt`, `DeletedBy`)
VALUES ('1', NULL, NULL, NULL, NULL, NULL, '1', '1', NULL, '2023-03-27 10:18:12', '1', '2023-03-27 10:18:12', '1', '0', NULL, NULL)

INSERT INTO `beewayobservatie`
(`BObservatieId`, `Beeway_Id`, `DataLes`, `Leerdoel`, `Evaluatie`, `Werkdoel`, `Actie`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `archive`, `DeletedAt`, `DeletedBy`)
VALUES (NULL, '1', NULL, NULL, NULL, NULL, NULL, '2023-03-27 10:18:36', '1', '2023-03-27 10:18:36', '1', '0', NULL, NULL)

INSERT INTO `beewayplanning`
(`BPlanningId`, `Beeway_Id`, `Planning`, `PlanningWat`, `PlanningWie`, `PlanningDeadline`, `PlanningGedaan`, `CreatedAt`, `CreatedBy`, `UpdatedAt`, `UpdatedBy`, `archive`, `DeletedAt`, `DeletedBy`)
VALUES (NULL, '1', NULL, NULL, NULL, NULL, NULL, '2023-03-27 10:20:10', '1', '2023-03-27', '1', '0', NULL, NULL)
