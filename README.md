В данной лабораторной работе мы поработали и научились составлять запросы на вывод списка репозиториев с помощью GraphQl, попробовали создать приватный репозиторий и также исследовали процесс авторизации по номеру телефону на сайте юлы. Посмотрели какие заголовки отправляются на запросы, что они содержат.

query { repositoryOwner(login: "Mandarinka450"){ id, repositories(first: 10){ nodes{ url, name, description, createdAt } } }, user(login: "Mandarinka450"){ name, login, email, url } }

mutation { createRepository(input:{ name: "HW-5", ownerId: "MDQ6VXNlcjU2MDcxMzQ5", visibility: PRIVATE }){ repository{ id, name, createdAt, url } } }

mutation{ createIssue(input:{ repositoryId: "MDEwOlJlcG9zaXRvcnkzNjM5MjQwNzY=", title: "TestIssue", body: "issue created" }){ issue{ id, title, body } } } MDEwOlJlcG9zaXRvcnkzNzc3OTQzMTA=

mutation{ updateIssue(input:{ id: "MDU6SXNzdWU4NzQ1MzgwODk=", title: "Updated title", body: "ussue update" }){ issue{ id, title, body } } }

mutation{ closeIssue(input:{ issueId:"MDU6SXNzdWU4NzQ1MzgwODk=" }){ issue{ closedAt } } }

Ввод номера телефона - аутентификация при помощи кода, присланного на телефон - успешная авторизация либо новая попытка. Когда человек пытается войти в систему, ему предлагается несколько вариантов, он нажимает на вторизацию по номеру телефону - https://api.youla.io/api/v1/events/y_client_event?app_id=web%2F2&uid=607d84d6c19b0&timestamp=1620061678736 При введениие телефона - https://youla.ru/web-api/auth/request_code, после этого высылается код, потом человек вводит код и вызывается адрес - https://youla.ru/web-api/auth/login, после того как человек ввел корректный код, происходит переход на главную страницу - https://youla.ru/moskva

Какие параметры и заголовки передаются? - После того как человек вводит номер телефона и нажимает кнопку "Продолжить", появляется файл request_code, в котором передается {phone "79686360371"} в request payload, Request URL: https://youla.ru/web-api/auth/request_code, метод запроса - post, статус - 200 OK, Remote Address: 217.69.139.20:443 (адрес клиента), длина контента и тип контента - Content-Length: 23, Content-Type: application/json; charset=UTF-8, хост и куки-файлы.

В ответ от сервера приходит {"phone":"79686360371","code_length":6,"use_callui":false}, где code_length - будущая длина кода для входа.

После авторизации сайт щлет запросы, которые имеют authorization (по токену), поле user_id, например, user_id: "5f11c8eb1ff07c74ea01e893" в передаваемых параметрах.