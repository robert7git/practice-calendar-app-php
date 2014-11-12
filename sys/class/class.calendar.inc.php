<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-09 15:08:47
 * @version $Id$
 */

class Calendar extends DB_Connect {
    private $_useDate;
    private $_m;
    private $_y;
    private $_daysInMonth;
    private $_startDay;
    public function __construct($dbo=null, $useDate=null){
        parent::__construct($dbo);
        if (isset($useDate)) {
        	$this->_useDate = $useDate;
        } else {
        	$this->_useDate = date('Y-m-d H:i:s');
        }
        
        $ts = strtotime($this->_useDate);
        $this->_m = date('m',$ts);
        $this->_y = date('Y',$ts);

        $this->_daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->_m, $this->_y);

        $ts = mktime(0,0,0, $this->_m, 1, $this->_y);
        $this->_startDay = date('w', $ts);


        // $this->_loadEventData(1);
        // echo "<pre>", print_r($this->_loadEventData(1)), "</pre>";
        // echo "<pre>", print_r($this->_loadEventData()), "</pre>";
        // echo "<pre>", print_r($this->_loadEventById(1)), "</pre>";
    }
    private function _loadEventData($id=null){
    	$sql = "SELECT 
    			`event_id`, 
    			`event_title`, 
    			`event_desc`, 
    			`event_start`, 
    			`event_end`
    			FROM `events` ";
    	if (!empty($id)) {
    		$sql .= "WHERE `event_id` =:id LIMIT 1";
    	} else {
    		/*找出这个月的第一天和最后一天*/
    		$start_ts = mktime(0, 0, 0, $this->_m, 1, $this->_y);
    		$end_ts = mktime(23, 59, 59, $this->_m+1, 0, $this->_y);
    		$start_date = date('Y-m-d H:i:s', $start_ts);
    		$end_date = date('Y-m-d H:i:s', $end_ts);

    		// echo $start_date;
    		// echo $end_date;

    		/*找出当前月份的活动*/
    		$sql .= "WHERE `event_start` 
    		BETWEEN '$start_date' 
    		AND '$end_date' 
    		ORDER BY `event_start`";
    		// echo $sql;
    	}

    	try {
    		$stmt = $this->db->prepare($sql);
    		if (!empty($id)) {
    			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
    		}
    		$stmt->execute();
    		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    		$stmt->closeCursor();
    		return $results;
    	} catch (Exception $e) {
    		die($e->getMessage());
    	}
    }
    private function _loadEventById($id){
    	if (empty($id)) {
    		return null;
    	} else {
    		$event = $this->_loadEventData($id);
    		if (isset($event[0])) {
    			return new Event($event[0]);
    		} else {
    			return null;
    		}
    	}
    }
    public function displayEvent($id){
    	if (empty($id)) {
    		return null;
    	} 

    	/*确保id是整数*/
    	$id = preg_replace('/[^0-9]/', '', $id);

    	$event = $this->_loadEventById($id);
    	$ts = strtotime($event->start);
        // $date = date('F d, Y', $ts);
    	$date = date('m.d.Y', $ts);
    	$start = date('g:ia', $ts);
    	$end = date('g:ia', strtotime($event->end));

        /*若用户已登陆，显示管理操作选项*/
        $admin = $this->_adminEntryOptions($id);

    	return <<<FORM_MARKUP
        <h2>$event->title</h2>
    	\n\t<p class="dates">$date &nbsp; $start &mdash; $end</p>
    	\n\t<p>$event->description</p>
        $admin
FORM_MARKUP;
    }

    private function _createEventObj(){
    	$arr = $this->_loadEventData();
    	$events = array();
    	foreach ($arr as $event) {
    		$day = date('j', strtotime($event['event_start']));
    		try{
    			$events[$day][] = new Event($event);
    		}catch(Exception $e){
    			die($e->getMessage());
    		}
    	}
    	return $events;
    }
    public function buildCalendar(){
        // $cal_month = date('Y.M ', strtotime($this->_useDate));
    	$cal_month = date('Y . m ', strtotime($this->_useDate));
        // $weekdays = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    	$weekdays = array('日', '一', '二', '三', '四', '五', '六');
    	$html = "\n\t<h2>" . $cal_month . "</h2>";
    	for ($d=0, $labels=null;  $d<7 ; ++$d) { 
    		$labels .= "\n\t\t<li>" . $weekdays[$d] . "</li>";
    	}
    	$html .= "\n\t<ul class=\"weekdays\">"
    		. $labels 
    		. "\n\t</ul>";

    	$events = $this->_createEventObj();

    	$html .= "\n\t<ul>";
    	for ($i=1, $c=1, $t=date('j'), $m=date('m'), $y=date('Y'); $c <= $this->_daysInMonth; ++$i) { 
    		//更多步骤
    		$class = $i<=$this->_startDay ? "fill" : null;

    		if ($c+1 == $t && $m=$this->_m && $y==$this->_y) {
    			$class = "today";
    		}

    		$ls = sprintf("\n\t\t<li class=\"%s\">", $class);
    		$le = "\n\t\t</li>";

    		$event_info = null;
    		if ($this->_startDay<$i && $this->_daysInMonth>=$c) {
	    		if (isset($events[$c])) {
	    			foreach ($events[$c] as $event) {
	    				$link = '<a href="view.php?event_id=' . $event->id . '">' . $event->title . "</a>";
	    				$event_info .= "\n\t\t\t$link";
	    			}
	    		}
	    		$date = sprintf("\n\t\t\t<strong>%02d</strong>", $c++);
	    	} else {
	    		$date = "&nbsp;";
	    	}

	    	$wrap = $i!=0 && $i%7 == 0 ? "\n\t</ul>\n\t<ul>" : null;

	    	$html .=$ls . $date . $event_info . $le . $wrap;
    	}

    	while ($i%7!=1) {
    		$html .= "\n\t\t<li class=\"fill\">&nbsp;</li>";
    		++$i;
    	}
    	$html .="\n\t</ul>";

        /*若用户已登陆，显示管理操作选项*/
        $admin = $this->_adminGeneralOptions();
    	
    	return $admin . $html ;
    }

    public function displayForm(){
    	if (isset($_POST['event_id'])) {
    		$id = (int) $_POST['event_id'];
    	} else {
    		$id = null;
    		// $id = 1;
    	}

    	$submit = "添加事件";

        $form_html = "";
    	if (!empty($id)) {
    		$event = $this->_loadEventById($id);
    		if (!is_object($event)) {
    			return NULL;
    		}
    		$submit = "编辑事件";
    	}
        // $retVal = (condition) ? a : b ;
        $form_html .= '<form class="form" action="assets/inc/process.inc.php" method="post">'
            . '<fieldset>'
            .   '<legend>'. $submit . '</legend>'
            .   '<dl>'
            .       '<dt><label for="event_title">标题</label></dt>'
            .        '<dd><input type="text" name="event_title" id="event_title" class="text" value="' . $event->title . '"/><dd>'
            .    '</dl>'

            .    '<dl>'
            .        '<dt><label for="event_start">开始</label></dt>'
            .        '<dd><input type="text" name="event_start" id="event_start" class="text" value="' . $event->start . '"/></dd>'
            .    '</dl>'

            .    '<dl>'
            .        '<dt><label for="event_end">结束</label></dt>'
            .        '<dd><input type="text" name="event_end"  id="event_end" class="text" value="' . $event->end . '"/></dd>'
            .    '</dl>'

            .    '<dl>'
            .        '<dt><label for="event_description">描述</label></dt>'
            .        '<dd><textarea name="event_description" id="event_description" rows="10" cols="20"/>' . $event->description .'</textarea>'
            .        '</dd>'
            .    '</dl>'

            .    '<div class="ctrlOptions">'
            .        '<input type="hidden" name="event_id" value="' . $event->id . '"/>'
            .        '<input type="hidden" name="token" value="' . $_SESSION['token'] . '"/>'
            .        '<input type="hidden" name="action" value="event_edit"/>'
            .       '<input type="submit" class="btn btn_submit mr5" name="event_submit" value="提交"/>'
            .       '<a class="btn btn_link" href="./">取消</a>'
            .    '</div>'
            .'</fieldset>'
            .'</form>';
        return $form_html;
    }

    public function processForm(){
        if ($_POST['action'] != 'event_edit') {
            return "The method processForm was accessed incorrectly.";
        }

        /*转译表单提交过来的数据*/
        $title = htmlentities($_POST['event_title'], ENT_QUOTES);
        $desc = htmlentities($_POST['event_description'], ENT_QUOTES);
        $start = htmlentities($_POST['event_start'], ENT_QUOTES);
        $end = htmlentities($_POST['event_end'], ENT_QUOTES);

        /*如果没有活动id，就创建一个新活动*/
        if (empty($_POST['event_id'])) {
            $sql = "INSERT INTO `events`
                (`event_title`, `event_desc`, `event_start`, `event_end`)
                VALUES
                (:title, :description, :start, :end)";
        } else {
            /*数据安全，将id 转换为整数*/
            $id = (int) $_POST['event_id'];
            $sql = "UPDATE `events`
                SET 
                    `event_title` = :title,
                    `event_desc` = :description,
                    `event_start` = :start,
                    `event_end` = :end
                WHERE
                    `event_id` = $id
            ";
        }

        /*绑定数据，执行查询*/
        try {
            echo "$sql";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":description", $desc, PDO::PARAM_STR);
            $stmt->bindParam(":start", $start, PDO::PARAM_STR);
            $stmt->bindParam(":end", $end, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function _adminGeneralOptions(){
        if (isset($_SESSION['user'])) {
        return <<<ADMIN_OPTIONS
        <div class="ctrlOptions fix">
            <a class="btn btn_link fl mr5" href="admin.php"> + 添加事件</a>
        </div>
        <form action="assets/inc/process.inc.php" method="post">
            <input type="submit" class="btn btn_link fl mr5" value="退出"/>
            <input type="hidden" name="token" value="$_SESSION[token]"/>
            <input type="hidden" name="action" value="user_logout"/>
        </form>
ADMIN_OPTIONS;
        } else {
            return <<<ADMIN_OPTIONS
            <a href="login.php">登录</a>
ADMIN_OPTIONS;
        }
    }    

    private function _adminEntryOptions($id){
        if (isset($_SESSION['user'])) {
            return <<<ADMIN_OPTIONS
            <div class="ctrlOptions fix">
                <form action="admin.php" method="post">
                    <input type="submit" class="btn btn_submit fl mr5" name="edit_event" value="编辑"/>
                    <input type="hidden" name="event_id" value="$id"/>
                </form>
                <form action="confirmdelete.php" method="post">
                    <input type="submit" class="btn btn_link fl mr5" name="delete_event" value="删除"/>
                    <input type="hidden" name="event_id" value="$id"/>
                    <a class="btn btn_return btn_link fl" href="/">返回</a>
                </form>
            </div>
ADMIN_OPTIONS;
        }else{
            return null;
        }
    }

    public function confirmDelete($id){
        if (empty($id)){
           return null;
        }
        /*确保id是整数*/
        $id = preg_replace('/[^0-9]/', '', $id);

        /*如果没有活动id，就创建一个新活动*/
        // echo $_POST['confirm_delete'];
        if (isset($_POST['confirm_delete'])
            && $_POST['token'] == $_SESSION['token']) {
            if ($_POST['confirm_delete'] == "yes") {
                $sql = "DELETE FROM `events`
                WHERE
                `event_id` = :id
                LIMIT 1";

                /*绑定数据，执行查询*/
                try {
                    // echo "$sql";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                    // $stmt->bindParam(":description", $desc, PDO::PARAM_STR);
                    // $stmt->bindParam(":start", $start, PDO::PARAM_STR);
                    // $stmt->bindParam(":end", $end, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();
                    header('Location: ./');
                    return;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }else{
                header('Location: ./');
                return;
            }
        }

        $event = $this->_loadEventById($id);

        // print_r($event);
        if (!is_object($event)) {
            header('Location: ./');
        }
        return <<<CONFIRM_DELETE
            <form action="confirmdelete.php" method="post">
                <h2>确认删除？</h2>
                <div class="fix ctrlOptions">
                    <input type="submit" class="btn" name="confirm_delete" value="yes"/>
                    <input type="submit" class="btn" name="confirm_delete" value="no"/>
                    <input type="hidden" name="event_id" value="$event->id"/>
                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                </div>
            </form>
CONFIRM_DELETE;
    }
}

















