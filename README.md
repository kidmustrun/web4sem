db.ads.aggregate({ $match: { title: 'Название'}})
db.users.aggregate({ $sort: { firstName: 1}})

{
    "firstName": "Имя",
    "lastName": "Фамилия",
    "phone": "73333333333",
    "status": "active",
    "apiToken": "q1w2e3",
    "roles": [
        "ROLE_USER"
    ]
}