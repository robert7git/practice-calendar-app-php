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

    private $_daysInMonthNext;
    private $_daysInMonthPrev;

    public function __construct($dbo=null, $useDate=null){
        parent::__construct($dbo);
        if (isset($useDate)) {
        	$this->_useDate = $useDate;
        } else {
        	$this->_useDate = date('Y-m-d H:i:s');
            // echo $this->_useDate;
        }
        
        $ts = strtotime($this->_useDate);
        $this->_m = date('m',$ts);
        $this->_y = date('Y',$ts);
        // echo $ts;
        // echo '<br/>';
        // echo $this->_m;
        // echo '<br/>';
        // echo $this->_y;

        $this->_daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->_m, $this->_y);
        $this->_daysInMonthNext = cal_days_in_month(CAL_GREGORIAN, $this->_m + 1, $this->_y);
        $this->_daysInMonthPrev = cal_days_in_month(CAL_GREGORIAN, $this->_m - 1, $this->_y);
        // echo  $this->_daysInMonthNext;
        // echo  $this->_daysInMonthPrev;
        // echo '<br/>';
        // echo $this->_m;
        // echo '<br/>';
        // echo $this->_y;

        $ts = mktime(0,0,0, $this->_m, 1, $this->_y);
        $this->_startDay = date('w', $ts);
        // echo $this->_startDay;
        // echo "<pre>", print_r($this->_loadEventData(1)), "</pre>";
        // echo "<pre>", print_r($this->_loadEventData()), "</pre>";
        // echo "<pre>", print_r($this->_loadEventById(1)), "</pre>";
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

            // echo $start_date . "<br/>";
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
    //把事件加工成，日期索引数组的格式
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
    //查看事件
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
        <div class="mod">
            <div class="mod-hd"><h2>$event->title</h2></div>
            <div class="mod-bd">
            	\n\t<p class="dates">$date &nbsp; $start &mdash; $end</p>
            	\n\t<p>$event->description</p>
                $admin
            </div>
        </div>
