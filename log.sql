DROP TABLE IF EXISTS test.log;
CREATE TABLE test.log(
	id int NOT NULL AUTO_INCREMENT,
	timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ip char(16),
	type int DEFAULT 0,
	msg varchar(2048),
	PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS test.tag;
CREATE TABLE test.tag(
	id int NOT NULL,
	tag varchar(256)
) DEFAULT CHARSET=utf8;
