<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>The Little Prince - Главная</title>
		<meta charset = "utf-8"/>
		<link rel="stylesheet" href="css/general-style.css"/>
		<link rel="stylesheet" href="css/main-page-style.css"/>
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
		//echo phpinfo();
		function printBooks($array){
			for($i = 0; $i < $count; $i++){
				$row = mysqli_fetch_array($result);
				$image = $row['cover'];
				echo "<li>";
				echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="photo">';
				echo "<h3 class=\"title\">$row[title]</h3> <h4 class=\"author\">$row[author]</h4>";
				echo "</li>";
			}
		}
		$count = 5;
		$link = mysqli_connect('127.0.0.1', 'root', '', 'The_Little_Prince_library');
		$query = "SELECT book.Id_book AS 'id', book.Title AS 'title', book.Cover AS 'cover', CONCAT(author.First_name, \" \", author.Last_name) 
		AS 'author' FROM book INNER JOIN author_s_books ON book.Id_book = author_s_books.Id_book INNER JOIN author 
		ON author_s_books.Id_author = author.Id_author";
		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
		if($result) {
			echo "<h2 class=\"popular\">Популярные книги</h2>";
			echo "<ul class=\"book-list\">";
			for($i = 0; $i < $result->num_rows; $i++){
				$row = mysqli_fetch_array($result);	
				$image = $row['cover'];
				echo "<li> <a target='_blank' href='book.php?b=$row[id]'>";
				echo '<img src="data:image/jpeg;base64,'.base64_encode($image).'" alt="photo">';
				echo "</a> <a target='_blank' href='book.php?b=$row[id]'> <h3 class=\"title\">$row[title]</h3> </a> <h4 class=\"author\">$row[author]</h4>";
				echo "</li>";
			}
			//for($i = 0; $i < count($row); $i++) echo $row[$i]['title'];
			echo "</ul>";
			//echo "<h2 class=\"new\">Новинки</h2>";
			

		}
		
		?>

           <!-- <h2 class="popular">Популярные книги</h2>
			<ul class="book-list">
				
				<li> 
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<h3 class="title">Унесённые ветром</h3>
					<h4 class="author">Маргарет Митчел</h4>
				</li>
				<li>
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<h3 class="title">Унесённые ветром</h3>
					<h4 class="author">Маргарет Митчел</h4>
				</li>
				<li>
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<h3 class="title">Унесённые ветром</h3>
					<h4 class="author">Маргарет Митчел</h4>
				</li>
				<li>
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<h3 class="title">Унесённые ветром</h3>
					<h4 class="author">Маргарет Митчел</h4>
				</li>
				<li>
					<img src="http://kinosklad.org/uploads/files/posters/2019-06/d1577197c45601ff0d29d3123c3610a9.jpg"/>
					<h3 class="title">Унесённые ветром</h3>
					<h4 class="author">Маргарет Митчел</h4>
				</li>
			</ul>-->
			<h2 class="new">Новинки</h2>
			<ul class="book-list">
				<li>
					<img src="css/images/69173588_images_10372067354.jpg"/>
					<h3 class="title">Маленький принц</h3>
					<h4 class="author">Антуан де Сент-Экзюпери</h4>
				</li>
				<li>
					<img src="css/images/69173588_images_10372067354.jpg"/>
					<h3 class="title">Маленький принц</h3>
					<h4 class="author">Антуан де Сент-Экзюпери</h4>
				</li>
				<li>
					<img src="css/images/69173588_images_10372067354.jpg"/>
					<h3 class="title">Маленький принц</h3>
					<h4 class="author">Антуан де Сент-Экзюпери</h4>
				</li>
				<li>
					<img src="css/images/69173588_images_10372067354.jpg"/>
					<h3 class="title">Маленький принц</h3>
					<h4 class="author">Антуан де Сент-Экзюпери</h4>
				</li>
				<li>
					<img src="css/images/69173588_images_10372067354.jpg"/>
					<h3 class="title">Маленький принц</h3>
					<h4 class="author">Антуан де Сент-Экзюпери</h4>
				</li>
			</ul>
			<h2 class="authors"> Лучшие авторы </h2>
			<ul class="book-list">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</body>
</html>