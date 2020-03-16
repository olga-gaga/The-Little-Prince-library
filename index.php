<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>The Little Prince - Главная</title>
		<meta charset = "utf-8"/>
		<link rel="stylesheet" href="css/general-style.css"/>
		<link rel="stylesheet" href="css/main-page-style.css"/>
	</head>
	<body class="">
		<?php
		require("header.php");
		echo "<div class=\"main-page\">";
		$count = 5;
		$max_len = 25;
		$link = mysqli_connect('127.0.0.1', 'root', '', 'The_Little_Prince_library');
		$query0 = "SELECT book.Id_book AS 'id', book.Title AS 'title', CONCAT(author.First_name, \" \", author.Last_name) AS 'author', book.Cover_link AS 'cover', 
		COUNT(books_that_read.Id_book) FROM book INNER JOIN author_s_books ON book.Id_book = author_s_books.Id_book INNER JOIN author 
		ON author_s_books.Id_author = author.Id_author LEFT JOIN books_that_read ON book.Id_book = books_that_read.Id_book  GROUP BY books_that_read.Id_book ORDER BY 
		COUNT(books_that_read.Id_book)  DESC LIMIT $count;";
		
		$query1 = "SELECT book.Id_book AS 'id', book.Title AS 'title', book.Cover_link AS 'cover', CONCAT(author.First_name, \" \", author.Last_name) AS 'author', 
		book.Publication_date AS 'date' FROM book INNER JOIN author_s_books ON book.Id_book = author_s_books.Id_book INNER JOIN author 
		ON author_s_books.Id_author = author.Id_author ORDER BY book.Publication_date DESC LIMIT $count;";
		
		$query2 = "SELECT `author`.`Id_author` AS 'id', CONCAT(author.First_name, \" \", author.Last_name) AS 'author', 
		COUNT(books_that_read.Id_book), author.Photo_link AS 'photo' FROM author INNER JOIN author_s_books 
		ON author.Id_author = author_s_books.Id_author 
		LEFT JOIN books_that_read ON books_that_read.Id_book = author_s_books.Id_book GROUP BY author.id_author
		ORDER BY COUNT(books_that_read.Id_book) DESC LIMIT $count;";

		function printBooks($result){
			echo "<ul class=\"book-list\">";
			for($i = 0; $i < $result->num_rows; $i++){
				$row = mysqli_fetch_array($result);	
				$title = $row[title];
				$title = str_replace("Часть", "Ч.", $title);
				if(count($title) > $max_len) {
					$title = substr($title, $max_len);
				}
				echo "<li> <a target='_blank' href='book.php?b=$row[id]'> <img class='book-cover' src='books_cover/$row[cover]' alt='$row[title]'> </a> 
				<a target='_blank' href='author.php?b=$row[id]'> <h3 class=\"title\">$title</h3> </a> <h4 class=\"author\">$row[author]</h4> </a> </li>";
			}
			echo "</ul>";
		}
		function printAuthor($result) {
			echo "<ul class=\"book-list\">";
			for($i = 0; $i < $result->num_rows; $i++){
				$row = mysqli_fetch_array($result);	
				echo "<li> <a target='_blank' href='book.php?b=$row[id]'> <img class='author-photo' src='authors_photo/$row[photo]' alt='$row[title]'> </a> 
				<a target='_blank' href='book.php?b=$row[id]'> <h3 class=\"title\">$row[author]</h3> </a> </li>";
			}
			echo "</ul>";
		}
		$result0 = mysqli_query($link, $query0) or die("Ошибка " . mysqli_error($link));
		$result1 = mysqli_query($link, $query1) or die("Ошибка " . mysqli_error($link));
		$result2 = mysqli_query($link, $query2) or die("Ошибка " . mysqli_error($link));
		if($result0) {
			echo "<h2 class=\"popular\">Популярные книги</h2>";
			printBooks($result0);
		}
		if($result1) {
			echo "<h2 class=\"new\">Новинки</h2>";
			printBooks($result1);
		}
		if($result2){
			echo "<h2 class=\"authors\"> Лучшие авторы </h2>";
			printAuthor($result2);
		}
		echo "</div>";
		?>		
	</body>
</html>