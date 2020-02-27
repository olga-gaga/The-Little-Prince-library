<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>The Little Prince - </title>
		<meta charset = "utf-8"/>
		<link rel="stylesheet" href="css/general-style.css"/>
		<link rel="stylesheet" href="css/book-style.css"/>
	</head>
	<body class="">
		<header> 
			<a href="main-page.php"> Главная </a>
			<a href=""> Мой профиль </a>
			<a href=""> Книги </a>
			<a href=""> Авторы </a>
			<a href=""> Жанры </a>
		</header>
		<div class="main-page">
				<?php
					$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
					$book = explode("=", $url)[1];
					$link = mysqli_connect('127.0.0.1', 'root', '', 'The_Little_Prince_library');
					$query = "SELECT book.Title AS 'title', book.Description AS 'description', book.Cover AS 'cover', genre.Name AS 'genre', 
					CONCAT(author.First_name, \" \", author.Last_name) AS 'author', YEAR(Publication_date) AS 'date' FROM book 
					INNER JOIN book_genre ON book_genre.Id_book = book.Id_book INNER JOIN genre ON genre.Id_genre = book_genre.Id_genre 
					INNER JOIN author_s_books ON book.Id_book = author_s_books.Id_book INNER JOIN author ON author_s_books.Id_author = author.Id_author 
					WHERE book.Id_book = $book;";
					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
					if($result) {
						$row = mysqli_fetch_array($result);
						
						//echo $row;
						$image = $row['cover'];
						echo "<div id=\"img\">";
						echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="photo">'; 
						echo "</div>";
						echo "<div class=\"information\">";
						echo "<h1 id=\"title\">$row[title]</h1>";
						echo "<div><h2>Автор: </h2> <span>$row[author]</span> </div>";
						echo "<div><h2>Год: </h2> <span>$row[date]</span></div>";
						echo "<div><h2>Жанр: </h2> <span id=\"genre\"> $row[genre]</span> </div>";
						echo "<div><h2>Описание: </h2> <span id=\"description\"><p>$row[description]</p></span></div>";	
						mysqli_free_result($result);
					}
					mysqli_close($link);
				?>
		</div>
	</body>
</html>