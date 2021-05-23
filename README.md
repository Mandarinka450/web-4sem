В данной лабораторной работе мы разобрались с монго. Написали запросы update, find, delete, insert, создали таблицы. Использовали инструмент explain для оптимизации запроса.

Запросы:

db.Positions.insertMany([{"_id":10, "name_position":"Маркетолог","summary":35000},{"_id":11, "name_position":"PHP-программист","summary":180000},{"_id":12, "name_position":"Администратор БД","summary":70000},{"_id":13, "name_position":"Бухгалтер","summary":12000},{"_id":14, "name_position":"SMM-специалист","summary":40000},{"_id":15, "name_position":"SEO-специалист","summary":60000},{"_id":16, "name_position":"Менеджер по продажам","summary":87000}])

db.Boss.insert([{"_id":40,"name_boss":"Василий","surname":"Преображенский","age_boss":56,"date_of_start":"2008-10-23","description":"Очень компетентный, великолепный начальник"},{"_id":41,"name_boss":"Анатолий","surname":"Халмов","age_boss":34,"date_of_start":"2017-04-12","description":"Молодой начальник,сотрудничает со всеми, добрый"},{"_id":42,"name_boss":"Наталья","surname":"Ефимова","age_boss":42,"date_of_start":"2001-04-12","description":"Работает достаточно давно,строгий"},{"_id":43,"name_boss":"Максим","surname":"Пашкевич","age_boss":50,"date_of_start":"2010-10-06","description":"Работать с ним сложно, не идет на контакт никак"}])

db.Department.find().pretty()
 
db.Workers.find({"id_department":30})
 
db.Workers.find().limit(3).pretty()
 
db.Workers.find().sort({"surname":1}).pretty()
 
db.Workers.find({"id_department":30}).count()
 
db.Workers.find({"id_position":{$gte: 11, $lte: 15}})

db.Workers.update({"_id":5,"name":"Анастасия"},{$set:{"name":"Алина"}})

db.Department.update({_id : 30}, {_id: 30, mobile_phone : "+79245672349"}, {upsert: false})

db.Workers.remove({id_position: {$lt : 12}}, true)

db.Department.update({_id : 30}, {_id: 30, name_department:"Отдел маркетинга", mobile_phone : "+79245672349", id_boss:42}, {upsert: false})

db.Workers.aggregate([
{
$lookup: {
    from: "Positions",
    localField: "id_position",
    foreignField: "_id",
    as: "position"
    }
   },
  {
    $replaceRoot: { newRoot: { $mergeObjects: [ { $arrayElemAt: [ "$position", 0 ] }, "$$ROOT" ] } }
   },
   { $project: { position: 0, "_id":0, "id_department":0, "id_position":0 } }
])

