<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>The Little Prince - </title>
		<meta charset = "utf-8"/>
		<link rel="stylesheet" href="css/general-style.css"/>
		<link rel="stylesheet" href="css/profile-style.css"/>
	</head>
	<body class="">
	<?php require("header.php"); $length = 292; ?>
	<div class="main-page">
	<?php 
	$author = '';
	$count = 0;
	$length = 750;
	$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
	$user_url = explode("=", $url)[1];
	$link = mysqli_connect('127.0.0.1', 'root', '', 'The_Little_Prince_library');
	$query0 = "SELECT CONCAT(user.First_name, ' ', user.Last_name) AS 'name', user.Photo_link AS 'photo' FROM user WHERE user.Id_user = $user_url;";
			
	$query_want = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date', book.Cover_link AS 'cover', 
	CONCAT(author.First_name, ' ', author.Last_name) FROM user INNER JOIN want_to_read ON want_to_read.Id_user = user.Id_user 
	INNER JOIN book.Id_book = want_to_read.Id_book WHERE user.Id_user =  $user_url ORDER BY book.Title DESC;";

	$query_want_date = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date', book.Cover_link AS 'cover', 
	CONCAT(author.First_name, ' ', author.Last_name) FROM user INNER JOIN want_to_read ON want_to_read.Id_user = user.Id_user 
	INNER JOIN book.Id_book = want_to_read.Id_user.Id_book WHERE user.Id_user =  $user_url ORDER BY book.Publication_date DESC;";

	$query_want_popularity = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date',  
	CONCAT(author.First_name, ' ', author.Last_name) FROM user INNER JOIN want_to_read ON want_to_read.Id_user = user.Id_user 
	INNER JOIN book ON book.Id_book = want_to_read.Id_book INNER JOIN author_s_books ON `author_s_books`.Id_book = `book`.Id_book 
	INNER JOIN author ON author.`Id_author`=author_s_books.Id_author LEFT JOIN books_that_read ON book.Id_book = books_that_read.Id_book 
	WHERE user.Id_user = $user_url GROUP BY books_that_read.Id_book ORDER BY COUNT(books_that_read.Id_book);";

	$query_reading_popularity = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date', book.Cover_link AS 'cover', 
	COUNT(books_that_read.Id_book) AS 'count', CONCAT(author.First_name, ' ', author.Last_name) FROM user 
	INNER JOIN books_that_read ON user.Id_user = books_that_read.Id_user INNER JOIN book ON book.Id_book = books_that_read.Id_book 
	INNER JOIN author_s_books ON author_s_books.Id_book = book.Id_book INNER JOIN author ON author.Id_author = author_s_books.Id_author 
	WHERE user.Id_user =  $user_url GROUP BY books_that_read.Id_book ORDER BY COUNT(books_that_read.Id_book) DESC;";

	$query_reading_date = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date', book.Cover_link AS 'cover', 
	COUNT(books_that_read.Id_book) AS 'count', CONCAT(author.First_name, ' ', author.Last_name) FROM user 
	INNER JOIN books_that_read ON user.Id_user = books_that_read.Id_user INNER JOIN book ON book.Id_book = books_that_read.Id_book 
	INNER JOIN author_s_books ON author_s_books.Id_book = book.Id_book INNER JOIN author ON author.Id_author = author_s_books.Id_author 
	WHERE user.Id_user =  $user_url ORDER BY book.Publication_date DESC;";

	$query_reading = "SELECT book.Title AS 'title', book.Description AS 'description', book.Publication_date AS 'date', book.Cover_link AS 'cover', 
	CONCAT(author.First_name, ' ', author.Last_name) FROM user INNER JOIN books_that_read ON books_that_read.Id_user = user.Id_user 
	INNER JOIN book.Id_book = books_that_read.Id_user.Id_book WHERE user.Id_user =  $user_url ORDER BY book.Title DESC;";

	//$query_have_been_read = 

	$result0 = mysqli_query($link, $query0) or die("Ошибка " . mysqli_error($link));
	//$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
	if($result0){
		$row = mysqli_fetch_array($result0);
		echo "<div class='user'> <div id='img'> <img src='user_photo/$row[photo]'/> </div> <div class='information'> <h1 id='name'> $row[name] </h1> 
			<p class='description'>$row[description] </p> </div> </div>";
	}
	/*if ($result1) {
		echo "<h3 class='author-books'>Книги автора</h3> <form> <ul class='books-list'>";
		for($i = 0; $i < $count; $i++) {
			$row = mysqli_fetch_array($result1);
			if($length >= strlen($row['description'])) {
				echo "<li> <img src='books_cover/$row[cover]'/> <div class='about-book'><p class='title'> <a>$row[title] </a></p>
				<p class='author'> <a> $author </a></p> <p class='description'>$row[description]</p> </div> </li>";
			}
			else {
				echo "<li> <img src='books_cover/$row[cover]'/> <div class='about-book'><p class='title'> <a>$row[title] </a></p>
				<p class='author'> <a> $author </a></p> <p class='description'>".substr($row[description], 0, stripos($row['description'],' ', $length))."...</p> </div> </li>";
			}
		}
		echo "</ul>";
	}
	echo "</div>"*/
	?>
			
			<!--<div class="user">
				<div id="img">
					<img src="user_photo/miriam_meyzel.jpg"/> 
				</div>
				<div class="information">
					<h1 id="name">Скарлетт О'Хара Гамильтон Кеннеди Батлер</h1>
					
				</div>
			</div>
			<h2> Книжная полка </h2>
			<form> <h3 class="open">Читаю</h3> <h3>Хочу прочесть</h3> <h3>Прочитано</h3></form>
			<ul class="books-list">
				<li> 
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<div class="about-book"><p class="title"> <a>Унесённые ветром </a></p>
					<p class="author"> <a>Маргарет Митчел </a></p>
					<p class="description">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa 0000000000000000000000000000000000000000000000000000000000000000000000000000 0000 00000000000000000000000000000000000 00000000000000000000000000000
						0000000000000000000000000000000000000000000000000000000000000000000000000 000000000000000000000000000000000
						00000000000000000000</p> </div>
				</li>
				<li> 
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<div class="about-book"><p class="title"> <a>Унесённые ветром </a></p>
					<p class="author"> <a>Маргарет Митчел </a></p>
					<p class="description"> Красавица Скарлетт О`Хара - главная героиня романа "Унесенные ветром" - стала любимицей не только для американцев. Миллионы людей во всем мире, прочитавших эту удивительную книгу, а затем посмотревших одноименный голливудский киношедевр в кинотеатрах и по телевидению, прониклись состраданием и симпатией к своенравной, энергичной "южанке", </p> </div>
				</li>
				<li> 
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<div class="about-book"><p class="title"> <a>Унесённые ветром </a></p>
					<p class="author"> <a>Маргарет Митчел </a></p>
					<p class="description"> Красавица Скарлетт О`Хара - главная героиня романа "Унесенные ветром" - стала любимицей не только для американцев. Миллионы людей во всем мире, прочитавших эту удивительную книгу, а затем посмотревших одноименный голливудский киношедевр в кинотеатрах и по телевидению, прониклись состраданием и симпатией к своенравной, энергичной "южанке", </p> </div>
				</li>
				<li> 
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<div class="about-book"><p class="title"> <a>Унесённые ветром </a></p>
					<p class="author"> <a>Маргарет Митчел </a></p>
					<p class="description"> Красавица Скарлетт О`Хара - главная героиня романа "Унесенные ветром" - стала любимицей не только  для американцев. Миллионы людей во всем мире, прочитавших эту удивительную книгу, а затем посмотревших одноименный голливудский киношедевр в кинотеатрах и по телевидению, прониклись состраданием и симпатией к своенравной, энергичной "южанке", </p> </div>
				</li>
			</ul>
		</div>-->
	</body>
</html>