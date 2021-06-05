db.ads.aggregate({ $match: { title: 'Название'}})
db.users.aggregate({ $sort: { firstName: 1}})
