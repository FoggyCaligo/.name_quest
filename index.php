

<!DOCTYPE html>

<?php
require_once './simplehtmldom_1_9_1/simple_html_dom.php';

function get_price($code){
	$answer = 0;
	$html = file_get_html ( 'https://finance.naver.com/item/main.naver?code='.$code);
	
	$p = $html->find('p[class=no_today]',0);
	
	print($p);
	$html->clear();
	return $p;
}



	//RECEIVE DATA & MANAGE DB
	$con = mysqli_connect("localhost","root","test","data2");

	//추가 입력 관리
	if(isset($_GET['writer']) && isset($_GET['content'])){	
		$name = $_GET['writer'];
		$code = $_GET['content'];
		$default_price = "0";
		$sql = "Insert Into data2 VALUES ('"   .$code.  "','"  .$name.    "','".$default_price."')";
		$ret = mysqli_query($con,$sql);
	}

	//제거 입력 관리
	if(isset($_GET['delname']) && isset($_GET['delcode'])){	
		$name = $_GET['delname'];
		$code = $_GET['delcode'];
		$default_price = "0";
		$sql = "delete from data2 where code='".$code."'";
		$ret = mysqli_query($con,$sql);
	}




	$sql = "Select * From data2";
	$ret = mysqli_query($con,$sql);
	if($ret){
	}

	echo("<table>");
	while($row = mysqli_fetch_array($ret)){
		echo("<tr>");
			echo("<td>");
			echo $row['name'];
			echo("</td>");

			echo("<td style='color:lightgray;'>");
			echo (string)$row['code'];
			echo("</td>");
			
			echo("<td>");
			//echo "	".$row['value']."<br>";
			$price = get_price($row['code']);
			echo($price);
			echo("</td>");
		
		echo("</tr>");
		
		
	}
	echo("</table><br>");
	

?>



<html>
<head>
<meta charset="EUC-KR">
<title>Insert title here</title>
<style type="text/css">
#t1, div {
	border: 1px solid black;
}
</style>

</head>
<body>
	
	<form name="f" method="get">
		<h3>추가</h3>
		<table id="t1">
			<tr>
				<th>종목명</th>
				<td><input type="text" name="writer" id="writer"></td>
			</tr>
			<tr>
				<th>종목코드</th>
				<td><input type="text" name="content" id="content"></td>
			</tr>
			<tr>
				<th>작성</th>
				<td><input type="submit" name="submit" id="submit" onclick="insert();"></td>
			</tr>
		</table>


		<h3>제거</h3>
		<table id="t1">
			<tr>
				<th>종목명</th>
				<td><input type="text" name="delname" id="writer"></td>
			</tr>
			<tr>
				<th>종목코드</th>
				<td><input type="text" name="delcode" id="content"></td>
			</tr>
			<tr>
				<th>작성</th>
				<td><input type="submit" name="submit" id="submit" ></td>
			</tr>
		</table>
	</form>

</body>
</html>