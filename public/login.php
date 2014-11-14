<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-11 23:47:07
 * @version $Id$
 */
include_once '../sys/core/init.inc.php';
$page_title = "用户登录";
$css_files = array(
	'base.css',
	'layout.css',
	'style.css'
);
?>
<?php
	include_once 'assets/common/header.inc.php';
?>

<div id="container">
	<div class="content">
		<div class="mod login">
			<div class="mod-hd">
				<h4 class="mod-tit"><?php echo $page_title;?></h4>
			</div>
			<div class="mod-bd">
				<form class="form" action="assets/inc/process.inc.php" method="post">
					<fieldset>
		               <!-- <legend><?php echo $page_title;?></legend> -->
		               <dl>
		                   <dt><label for="user_name">用户名</label></dt>
		                    <dd><input type="text" name="user_name" id="user_name" class="text" value=""/><dd>
		                </dl>

		                <dl>
		                    <dt><label for="user_pass">密码</label></dt>
		                    <dd><input type="password" name="user_pass"  id="user_pass" class="text"/></dd>
		                </dl>

		                <div class="ctrlOptions">
		                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
		                    <input type="hidden" name="action" value="user_login"/>
		                    <input type="submit" class="btn btn_submit mr5" name="event_submit" value="登录"/>
		                    <a class="btn btn_link" href="/">注册</a>
		                </div>
		            </fieldset>
	            </form>
            </div>
		</div>
	</div>
</div>

<?php
	include_once 'assets/common/footer.inc.php';
?>
