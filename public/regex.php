<?php 
	date_default_timezone_set("Asia/Shanghai");
	ini_set('display_errors', 'on');
	header("Content-Type:text/html;   charset=utf8"); 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>regular expression example</title>
<!-- <meta name="description" content=""> -->
<!-- <meta name="keywords" content=""> -->
<!-- <link href="" rel="stylesheet"> -->
<style type="text/css">
	/**{padding:0;margin:0;}*/
	body{
		font: 14px/1.5 "微软雅黑","Microsoft Yahei"; 
	}
	em{
		font-size: 24px;
		font-weight: bold;
		color: #0f0;
	}
	table{border-spacing: 0;border-collapse:collapse;}
	td{padding:0.3em 1em;border:1px solid #ccc;}
</style>
</head>
<body>
    <?php 
    	$string =  <<<OUTPUT
    	<p>
    		On Friendship
			And a youth said, "Speak to us of Friendship." 
			Your friend is your needs answered. 
			He is your field which you sow with love and reap with thanksgiving. 
			And he is your board and your fireside. 
			For you come to him with your hunger, and you seek him for peace. 
			When your friend speaks his mind you fear not the "nay" in your own mind, nor do you withhold the "ay." 
			And when he is silent your heart ceases not to listen to his heart; 
			For without words, in friendship, all thoughts, all desires, all expectations are born and shared, with joy that is unacclaimed. 
			When you part from your friend, you grieve not; 2asd
			For that which you love most in him may be clearer in his absence, as the mountain to the climber is clearer from the plain. 
			And let there be no purpose in friendship save the deepening of the spirit. 
			For love that seeks aught but the disclosure of its own mystery is not love but a net cast forth: and only the unprofitable is caught. 
			And let your best be for your friend. 
			If he must know the ebb of your tide, let him know its flood also. 
			For what is your friend that you should seek him with hours to kill? 
			Seek him always with hours to live. 
			For it is his to fill your need, but not your emptiness. 
			And in the sweetness of friendship let there be laughter, and sharing of pleasures. 
			For in the dew of little things the heart finds its morning and is refreshed. 
    	</p>
OUTPUT;
		$pattern = "/([a-c])/i";
		echo $string;
		// //替换全部 regular
		// echo str_replace("And","<em>regular</em>",$string);
		// //不区分大小写
		// echo str_ireplace("And","<em>regular</em>",$string);
		// //不区分大小写
		// echo preg_replace("/And/i","<em>regular</em>",$string);
		// echo preg_replace($pattern,"<em>$1</em>",$string);
		// echo preg_replace("/\b\w{4}\b/i","<em>11111</em>",$string);
		echo preg_replace("/^\b\w+$/i","<em>11111</em>",$string);
    ?>
    <table>
    	<tr>
    		<td>(\w)</td>
    		<td>同[A-Za-z0-9_]</td>
    		<td>单词字符简写</td>
    	</tr>
    	<tr>
    		<td>(\d)</td>
    		<td>同[0-9]</td>
    		<td>数字字符简写</td>
    	</tr>
    	<tr>
    		<td>(\s) </td>
    		<td>同[ \t\r\n]</td>
    		<td>空白字符类简写</td>
    	</tr>


    	<tr>
    		<td>(\W) </td>
    		<td>同[^A-Za-z0-9_]</td>
    		<td>非空白字符类简写</td>
    	</tr>
    	<tr>
    		<td>(\D)</td>
    		<td>同[^0-9]</td>
    		<td>非数字字符简写</td>
    	</tr>
    	<tr>
    		<td>(\S)</td>
    		<td>同[^ \t\r\n]</td>
    		<td>非数字字符简写</td>
    	</tr>

    	<tr>
    		<td>/\b匹配字符\b/</td>
    		<td></td>
    		<td>单词边界</td>
    	</tr>

    	<tr>
    		<td>^</td>
    		<td>ex: /Jone (Doe)*/</td>
    		<td>之外的任意字符</td>
    	</tr>
    	<tr>
    		<td>$</td>
    		<td>ex: /^\w+$/</td>
    		<td>结束字符于模式匹配才生效</td>
    	</tr>


    	<tr>
    		<td>*</td>
    		<td>ex: /Jone (Doe)*/</td>
    		<td>0个或多个字符匹配</td>
    	</tr>
    	<tr>
    		<td>+</td>
    		<td>ex: /\w+/</td>
    		<td>表示1个或多个字符匹配</td>
    	</tr>
    	<tr>
    		<td>{max,min}</td>
    		<td>
    			匹配数字
    			ex: /\b\d{1,2}\b/
    			<br>
    			匹配4字的单词
    			ex: /\b\w{4}\b/
    		</td>
    		<td>匹配次数范围</td>
    	</tr>
    </table>
</body>
</html>











