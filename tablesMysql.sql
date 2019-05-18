


CREATE TABLE triala(
	id INT(11) NOT NULL AUTO_INCREMENT,
	nick VARCHAR(5) NOT NULL,
	ids INT(11) NOT NULL,
	PRIMARY KEY (id)
);
SET @incr = 0;
INSERT INTO triala VALUES ( NULL, "noro", (@incr:=@incr + 1) ); // до ids = 14

// 14 it is current maximum ids

UPDATE triala SET ids=14 WHERE ids=7 LIMIT 1;
SET @v1 = 7; // it is ids
SET @v2 = 7; // it is id
UPDATE triala SET ids=(ids - 1) WHERE ids > @v1 AND id != @v2  --- worck
// UPDATE triala SET ids=(@v1:=@v1 + 1) WHERE ids > @v1 AND ids != @v2  --- ???

UPDATE triala SET ids=14 WHERE ids=10 LIMIT 1;
SET @v1 = 10; // it is ids ( current elevent ids before changed )
SET @v2 = 11; // it is id not change ( current element )
UPDATE triala SET ids=(ids - 1) WHERE ids > @v1 AND id != @v2  --- worck

UPDATE triala SET ids=14 WHERE ids=3 LIMIT 1;
SET @v1 = 3; // it is ids ( current elevent ids before changed )
SET @v2 = 3; // it is id not change ( current element )
UPDATE triala SET ids=(ids - 1) WHERE ids > @v1 AND id != @v2  --- worck


SET @incr = 0;
SET @str = "nick";
INSERT INTO trala SET id:=@str

CREATE PROCEDURE dowhile()
BEGIN
  DECLARE @incr INT DEFAULT 1;
  DECLARE @nick VARCHAR DEFAULT "nick";
  SET @incr:=1,  @nick:="nick";
  WHILE @incr < 10 DO
    INSERT INTO trala SET nick:=@nick;
    SET @incr:= @incr + 1;
  END WHILE;
END;

CREATE PROCEDURE dowhile()
BEGIN
  DECLARE v1 INT DEFAULT 5;

  WHILE v1 > 0 DO
    ...
    SET v1 = v1 - 1;
  END WHILE;
END;

CREATE TABLE sections(
	id INT(11) NOT NULL AUTO_INCREMENT,
	tablethemes VARCHAR(255) NOT NULL,
	tableposts  VARCHAR(255) NOT NULL,
	createdata  DATETIME NOT NULL,
	PRIMARY KEY (id)
) ENGINE = InnoDB;
//countthemes INT(11) NOT NULL DEFAULT 0,
//countposts INT(11) NOT NULL DEFAULT 0,
// INSERT INTO sections VALUES (NULL, "jsthemes", NOW())  // 1
// INSERT INTO sections VALUES (NULL, "cssthemes", NOW()) // 2
// ALTER TABLE sections ADD COLUMN tableposts VARCHAR(255) NOT NULL AFTER tablethemes
// UPDATE sections SET tableposts="jsposts" WHERE tablethemes="jsthemes"
// UPDATE sections SET tableposts="cssposts" WHERE tablethemes="cssthemes"


INSERT INTO sections VALUES (NULL, "jsthemes", "jsposts", NOW())

SET NAMES utf8;
USE test;
DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INT(11) NOT NULL AUTO_INCREMENT,
	nick VARCHAR(30) NOT NULL,
	mail VARCHAR(250) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	img  VARCHAR(250),
	rdata DATETIME NOT NULL DEFAULT NOW(),  --- not exist DEFAULT NOW()
	PRIMARY KEY (id)
);

