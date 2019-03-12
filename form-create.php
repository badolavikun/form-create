<?php

	$dsn ='データベース名';

	$user ='ユーザー名';

	$password ='パスワード';

	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

?>

<html>

 <head>
	<meta charset="utf-8">
	<title>form-create</title>

 </head>

 <body>

  <form action = "form-create.php" method = "POST">

   <?php

	$data1 = "";
	$data2 = "";
	$data3 = "";

	if(isset($_POST['e']) && $_POST['hensyu'] != "" && $_POST['pass3'] != ""){

		$hensyu = $_POST['hensyu'];

		$pass = $_POST['pass3'];

		$id = $hensyu;

			$sql = "SELECT id,name,comment FROM mission WHERE id=$id and pass=$pass";

			$stmt = $pdo->query($sql);

			$results = $stmt->fetch();

				$data1 = $results['name'];

				$data2 = $results['comment'];

				$data3 = $results['id'];

	}
   ?>

	<p>名前　　　：<input type="text" name="names" value="<?php echo $data1; ?>" ><br/>
	   コメント　：<input type="text" name="coments" value="<?php echo $data2; ?>" ><br/>
	   パスワード：<input type="text" name="pass1">
		       <input type="submit" name="s" value="送信"><br/>
		       <input type="hidden" name="suuji" value="<?php echo $data3; ?>" ></p>

	<p>削除対象番号（半角数字で入力）：<input type="text" name="numbers"><br/>
	   パスワード　　　　　　　　　　：<input type="text" name="pass2">
					   <input type="submit" name="d" value="削除"></p>

	<p>編集対象番号（半角数字で入力）：<input type="text" name="hensyu"><br/>
	   パスワード　　　　　　　　　　：<input type="text" name="pass3">
					   <input type="submit" name="e" value="編集"></p>

<?php

		if(isset($_POST['s']) && $_POST['names'] != "" && $_POST['coments'] != "" && $_POST['pass1'] != ""){


					$name = $_POST['names'];

					$comment = $_POST['coments'];

					$time = date('Y/m/d H:i:s');

					$pass = $_POST['pass1'];


				$sql = $pdo -> prepare("INSERT INTO mission (id,name,comment,time,pass) VALUES(:id, :name, :comment, :time, :pass)");

				$sql -> bindParam(':id', $id, PDO::PARAM_STR);

				$sql -> bindParam(':name', $name, PDO::PARAM_STR);

				$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);

				$sql -> bindParam(':time', $time, PDO::PARAM_STR);

				$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

				$sql -> execute();

				$sql = 'SELECT * FROM mission';

				$stmt = $pdo->query($sql);

				$results = $stmt->fetchAll();

				foreach($results as $row){

					echo $row['id'].',';

					echo $row['name'].',';

					echo $row['comment'].',';

					echo $row['time'].'<br>';

				}

		}elseif(isset($_POST['d']) && $_POST['numbers'] != "" && $_POST['pass2'] != ""){

			$number = $_POST['numbers'];

			$pass = $_POST['pass2'];

			$id = $number;

			$sql = 'delete from mission where id=:id and pass=:pass';

			$stmt = $pdo->prepare($sql);

			$stmt->bindParam(':id', $id, PDO::PARAM_INT);

			$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);

			$stmt->execute();

			$sql = 'SELECT * FROM mission';

			$stmt = $pdo->query($sql);

			$results = $stmt->fetchAll();

				foreach($results as $row){

					echo $row['id'].',';

					echo $row['name'].',';

					echo $row['comment'].',';

					echo $row['time'].'<br>';

				}

		}elseif(isset($_POST['s']) && $_POST['coments'] != "" && $_POST['names'] != "" && $_POST['suuji'] != ""){

				$name = $_POST['names'];

				$comment = $_POST['coments'];

				$id = $_POST['suuji'];

				$time = date('Y/m/d H:i:s');

				$sql ="update mission set name=:name,comment=:comment,time=:time where id=$id";

				$stmt = $pdo->prepare($sql);

				$stmt->bindParam(':name', $name, PDO::PARAM_STR);

				$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

				$stmt->bindParam(':time', $time, PDO::PARAM_STR);

				$stmt->execute();

				$sql = 'SELECT * FROM mission';

				$stmt = $pdo->query($sql);

				$results = $stmt->fetchAll();

					foreach($results as $row){

						echo $row['id'].',';

						echo $row['name'].',';

						echo $row['comment'].',';

						echo $row['time'].'<br>';

					}

		}else{

			$sql = 'SELECT * FROM mission';

			$stmt = $pdo->query($sql);

			$results = $stmt->fetchAll();

			foreach($results as $row){

				echo $row['id'].',';

				echo $row['name'].',';

				echo $row['comment'].',';

				echo $row['time'].'<br>';

			}

		}

?>

  </form>

 </body>

</html>