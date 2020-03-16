<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>The Little Prince - </title>
		<meta charset = "utf-8"/>
		<link rel="stylesheet" href="css/general-style.css"/>
		<link rel="stylesheet" href="css/book-style.css"/>
	</head>
	<body class="">
		<?php
		require("header.php");
		echo "<div class=\"main-page\">";
		$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		$book = explode("=", $url)[1];
		$link = mysqli_connect('127.0.0.1', 'root', '', 'The_Little_Prince_library');
		$query = "SELECT book.Title AS 'title', book.Description AS 'description', book.Cover_link AS 'cover', genre.Name AS 'genre', 
		CONCAT(author.First_name, \" \", author.Last_name) AS 'author', YEAR(Publication_date) AS 'date' FROM book 
		INNER JOIN book_genre ON book_genre.Id_book = book.Id_book INNER JOIN genre ON genre.Id_genre = book_genre.Id_genre 
		INNER JOIN author_s_books ON book.Id_book = author_s_books.Id_book INNER JOIN author 
		ON author_s_books.Id_author = author.Id_author WHERE book.Id_book = $book;";
		$query_genre = "SELECT genre.name AS 'genre' FROM genre INNER JOIN book_genre ON book_genre.Id_genre = genre.Id_genre  
		WHERE book_genre.Id_book = $book";
		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
		$result_genre = mysqli_query($link, $query_genre) or die("Ошибка " . mysqli_error($link));
		if($result) {
			$row = mysqli_fetch_array($result);
			echo "<div id=\"img\"> <img src='books_cover/$row[cover]' alt='$row[title]'> </div> 
			<div class=\"information\"> <h1 id=\"title\">$row[title]</h1> <div> <h2>Автор: </h2> <span>$row[author]</span> </div> 
			<div><h2>Год: </h2> <span>$row[date]</span></div>
			<div><h2>Жанр: </h2> <span id=\"genre\">";
			for($i = 0; $i < $result_genre->num_rows; $i++){
				$genre = mysqli_fetch_row($result_genre);
				echo $genre[0];
				if($i != $result_genre->num_rows - 1){
					echo ", ";
				}
			}
			echo "</span> </div>";
			echo "<div><h2>Описание: </h2> <span id=\"description\"><p>$row[description]</p></span></div>";	
			mysqli_free_result($result);
		}
		mysqli_close($link);
		echo "</div>";
		?>
	</body>
</html>