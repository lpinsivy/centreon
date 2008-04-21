-- 
-- Generated le : Vendredi 17 Mars 2006 à 10:01
--

-- 
-- Contenu de la table `nagios_macro`
-- 

INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(1, '$HOSTNAME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(2, '$HOSTALIAS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(3, '$HOSTADDRESS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(4, '$HOSTSTATE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(5, '$HOSTSTATEID$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(6, '$HOSTSTATETYPE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(7, '$HOSTATTEMPT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(8, '$HOSTLATENCY$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(9, '$HOSTEXECUTIONTIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(10, '$HOSTDURATION$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(11, '$HOSTDURATIONSEC$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(12, '$HOSTDOWNTIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(13, '$HOSTPERCENTCHANGE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(14, '$HOSTGROUPNAME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(15, '$HOSTGROUPALIAS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(16, '$LASTHOSTCHECK$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(17, '$LASTHOSTSTATECHANGE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(18, '$LASTHOSTUP$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(19, '$LASTHOSTDOWN$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(20, '$LASTHOSTUNREACHABLE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(21, '$HOSTOUTPUT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(22, '$HOSTPERFDATA$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(23, '$HOSTCHECKCOMMAND$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(24, '$HOSTACKAUTHOR$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(25, '$HOSTACKCOMMENT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(26, '$HOSTACTIONURL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(27, '$HOSTNOTESURL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(28, '$HOSTNOTES$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(29, '$SERVICEDESC$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(30, '$SERVICESTATE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(31, '$SERVICESTATEID$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(32, '$SERVICESTATETYPE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(33, '$SERVICEATTEMPT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(34, '$SERVICELATENCY$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(35, '$SERVICEEXECUTIONTIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(36, '$SERVICEDURATION$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(37, '$SERVICEDURATIONSEC$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(38, '$SERVICEDOWNTIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(39, '$SERVICEPERCENTCHANGE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(40, '$SERVICEGROUPNAME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(41, '$SERVICEGROUPALIAS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(42, '$LASTSERVICECHECK$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(43, '$LASTSERVICESTATECHANGE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(44, '$LASTSERVICEOK$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(45, '$LASTSERVICEWARNING$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(46, '$LASTSERVICEUNKNOWN$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(47, '$LASTSERVICECRITICAL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(48, '$SERVICEOUTPUT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(49, '$SERVICEPERFDATA$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(50, '$SERVICECHECKCOMMAND$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(51, '$SERVICEACKAUTHOR$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(52, '$SERVICEACKCOMMENT$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(53, '$SERVICEACTIONURL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(54, '$SERVICENOTESURL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(55, '$SERVICENOTES$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(56, '$TOTALHOSTSUP$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(57, '$TOTALHOSTSDOWN$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(58, '$TOTALHOSTSUNREACHABLE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(59, '$TOTALHOSTSDOWNUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(60, '$TOTALHOSTSUNREACHABLEUNHANDLED$ 	');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(61, '$TOTALHOSTPROBLEMS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(62, '$TOTALHOSTPROBLEMSUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(63, '$TOTALSERVICESOK$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(64, '$TOTALSERVICESWARNING$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(65, '$TOTALSERVICESCRITICAL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(66, '$TOTALSERVICESUNKNOWN$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(67, '$TOTALSERVICESWARNINGUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(68, '$TOTALSERVICESCRITICALUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(69, '$TOTALSERVICESUNKNOWNUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(70, '$TOTALSERVICEPROBLEMS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(71, '$TOTALSERVICEPROBLEMSUNHANDLED$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(72, '$NOTIFICATIONTYPE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(73, '$NOTIFICATIONNUMBER$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(74, '$CONTACTNAME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(75, '$CONTACTALIAS$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(76, '$CONTACTEMAIL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(77, '$CONTACTPAGER$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(78, '$CONTACTADDRESSn$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(79, '$LONGDATETIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(80, '$SHORTDATETIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(81, '$DATE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(82, '$TIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(83, '$TIMET$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(84, '$MAINCONFIGFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(85, '$STATUSDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(86, '$COMMENTDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(87, '$DOWNTIMEDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(88, '$RETENTIONDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(89, '$OBJECTCACHEFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(90, '$TEMPFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(91, '$LOGFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(92, '$RESOURCEFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(93, '$COMMANDFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(94, '$HOSTPERFDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(95, '$SERVICEPERFDATAFILE$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(96, '$PROCESSSTARTTIME$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(97, '$ADMINEMAIL$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(98, '$ADMINPAGER$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(99, '$ARGn$');
INSERT INTO `nagios_macro` (`macro_id`, `macro_name`) VALUES(100, '$USERn$');
