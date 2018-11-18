ALTER TABLE config ADD COLUMN publish_status varchar(255) NOT NULL DEFAULT 'published';
ALTER TABLE entities ADD COLUMN publish_status varchar(255) NOT NULL DEFAULT 'published';
ALTER TABLE reader ADD COLUMN publish_status varchar(255) NOT NULL DEFAULT 'published';

CREATE INDEX c_publish_status ON config (publish_status);
CREATE INDEX e_publish_status ON entities (publish_status);
CREATE INDEX r_publish_status ON reader (publish_status);

DELETE FROM versions WHERE label = 'schema';
INSERT INTO versions VALUES('schema', '2016102601');