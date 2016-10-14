--createChildLst--
CREATE DEFINER=`root`@`localhost` PROCEDURE `createChildLst`(IN `rootId` INT, IN `nDepth` INT)
    NO SQL
BEGIN
   DECLARE done INT DEFAULT 0;
   DECLARE b INT;
   DECLARE cur1 CURSOR FOR SELECT id FROM pages where parent_id=rootId ORDER BY rank_id DESC;
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

   insert into tmpLst values (null,rootId,nDepth);

   OPEN cur1;

   FETCH cur1 INTO b;
   WHILE done=0 DO
       CALL createChildLst(b,nDepth+1);
       FETCH cur1 INTO b;
   END WHILE;

   CLOSE cur1;
END

--showChildLst--
BEGIN
   DECLARE done INT DEFAULT 0;
   DECLARE b INT;
   DECLARE cur1 CURSOR FOR SELECT id FROM pages where parent_id IS NULL ORDER BY rank_id DESC;
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
   CREATE TEMPORARY TABLE IF NOT EXISTS tmpLst
    (sno int primary key auto_increment,id int,depth int);
   DELETE FROM tmpLst;

SET max_sp_recursion_depth = 255;

 OPEN cur1;
   FETCH cur1 INTO b;
   WHILE done=0 DO
       CALL createChildLst(b,0);
       FETCH cur1 INTO b;
   END WHILE;
 CLOSE cur1;

  select tmpLst.*,pages.title,pages.view, pages.rank_id, pages.created_at, pages.updated_at from tmpLst,pages where tmpLst.id=pages.id order by tmpLst.sno limit position , perPage;
END

--getChildLst--
CREATE DEFINER=`root`@`localhost` FUNCTION `getChildLst`(`rootId` INT) RETURNS varchar(255) CHARSET utf8
    NO SQL
BEGIN
    DECLARE sTemp VARCHAR(1000);
    DECLARE sTempChd VARCHAR(1000);

    SET sTemp = '$';
    SET sTempChd =cast(rootId as CHAR);

    WHILE sTempChd is not null DO
     SET sTemp = concat(sTemp,',',sTempChd);
     SELECT group_concat(id) INTO sTempChd FROM pages where FIND_IN_SET(parent_id,sTempChd)>0;
    END WHILE;
    RETURN sTemp;
END

--call stored *--
select * from `pages` where FIND_IN_SET(id, getChildLst(2));
CALL `showChildLst`();

--
ALTER TABLE tablename AUTO_INCREMENT = 100;
