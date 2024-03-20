<?php
if (!class_exists('System')) exit; // Запрет прямого доступа
require('../modules/st/info.dat');
if($status=='admin'){
	if($act=='index'){


		echo'<div class="header"><h1>Настройки</h1></div>
		<div class="menu_page"><a href="index.php">&#8592; Вернуться назад</a></div>
		
     
		
		
		<form name="settingform" action="module.php?module=st" method="post">
		<INPUT TYPE="hidden" NAME="act" VALUE="addsetting">
		 <div class="content">
    
    <h2>Очистка статистики</h2><p class="box">Если вам нужно обнулить статистику на сайте, то тогда нажимаем на кнопку очистить.
    <form name="forma" method="post" action="module.php?module=<?=$MODULE;?>">
    
    </form>
    <td><input type="submit" name="st" value="Очистить статистику"></td>
    <br/><br/><br/>
    
    
		<table class="tblform">   
      <h2>Цвет обложки</h2><p class="box">Здесь вы можете поменять цвет.   
		<td>Цвет обложки 1:</td>
	   <td><input data-jscolor="{}" style="width:120px;" type="text" name="si_1" value="'.$sim['1'].'" size="50"></td>
	   </tr>
         
        <td>Цвет обложки 2:</td>
	   <td><input data-jscolor="{}" style="width:120px;" type="text" name="si_2" value="'.$sim['2'].'" size="50"></td>
	   </tr>
	   
	    <td>Цвет обложки 3:</td>
	   <td><input data-jscolor="{}" style="width:120px;" type="text" name="si_3" value="'.$sim['3'].'" size="50"></td>
	   </tr>
		</form>
		</div>
		
		
    
	
		<table class="tblform">
      <h2>Заполнение надписей счетчика</h2><p class="box">Здесь вы можете поменять название навигации заполните форму.   
		<tr>
			<td>Заголовок: 1</td>
			<td><input type="text" name="App_1" value="'.$st['1'].'"></td>
		</tr>
		<tr>
			<td>Заголовок: 2</td>
			<td><input type="text" name="App_2" value="'.$st['2'].'"></td>
		</tr>
		<tr>
		<tr>
			<td>Заголовок: 3</td>
			<td><input type="text" name="App_3" value="'.$st['3'].'"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="" value="Сохранить"></td>
		</tr>
		</form>
		</div>	
		
		
		';
	}
	
	if($act=='addsetting')
	{
			$st['1'] = htmlspecialchars($_POST['App_1']);
			$st['2'] = htmlspecialchars($_POST['App_2']);
			$st['3'] = htmlspecialchars($_POST['App_3']);
			$sim['1'] = htmlspecialchars($_POST['si_1']);
			$sim['2'] = htmlspecialchars($_POST['si_2']);
			$sim['3'] = htmlspecialchars($_POST['si_3']);

$inset = '<?php
$st[\'1\'] = \''.addslashes($st['1']).'\';
$st[\'2\'] = \''.addslashes($st['2']).'\';
$st[\'3\'] = \''.addslashes($st['3']).'\';
$sim[\'1\'] = \''.addslashes($sim['1']).'\';
$sim[\'2\'] = \''.addslashes($sim['2']).'\';
$sim[\'3\'] = \''.addslashes($sim['3']).'\';
?>';

			if(filefputs('../modules/st/info.dat', $inset, 'w+')){
				echo'<div class="msg">Настройки успешно сохранены</div>';
			}else{
				echo'<div class="msg">Ошибка при сохранении настроек</div>';
			}
	
?>
<script type="text/javascript">
setTimeout('window.location.href = \'module.php?module=st\';', 3000);
</script>
<?php
	}
}else{
echo'<div class="msg">Необходимо выполнить авторизацию</div>';
?>
<script type="text/javascript">
setTimeout('window.location.href = \'index.php?\';', 3000);
</script>
<?php
}

?>




<?php
$st=$_REQUEST['st'];
$dat=$_REQUEST['dat'];
$file_dat="../modules/st/baz.dat"; //путь к тхт файлу
if(isset($st)){
$fopen=fopen($file_dat,"w");
fputs($fopen,$dat);
fclose($fopen);
?>

<?php
}else{
?>
    
   
<?php
}
?>

