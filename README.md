запросы
select * from authors where author_id=1
select * from authors join books on authors.author_id = books.author_id
select * from authors join books on authors.author_id = books.author_id join prices on books.book_id=prices.book_id
select * from authors join books on authors.author_id = books.author_id join prices on books.book_id=prices.book_id where books.book_id=1
select * from authors join books on authors.author_id = books.author_id join prices on books.book_id=prices.book_id order by books.title
explain select * from authors join books on authors.author_id = books.author_id join prices on books.book_id=prices.book_id
select * from ad join user on ad.id_user = user.id 
select * from user join reviews on user.id = reviews.user_id where user.id=1
select * from ad join categories on ad.category = categories.category where categories.id=1