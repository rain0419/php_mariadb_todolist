
SHOW TABLES;

desc todo;

ALTER TABLE todo CHANGE list_id list_id INT(100) NOT NULL AUTO_INCREMENT;

INSERT INTO todo(todo_text, add_date) VALUES ('퇴근하기', CURDATE() );

UPDATE todo SET success = 1 WHERE success = 0;

DELETE FROM todo WHERE todo_text = '저녁먹기';
