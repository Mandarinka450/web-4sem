В данной лабораторной работе мы поработали с базой данных, создали таблицы и написали к ним запросы. Разобрались с инструментом explain, который помогает оптимизировать запрос. 

Запросы:

-- Объединение двух таблиц --
SELECT Workers.name, Workers.surname, Workers.gender, Workers.id_department, Department.name_department
FROM Department INNER JOIN Workers
ON Department.id_department = Workers.id_department
WHERE Workers.id_department = 30
ORDER BY Workers.name

-- Объелинение трех таблиц --
SELECT Workers.name, Workers.gender, Workers.id_department, Department.name_department,
Boss.name_boss, Boss.surname
FROM Department INNER JOIN Workers
ON Department.id_department = Workers.id_department
INNER JOIN Boss
ON Boss.id_boss = Department.id_boss
WHERE Workers.name LIKE 'А%'
ORDER BY Workers.id_department

-- Запрос на выборку --
SELECT * from Workers where id_department=30;

-- Инструмент explain --
EXPLAIN SELECT Workers.name, Workers.surname, Workers.gender, Workers.id_department, Department.name_department
FROM Department INNER JOIN Workers
ON Department.id_department = Workers.id_department
WHERE Workers.id_department = 30
ORDER BY Workers.name

-- Запрос на вывод информации карточки --
SELECT Advertisements.name_advrt, Advertisements.image_advrt,
Advertisements.description, Advertisements.size, Advertisements.state,
Advertisements.price_good, Advertisements.date_advrt, Users.name_user, Reviews.message
FROM Advertisements JOIN Users
ON Advertisements.id_user = Users.id_user
JOIN Reviews ON Reviews.id_user = Users.id_user

-- Еще один запрос на вывод инфы из карточки --
SELECT Advertisements.name_advrt, Advertisements.image_advrt,
Advertisements.description, Advertisements.size, Advertisements.state,
Advertisements.price_good, Advertisements.date_advrt, Categories.name_category,
Type_goods.name_type
FROM Advertisements JOIN Categories
ON Advertisements.id = Categories.id
join Type_goods on Advertisements.id_type = Type_goods.id_type
