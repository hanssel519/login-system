<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	unset($_SESSION['account']);
	echo "<script>alert('登出成功!')</script>";
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
?>