TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `Iswater` AFTER INSERT ON `post` FOR EACH ROW UPDATE user SET identity = "WATER" WHERE identity = "NORMAL" AND new.postername = username AND (SELECT count(postID) FROM post WHERE username = new.postername AND  DATE_FORMAT(postTime, \'%Y-%m-%d-%H\') = DATE_FORMAT(NOW(), \'%Y-%m-%d-%H\') AND MINUTE(postTime)-MINUTE(NOW())<10) > 10'
sql_modes=1342177280
definers='root@localhost'
client_cs_names='utf8'
connection_cl_names='utf8_general_ci'
db_cl_names='latin1_swedish_ci'