FORM_MARKUP;
    }

    public function buildCalendar(){
        $cal_month = date('Y . m ', strtotime($this->_useDate));
    	$cal_id = date('Y-m ', strtotime($this->_useDate));
        $weekdays = array('日', '一', '二', '三', '四', '五', '六');
        //w3c规定id第一个字符必须是字母
    	$html = "\n\t<h2 class='calendar-date' id='month-$cal_id'>" . $cal_month . "</h2>";
    	for ($d=0, $labels=null;  $d<7 ; ++$d) { 
    		$labels .= "\n\t\t<li>" . $weekdays[$d] . "</li>";
    	}
    	$html .= "\n\t<ul class=\"weekdays\">"
    		. $labels 
    		. "\n\t</ul>";

    	$events = $this->_createEventObj();

        // echo "<pre>";
        // echo print_r($events);
        // echo "</pre>";

    	$html .= "\n\t<ul>";
        // echo date('j');
    	for ($i=1, 
            $c=1, 
            //上个月
            $j=$this->_daysInMonthPrev-$this->_startDay+1, 
            //下个月
            $k=1, 
            $t=date('j'), 
            $m=date('m'), 
            $y=date('Y');

            $c <= $this->_daysInMonth;
            // $c <= 10; 

            ++$i) { 
            // echo $i."<br>";
            // echo $i."<br>";
            // echo $c."<br>";
    		//更多步骤
    		$class = $i<=$this->_startDay ? "fill" : null;

    		if ($c == $t && $m == $this->_m && $y == $this->_y) {
    			$class = "today";
    		}
            $ls = sprintf("\n\t\t<li class=\"%s\">", $class);
    		// $ls = "\n\t\t<li class=\"$class\">";
    		$le = "\n\t\t</li>";

    		$event_info = null;

            if ($this->_startDay>=$i && $this->_daysInMonth>=$c) {
                // $date = sprintf("\n\t\t\t<strong>%02d</strong>", $c++);
                $date = $j++;
                // echo $c."<br/>";
            }elseif ($this->_startDay<$i && $this->_daysInMonth>=$c) {
                // echo $i."<br/>";
	    		if (isset($events[$c])) {
	    			foreach ($events[$c] as $event) {
	    				$link = '<a class="event-tit" title="' . $event->title . '" href="view.php?event_id=' . $event->id . '">' . $event->title . "</a>";
	    				$event_info .= "\n\t\t\t$link";
	    			}
	    		}
	    		$date = sprintf("\n\t\t\t<strong>%02d</strong>", $c++);
	    	}else {
                // $date = "&nbsp;";
                $date = $k++;
	    	}

	    	$wrap = $i!=0 && $i%7 == 0 ? "\n\t</ul>\n\t<ul>" : null;

	    	$html .=$ls . $date . $event_info . $le . $wrap;
    	}
// echo $i;
        // echo $i;
        //末尾
    	while ($i%7!=1) {
            // echo $i;
    		$html .= "\n\t\t<li class=\"fill\">$k</li>";
            ++$k;
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
    	}

    	$submit = "添加事件";

    	if (!empty($id)) {
    		$event = $this->_loadEventById($id);
    		if (!is_object($event)) {
    			return NULL;
    		}
    		$submit = "编辑事件";
            return <<<OUTPUT_HTML
                <div class="mod event_form">
                    <div class="mod-hd">
                        <h4 class="mod-tit">$submit</h4>
                    </div>
                    <div class="mod-bd">
                        <form class="form" id="editeEvent_form" action="assets/inc/process.inc.php" method="post">
                            <fieldset>
                                <dl>
                                   <dt><label for="event_title">标题</label></dt>
                                    <dd><input type="text" name="event_title" id="event_title" class="text" value="$event->title"/><dd>
                                </dl>

                                <dl>
                                    <dt><label for="event_start">开始</label></dt>
                                    <dd>
                                        <input type="text" name="event_start" id="event_start" class="text form_datetime" value="$event->start"/>
                                    </dd>
                                </dl>

                                <dl>
                                    <dt><label for="event_end">结束</label></dt>
                                    <dd>
                                        <input type="text" name="event_end"  id="event_end" class="text form_datetime" value="$event->end"/>
                                    </dd>
                                </dl>

                                <dl>
                                    <dt><label for="event_description">描述</label></dt>
                                    <dd><textarea name="event_description" id="event_description" rows="10" cols="20">$event->description</textarea>
                                    </dd>
                                </dl>

                                <div class="ctrlOptions">
                                    <input type="hidden" name="event_id" value="$event->id"/>
                                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                                    <input type="hidden" name="action" value="event_edit"/>
                                   <input type="submit" class="btn btn_submit mr5" name="event_submit" value="提交"/>
                                   <a class="btn btn_link btn_cancel" id="btn_cancel" href="./">取消</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
OUTPUT_HTML;
    	}else{
            return <<<OUTPUT_HTML
                <div class="mod event_form">
                    <div class="mod-hd">
                        <h4 class="mod-tit">
                         $submit
                        </h4>
                    </div>
                    <div class="mod-bd">
                        <form class="form" id="addEvent_form" action="assets/inc/process.inc.php" method="post">
                            <fieldset>
                                <dl>
                                    <dt><label for="event_title">标题</label></dt>
                                    <dd><input type="text" name="event_title" id="event_title" class="text" placeholder="输入标题"/></dd>
                                </dl>
                                <dl>
                                    <dt><label for="event_start">开始</label></dt>
                                    <dd>
                                        <input type="text" name="event_start" id="event_start" class="text form_datetime" placeholder="开始时间"/>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt><label for="event_end">结束</label></dt>
                                    <dd>
                                        <input type="text" name="event_end"  id="event_end" class="text form_datetime" placeholder="结束" value=""/>
                                    </dd>
                                </dl>

                                <dl>
                                    <dt><label for="event_description">描述</label></dt>
                                    <dd><textarea name="event_description" id="event_description" rows="10" cols="20" placeholder="事件描述"/></textarea>
                                    </dd>
                                </dl>

                                <div class="ctrlOptions">
                                    <input type="hidden" name="event_id"/>
                                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                                    <input type="hidden" name="action" value="event_edit"/>
                                    <input type="submit" class="btn btn_submit mr5" name="event_submit" value="提交"/>
                                    <a class="btn btn_link btn_cancel" id="btn_cancel" href="./">取消</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
OUTPUT_HTML;
        }
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

        // echo $start;

        if (!$this->_validDate($start) || !$this->_validDate($end)) {
            return "mymsg:Invalid date format! Use YYYY-MM-DD HH:MM:SS";
        }

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
            // echo "$sql";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":description", $desc, PDO::PARAM_STR);
            $stmt->bindParam(":start", $start, PDO::PARAM_STR);
            $stmt->bindParam(":end", $end, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function _adminGeneralOptions(){
        if (isset($_SESSION['user'])) {
        return <<<ADMIN_OPTIONS
        <div class="ctrlOptions fix">
            <a class="btn fl mr5" id="btn-addEvent" href="admin.php"> + 添加事件</a>
             <form action="inc/process/process.inc.php" method="post">
                <input type="submit" class="btn btn_link fl mr5" id="btn-userLogout" value="退出"/>
                <input type="hidden" name="token" value="$_SESSION[token]"/>
                <input type="hidden" name="action" value="user_logout"/>
            </form>
        </div>
ADMIN_OPTIONS;
        } else {
            return <<<ADMIN_OPTIONS
            <a class="btn btn_link fl mr5" id="btn-userLogin" href="login.php">登录</a>
ADMIN_OPTIONS;
        }
    }    

    private function _adminEntryOptions($id){
        if (isset($_SESSION['user'])) {
            return <<<ADMIN_OPTIONS
            <div class="ctrlOptions fix">
                <form action="admin.php" method="post">
                    <button type="submit" class="btn btn_edite" id="btn_eventEdite" name="edit_event">编辑</button>
                    <input type="hidden" name="event_id" value="$id"/>
                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                </form>
                <form action="confirmdelete.php" method="post">
                    <button type="submit" class="btn btn_link btn_delete" name="confirm_delete">删除</button>
                    <input type="hidden" name="event_id" value="$id"/>
                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                </form>
            </div>
ADMIN_OPTIONS;
        }else{
            return null;
        }
    }

    public function confirmDelete($id){
        if (empty($id)){
            // echo 1111;
            // echo $_POST['action'];
            //     echo $_POST['confirm_delete'];
            //     echo $_POST['event_id'];
           return null;
        }
        /*确保id是整数*/
        $id = preg_replace('/[^0-9]/', '', $id);

        /*如果没有活动id，就创建一个新活动*/
        // echo $_POST['confirm_delete'];
        if (isset($_POST['confirm_delete'])&& $_POST['token'] == $_SESSION['token']) {
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
                    // header('Location: ./');
                    return;
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }else{
                // // header('Location: ./');
                // return;
                $event = $this->_loadEventById($id);
                // print_r($event);
                if (!is_object($event)) {
                    // echo 2222;
                    // header('Location: ./');
                }
                return <<<CONFIRM_DELETE
                    <div class="mod event_form">
                        <div class="mod-hd">
                            <h4 class="mod-tit">确认删除？</h4>
                        </div>
                        <div class="mod-bd">
                            <form action="confirmdelete.php" method="post">
                                <div class="fix ctrlOptions">
                                    <input type="submit" class="btn" name="confirm_delete" value="yes"/>
                                    <input type="submit" class="btn" name="confirm_delete" value="no"/>
                                    <input type="hidden" name="event_id" value="$event->id"/>
                                    <input type="hidden" name="token" value="$_SESSION[token]"/>
                                </div>
                            </form>
                        </div>
                    </div>
CONFIRM_DELETE;
            }
        }
    }

    /*验证日期字符串
    * @param string $date
    * @return bool true,失败 false
    */
    private function _validDate($date){
        $pattern = '/^(\d{4}(-\d{2}){2} (\d{2})(:\d{2}){2})$/';
        return preg_match($pattern, $date) == 1 ? true : false;
    }
}

















