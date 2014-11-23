/**
 *
 * @authors R7 ()
 * @date    2014-11-13 11:23:19
 * @version $Id$
 */
// console.log("init.js was loaded successfully.");
var G = {};
G.tools = {};
G.process = {};
G.widget = {};
G.valid = {};
// 反序列化把表单装进数组对象中
G.valid = {
	logMsg: $('<div class="logMsg"></div>'),
	validDate: function (date) {
		var pattern = /^(\d{4}(-\d{2}){2} (\d{2})(:\d{2}){2})$/;
		//匹配返回true,失败false;
		// alert(date.match(pattern));
		return date.match(pattern) !== null;
	}
};
// 弹窗
G.widget.dialog = function () {
	var pophtml = '<div class="widget popDialog">' + '<a class="close" href="javascript:void(0)"><span>关闭</span><i class="typcn typcn-times"></i></a>' + '<div class="widget-bd">' + '</div>' + '</div>',
		mask = '<div class="mask"></div>';
	var obj = {
		init: function () {
			var pop = null;
			if ($(".popDialog").length === 0) {
				pop = $(pophtml).appendTo("body");
			} else {
				pop = $(".popDialog");
			}
			$(".popDialog").find(".close").click(function () {
				obj.hide();
			});
			$(document).on('click', '.mask', obj.hide);
			$(document).on("click", ".btn_cancel", function (e) {
				e.preventDefault();
				obj.hide();
			});
			return pop;
		},
		setContent: function (str) {
			$(".popDialog").find(".widget-bd").append(str);
		},
		setWidth: function (num) {
			$(".popDialog").css({
				"width": num,
				"margin-left": -(num / 2)
			});
		},
		removeContent: function () {
			$(".popDialog").find(".widget-bd").empty();
		},
		hide: function (e) {
			$(".popDialog").fadeOut("10", function () {
				$(this).find(".widget-bd").empty();
			});
			$(".mask").fadeOut("10", function () {});
			$(".calendar .actived").removeClass("actived");
		},
		show: function () {
			if ($(".mask").length === 0) {
				$(mask).appendTo("body");
			}
			$(".mask").fadeIn("fast", function () {
				$(".popDialog").fadeIn("fast");
			});
		}
	};
	return {
		init: obj.init,
		setTitle: obj.setTitle,
		setContent: obj.setContent,
		setWidth: obj.setWidth,
		removeContent: obj.removeContent,
		show: obj.show,
		hide: obj.hide
	};
};
// 反序列化把表单装进数组对象中
G.tools.deSerialize = function (str) {
	var tools = G.tools;
	var data = str.split("&"),
		pairs = [],
		entry = {},
		key,
		val;
	for (var x in data) {
		// console.log(data[x]);
		pairs = data[x].split("=");
		key = pairs[0];
		val = pairs[1];
		entry[key] = tools.urlDecode(val);
		// console.log(val);
	}
	// console.log(entry);
	// console.log(str);
	// console.log(data);
	// console.log(pairs);
	return entry;
};
// url解码
G.tools.urlDecode = function (str) {
	var converted = str.replace(/\+/g, ' ');
	return decodeURIComponent(converted);
};
// datepicker
G.tools.datepicker = function () {
	var $datepicker = $('.datepicker').pickadate(),
		picker = $datepicker.pickadate('picker');
	$datepicker.pickadate({
		weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		close: '关闭',
		clear: '清除',
		formatSubmit: 'yyyy-mm-dd'
	});
	picker.on({
		open: function () {
			// console.log('Opened up!')
		},
		close: function () {
			// console.log('Closed now')
		},
		render: function () {
			// console.log('Just rendered anew')
		},
		stop: function () {
			// console.log('See ya')
		},
		set: function (thingSet) {
			// console.log('Set stuff:', thingSet)
		}
	});
	return picker;
};
// datepicker
G.tools.timepicker = function () {
	var $datepicker = $('.datepicker').pickadate(),
		picker = $datepicker.pickadate('picker');
	$datepicker.pickadate({
		weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		close: '关闭',
		clear: '清除',
		formatSubmit: 'yyyy-mm-dd'
	});
	picker.on({
		open: function () {
			// console.log('Opened up!')
		},
		close: function () {
			// console.log('Closed now')
		},
		render: function () {
			// console.log('Just rendered anew')
		},
		stop: function () {
			// console.log('See ya')
		},
		set: function (thingSet) {
			// console.log('Set stuff:', thingSet)
		}
	});
	$('.timepicker').pickatime({
		clear: '清除'
	});
	return picker;
};
G.process.removeEvent = function () {
	$(".actived").remove();
};
G.process.insertEvent = function (data, formData) {
	var tools = G.tools;
	var entry = tools.deSerialize(formData);
	var cal = new Date(NaN),
		event = new Date(NaN),
		cdate = $(".calendar .calendar-date").attr("id").split("-"),
		date = entry.event_start.split(" ")[0],
		edate = date.split("-");
	// console.log(cdate);
	cal.setFullYear(cdate[1], cdate[2], 1);
	event.setFullYear(edate[0], edate[1], edate[2]);
	// event.setMinutes(event.getTimezoneOffset());
	if (cal.getFullYear() === event.getFullYear() && cal.getMonth() === event.getMonth()) {
		var day = String(event.getDate());
		day = day.length == 1 ? "0" + day : day;
		// console.log(date);
		var el = $("strong:contains(" + day + ")");
		// console.log(el);
		$("<a>").hide().attr("href", "view.php?event_id=" + data).addClass("event-tit").text(entry.event_title).insertAfter(".calendar strong:contains(" + day + ")").delay(100).fadeIn("slow");
	}
};
/*domready*/
$(function () {
	var tools = G.tools,
		process = G.process,
		valid = G.valid,
		widget = G.widget,
		picker = null, //日历对象
		dialog = widget.dialog();
	dialog.init();
	// console.log(dialog.init());
	// dialog.setTitle();
	// dialog.setContent();
	// console.log(data);
	// process.insertEvent();
	// $(document).on("submit", "#editeEvent_form", function (e) {
	// 	// 阻止表单默认提交
	// 	// $(document).on("submit", ".ctrlOptions form", function (e) {
	// 	e.preventDefault();
	// });
	var processFile = "/inc/process/ajax.inc.php";
	/*查看*/
	$(".calendar").delegate("li>a", "click", function (e) {
		e.preventDefault();
		// console.log(1);
		$(this).addClass("actived");
		var data = $(this).attr("href").replace(/.+?\?/, "");
		$.ajax({
			type: "POST",
			url: processFile,
			data: "action=event_view&" + data,
			// data :"action=event_view&event_id=1",
			success: function (data) {
				// console.log(data);
				dialog.setWidth(700);
				dialog.setContent(data);
				dialog.show();
			},
			error: function (msg) {
				console.log(msg);
			}
		});
	});
	/*添加/编辑*/
	$(document).on("click", "#btn-addEvent,#btn_eventEdite", function (e) {
		e.preventDefault();
		// console.log(e.target);
		var action = $(e.target).attr("name") || "edit_event";
		var id = $(e.target).siblings("input[name=event_id]").val();
		id = (id !== undefined) ? "&event_id=" + id : "";
		$.ajax({
			type: "POST",
			url: processFile,
			data: "action=" + action + id,
			success: function (data) {
				// console.log(data);
				dialog.removeContent();
				dialog.setContent(data);
				dialog.setWidth(500);
				dialog.show();
				//初始化datepicker;
				picker = tools.datepicker();
			},
			error: function (msg) {
				console.log(msg);
			}
		});
	});
	/*删除/提交*/
	$(document).on("click", "input[name=confirm_delete],input[name=event_submit]", function (e) {
		e.preventDefault();
		var elform = $(this).parents("form");
		// picker.get('highlight');
		// var dval = picker.get();
		var dval = picker.get('highlight', 'yyyy-mm-dd');
		console.log(dval);
		var formData = $(this).parents("form").serialize(),
			submitVal = $(this).val(),
			remove = false,
			start = $(this).parents("form").find("[name=event_start]").val(),
			end = $(this).parents("form").find("[name=event_end]").val();
		if ($(this).attr("name") == "confirm_delete") {
			formData += "&action=confirm_delete" + "&confirm_delete=" + submitVal;
			// console.log(formData);
			if (submitVal == "yes") {
				remove = true;
			}
		}
		if ($(this).siblings("[name=action]").val() == "event_edit") {
			if (!valid.validDate(start) || !valid.validDate(end)) {
				// console.log(elform.find(valid.logMsg));
				if (elform.find(valid.logMsg).length === 0) {
					valid.logMsg.text("日期格式应该是(如：YYYY-MM-DD HH:MM:SS)").prependTo(elform);
					console.log(1);
				} else {
					valid.logMsg.text("valid.logMsg:标签已经存在的情况－只替换log文字");
					// console.log("valid.logMsg:标签不存在的情况");
				}
				return false;
			}
		}
		$.ajax({
			type: "POST",
			url: processFile,
			data: formData,
			success: function (data) {
				if ($(e.target).parents("form").attr("id") === "editeEvent_form") {
					process.removeEvent();
					process.insertEvent($(e.target).siblings("input[name=event_id]").val(), formData);
					dialog.hide();
				} else if ($(e.target).parents("form").attr("id") === "addEvent_form") {
					if ($(e.target).siblings("input[name=event_id]").val().length === 0) {
						dialog.removeContent();
						dialog.setContent(data);
						process.insertEvent(data, formData);
						dialog.hide();
					}
				}
				if ($(e.target).attr("name") == "confirm_delete") {
					dialog.removeContent();
					dialog.setContent(data);
					if (remove === true) {
						process.removeEvent();
						dialog.hide();
					}
				}
			},
			error: function (msg) {
				console.log(msg);
			}
		});
	});
});