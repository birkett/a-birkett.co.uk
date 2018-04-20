USE abirkett;

UPDATE tblPost    SET dtmTimestamp = DATE_FORMAT(FROM_UNIXTIME(intTimestamp), '%Y-%m-%d %H:%i:%s');
UPDATE tblComment SET dtmTimestamp = DATE_FORMAT(FROM_UNIXTIME(intTimestamp), '%Y-%m-%d %H:%i:%s');