ALTER TABLE users ADD COLUMN rdata DATETIME NOT NULL DEFAULT NOW();
ALTER TABLE users ALTER rdata SET DEFAULT NOW(); -- not worck
ALTER TABLE mytable CHANGE `time` `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

// UPDATE users SET rdata=NOW() WHERE rdata="0000-00-00 00:00:00" OR rdata=NULL
// UPDATE jsthemes SET posts=(SELECT COUNT( jsposts.id_theme ) FROM jsposts WHERE jsposts.id_theme=jsthemes.id )   --- WOOOOORKKK
// UPDATE cssthemes SET posts=(SELECT COUNT( cssposts.id_theme ) FROM cssposts WHERE cssposts.id_theme=cssthemes.id ) 
// UPDATE jsthemes SET lmdate=(SELECT max(jsposts.chdate) FROM jsposts WHERE jsposts.id_theme=jsthemes.id)         --- update last message data
// UPDATE cssthemes SET lmdate=(SELECT max(cssposts.chdate) FROM cssposts WHERE cssposts.id_theme=cssthemes.id)

// not work 
// UPDATE jsthemes SET lmnick=(SELECT jsthemes.nick_author FROM jsthemes WHERE jsthemes.lmdate=(SELECT max(jsposts.chdate) FROM jsposts WHERE jsposts.id_theme=jsthemes.id))          --- update last message data
// UPDATE jsthemes SET lmnick=(SELECT nick_author FROM jsthemes WHERE lmdate=(SELECT jsposts.chdate FROM jsposts WHERE jsposts.id_theme=jsthemes.id)) 

// UPDATE jsthemes SET lmnick=nick_author;
// UPDATE jsthemes SET lmid=(SELECT max(id_answer) FROM jsposts WHERE id_theme=jsthemes.id )
// UPDATE cssthemes SET lmid=(SELECT max(id_answer) FROM cssposts WHERE id_theme=cssthemes.id )

// http://www.sql.ru/forum/959185/pomenyat-mestami-znacheniya-poley
// update test t1 join test t2 on (t1.id=16 and t2.pos=4 and t1.status=t2.status) set t1.pos=t2.pos, t2.pos=t1.pos;
// UPDATE jsthemes t1 JOIN jsthemes t2 on( t1.id=30 and t2)

// ALTER TABLE jsthemes ALTER countthemes SET DEFAULT 1;

// select id_answer, id_theme, id_author from jsposts
// DELETE FROM `table` WHERE LENGTH(`field`) < 20
// DELETE FROM users WHERE nick='Swer'
// 'ALTER TABLE jsthemes ADD COLUMN nick_author VARCHAR(30) NOT NULL AFTER id_author'
ALTER TABLE users ADD COLUMN rdata DATETIME NOT NULL AFTER img
ALTER TABLE jsthemes ADD COLUMN id_section INT(11) NOT NULL AFTER putdate
ALTER TABLE jsthemes ADD COLUMN views INT(11) NOT NULL DEFAULT 1 AFTER nametheme
ALTER TABLE jsthemes DROP COLUMN id_section
ALTER TABLE jsthemes ADD COLUMN lmdate DATETIME NOT NULL DEFAULT NOW() AFTER putdate
ALTER TABLE jsthemes ADD COLUMN lmnick VARCHAR(30) NOT NULL AFTER lmdate
ALTER TABLE jsthemes ADD COLUMN lmid INT(11) NOT NULL AFTER lmnick
ALTER TABLE jsthemes ALTER lmid SET DEFAULT 0
ALTER TABLE jsthemes ADD COLUMN countthemes INT(11) NOT NULL AFTER putdate   ---   UPDATE jsthemes SET countthemes=id
ALTER TABLE jsthemes ALTER countthemes SET DEFAULT id;


SET @row_number = 0;

SELECT 
    (@row_number:=@row_number + 1) AS num, firstName, lastName
FROM
    employees
LIMIT 5;

SET @row_number = 0;

UPDATE jsthemes SET countthemes=(SELECT)
    (@row_number:=@row_number + 1) AS num, firstName, lastName
FROM
    employees
LIMIT 5;




SELECT COUNT(*) FROM table_name  - all notes in table
SELECT COUNT( id_theme ) FROM jsposts WHERE id_theme=1

SELECT fields FROM table ORDER BY id DESC LIMIT 1; // last row

SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 5   
 то же
SELECT * FROM users ORDER BY id DESC LIMIT 5, 10

use test;
user: Swer
password: rootrootroot
https://xsecurityx.000webhostapp.com/

CREATE TABLE `id1857480_test`.`users` (

 `id` INT(11) NOT NULL AUTO_INCREMENT , 
 `nick` VARCHAR(30) NOT NULL , 
 `mail` VARCHAR(250) NOT NULL , 
 `pass` VARCHAR(255) NOT NULL , 
 `img` VARCHAR(250) NULL DEFAULT NULL ,
 `rdata` DATETIME NOT NULL DEFAULT NOW() ,  --- not exist DEFAULT NOW()
  PRIMARY KEY (`id`)
 ) ENGINE = InnoDB;



CREATE TABLE jsthemes (
	id INT(11) NOT NULL AUTO_INCREMENT,
	id_author INT(11) NOT NULL,
	nick_author VARCHAR(30) NOT NULL,
	nametheme VARCHAR(255) NOT NULL,
	views INT(11) NOT NULL DEFAULT 1,
	posts INT(11) NOT NULL DEFAULT 1,
	putdate DATETIME NOT NULL DEFAULT NOW(),
	countthemes INT(11) NOT NULL DEFAULT 1,
	lmdate DATETIME NOT NULL DEFAULT NOW(),
	lmnick VARCHAR(30) NOT NULL,
	lmid INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
)  ENGINE = InnoDB;

ALTER TABLE jsthemes ALTER lmid SET DEFAULT 0;
lmdate = last message date

CREATE TABLE jsposts (
	id_answer INT(11) NOT NULL AUTO_INCREMENT,
	id_theme INT(11) NOT NULL,
	FOREIGN KEY (id_theme) REFERENCES jsthemes (id)
		ON UPDATE CASCADE 
		ON DELETE RESTRICT,
	id_author INT(11) NOT NULL,
	putdate DATETIME NOT NULL,
	chdate DATETIME NOT NULL,
	message TEXT NOT NULL,
	PRIMARY KEY (id_answer)
)  ENGINE = InnoDB;

$query   = 'INSERT INTO jsposts VALUES(NULL, :id_theme, :id_author, NOW(), NOW(), :message );';
$prepare = $pdo->prepare( $query );
$result  = $prepare->execute( array(':id_theme' => $id_theme, ':id_author' => $_SESSION['id'], ':message' => $message )  );

CREATE TABLE cssthemes (
	id INT(11) NOT NULL AUTO_INCREMENT,
	id_author INT(11) NOT NULL,
	nick_author VARCHAR(30) NOT NULL,
	nametheme VARCHAR(255) NOT NULL,
	views INT(11) NOT NULL DEFAULT 1,
	posts INT(11) NOT NULL DEFAULT 1,
	putdate DATETIME NOT NULL DEFAULT NOW(),
	countthemes INT(11) NOT NULL DEFAULT 1,
	lmdate DATETIME NOT NULL DEFAULT NOW(),
	lmnick VARCHAR(30) NOT NULL,
	lmid INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
)  ENGINE = InnoDB;

CREATE TABLE cssposts (
	id_answer INT(11) NOT NULL AUTO_INCREMENT,
	id_theme INT(11) NOT NULL,
	FOREIGN KEY (id_theme) REFERENCES cssthemes (id)
		ON UPDATE CASCADE 
		ON DELETE RESTRICT,
	id_author INT(11) NOT NULL,
	putdate DATETIME NOT NULL,
	chdate DATETIME NOT NULL,
	message TEXT NOT NULL,
	PRIMARY KEY (id_answer)
)  ENGINE = InnoDB;



В 1992 году компания Nombas (впоследствии приобретённая Openwave[en]) начала разработку встраиваемого скриптового языка Cmm (Си-минус-минус), который, по замыслу разработчиков, должен был стать достаточно мощным, чтобы заменить макросы, сохраняя при этом схожесть с Си, чтобы разработчикам не составляло труда изучить его[11]. Главным отличием от Си была работа с памятью. В новом языке всё управление памятью осуществлялось автоматически: не было необходимости создавать буферы, объявлять переменные, осуществлять преобразование типов. В остальном языки сильно походили друг на друга: в частности, Cmm поддерживал стандартные функции и операторы Си[12]. Cmm был переименован в ScriptEase, поскольку исходное название звучало слишком негативно, а упоминание в нём Си «отпугивало» людей[11][13]. На основе этого языка был создан проприетарный продукт CEnvi. В конце ноября 1995 года Nombas разработала версию CEnvi, внедряемую в веб-страницы. Страницы, которые можно было изменять с помощью скриптового языка, получили название Espresso Pages — они демонстрировали использование скриптового языка для создания игры, проверки пользовательского ввода в формы и создания анимации. Espresso Pages позиционировались как демоверсия, призванная помочь представить, что случится, если в браузер будет внедрён язык Cmm. Работали они только в 16-битовом Netscape Navigator под управлением Windows[14]. В статье «The World’s Most Misunderstood Programming Language Has Become the World’s Most Popular Programming Language»[29] ( (рус.) «Самый неправильно понятый язык программирования в мире стал самым популярным в мире языком программирования») Дуглас Крокфорд утверждает, что лидирующую позицию JavaScript занял в связи с развитием AJAX, поскольку браузер стал превалирующей системой доставки приложений. Он также констатирует растущую популярность JavaScript, то, что этот язык встраивается в приложения, отмечает значимость языка. Согласно TIOBE Index, базирующемуся на данных поисковых систем Google, MSN, Yahoo!, Википедия и YouTube, в апреле 2015 года JavaScript находился на 6 месте (год назад на 9)[30]. По данным Black Duck Software (англ.)[31] в разработке открытого программного обеспечения доля использования JavaScript росла. 36 % проектов, выпуски которых состоялись с августа 2008 по август 2009 гг., включают JavaScript, наиболее часто используемый язык программирования с быстрорастущей популярностью. 80 % открытого программного обеспечения использует Си, C++, Java, Shell и JavaScript. При этом JavaScript — единственный из этих языков, чья доля использования увеличилась (более чем на 2 процента, если считать в строках кода)[32]. JavaScript является самым популярным языком программирования, используемым для разработки веб-приложений на стороне клиента (англ.)[33][34].




Вы можете увидеть состояние потока расписания событий планировщика событий, выполнив следующую команду:

SHOW PROCESSLIST;

Чтобы включить и запустить поток планировщика событий, вам необходимо выполнить следующую команду:

SET GLOBAL event_scheduler = ON; // в конфиге event_scheduler=1

Чтобы отключить и остановить событие потока планировщика событий, вы выполняете команду SET GLOBAL со значением события_scheduler, равным OFF:

SET GLOBAL event_scheduler = OFF;

Поток планировщика не выполняется и не отображается в выводе SHOW PROCESSLIST.

SET GLOBAL event_scheduler = DISABLED;

Чтобы показать все события схемы базы данных, вы используете следующий оператор:

SHOW EVENTS FROM classicmodels;

Создание новых событий MySQL
Чтобы создать и запланировать новое событие, используйте  CREATE EVENTследующую инструкцию:

CREATE EVENT [IF NOT EXIST]  event_name
ON SCHEDULE schedule
DO
event_body

после ON SCHEDULE schedule
AT timestamp [+ INTERVAL]    -  одноразовое событие
EVERY interval STARTS timestamp [+INTERVAL] ENDS timestamp [+INTERVAL]   -  повторяющееся событие

ПРИМЕР :

CREATE TABLE IF NOT EXISTS messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE EVENT IF NOT EXISTS test_event_01
ON SCHEDULE AT CURRENT_TIMESTAMP  
DO
  INSERT INTO messages(message,created_at)
  VALUES('Test MySQL Event 1',NOW());



CREATE EVENT test_event_02
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 MINUTE - через минуту
ON COMPLETION PRESERVE                               - оставляет запись ( SHOW EVENTS FROM classicmodels; )
DO
   INSERT INTO messages(message,created_at)
   VALUES('Test MySQL Event 2',NOW());


Следующий оператор создает повторяющееся событие, которое выполняется каждую минуту и ​​истекает через 1 час после его создания:

CREATE EVENT test_event_03
ON SCHEDULE EVERY 1 MINUTE
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 HOUR
DO
   INSERT INTO messages(message,created_at)
   VALUES('Test MySQL recurring Event',NOW());



Удалить события MySQL

Чтобы удалить существующее событие, используйте  DROP EVENTследующую инструкцию:

DROP EVENT [IF EXIST] event_name;




ПРОЦЕДУРЫ

CREATE DEFINER = 'root'@'localhost' PROCEDURE `new_proc`()
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
DECLARE tbl_tmp,tbl_logarch VARCHAR(50);
-- tbl_log будет названием архивируемой таблицы
-- мы хотим получить название архивной таблицы tbl_log_<дата>_<время>
SET tbl_logarch=DATE_FORMAT(CURRENT_TIMESTAMP, '%Y%m%d_%H%i');
SET tbl_tmp=CONCAT("tbl_log_", tbl_logarch);
-- формируем SQL запрос на создание архивной таблицы;
SET @archive_query:=CONCAT("CREATE TABLE ", tbl_tmp, " ENGINE=ARCHIVE AS (SELECT * FROM tbl_log)");
-- выполняем подготовленный запрос
PREPARE archive_query FROM @archive_query;
EXECUTE archive_query;
DEALLOCATE PREPARE archive_query;
-- удаляем данные из основной таблицы, в моем случае без всяких условий
DELETE FROM tbl_log;
END;

Теперь запустим процедуру и посмотрим, работает ли она
call new_proc();



