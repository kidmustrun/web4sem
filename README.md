запросы  
db.users.find()
db.users.find({name: "Ирина"})
user = db.users.findOne() - ищем юзера
db.ad.findOne({user_id: user._id}) - ищем обьявления с id юзера
ad = db.ad.findOne()
db.categories.findOne({category_id: ad.category_id})
db.users.insert({name: "Tom", surname: "Smith", phone: "3456789099", email: "tom@mail.com"})
db.users.update({name : "Tom"}, {name: "Tom", surname: "Doe", phone: "3456789099", email: "tom@mail.com"}, {upsert: true}) - обновить документ с именем Tom, если не найден - создать новый документ
db.users.remove({name : "Tom"}, true) - удалить все элементы с name Tom
db.users.find().explain()
db.users.find({name: "Ирина"}).explain()