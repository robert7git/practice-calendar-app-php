/**
 * 
 * @authors R7 ()
 * @date    2014-11-13 11:23:19
 * @version $Id$
 */
// console.log("init.js was loaded successfully.");

var G={};
G.widget={}
G.widget.dialog=function(){
	var pophtml = '<div class="widget popDialog">'
					+ '<a class="close" href="javascript:void(0)"><span>关闭</span><i class="typcn typcn-times"></i></a>'
					// + '<div class="widget-hd">'
					// +	'<h4 class="widget-tit">查看事件</h4>'
					// +'</div>'
					+'<div class="widget-bd">'
					+'</div>'
				+'</div>',
		mask = '<div class="mask"></div>'

	var obj = {
		init : function(){
			var pop=null;
			if ($(".popDialog").length == 0) {
				pop = $(pophtml).appendTo("body");
			}else{
				pop = $(".popDialog");
			}
			$(".popDialog").find(".close").click(function(){
				obj.hide();
			})
			$(document).bind('click',obj.hide);
            pop.bind('click',function(e){
                e.stopPropagation();
            });
			return pop;
		},
		// _makePopHtml : function(){
		// 	$(mask).appendTo("body");
		// 	$(pophtml).appendTo("body");
		// },
		setContent : function(str){
			$(".popDialog").find(".widget-bd").append(str);
		},
		removeContent : function(str){
			$(".popDialog").find(".widget-bd").empty();
		},
		hide : function(e){
			$(".popDialog").fadeOut("10",function(){
				$(this).find(".widget-bd").empty();
			});
			$(".mask").fadeOut("10",function(){});
		},
		show : function(){
			if ($(".mask").length == 0) {
				$(mask).appendTo("body");
			};
			$(".mask").fadeIn("fast",function(){
				$(".popDialog").fadeIn("fast");
			});
		}
	};
	return {
		init : obj.init,
		setTitle : obj.setTitle,
		setContent : obj.setContent,
		removeContent : obj.removeContent,
		show : obj.show,
		hide : obj.hide
	}
}


$(function(){
	var processFile = "assets/inc/ajax.inc.php";
	$(".calendar").delegate("li>a","click",function(e){
		e.preventDefault();
		// console.log(1);
		// $(this).addClass("actived");
		var data   = $(this).attr("href").replace(/.+?\?/,""),
			dialog = G.widget.dialog();
			dialog.init();
			// console.log(dialog.init());

			// dialog.setTitle();
			// dialog.setContent();
			// console.log(data);

		$.ajax({
			type : "POST",
			url  : processFile,
			data :"action=event_view&" + data,
			// data :"action=event_view&event_id=1",
			success : function(data){
				// console.log(data);
				dialog.setContent(data);
				dialog.show();
			},
			error : function(msg){
				console.log(msg);
			}
		})
	});

/*	$("body").delegate("form","submit",function(e){
		e.preventDefault();
		var data   = "evnet_id=" + $(this).find("[name='event_id']").val(),
			dialog = G.widget.dialog();
			dialog.init();
			// console.log(data);
			$.ajax({
				type : "POST",
				url  : processFile,
				data :"action=event_edit&" + data,
				success : function(data){
					console.log(data);
					dialog.removeContent();
					dialog.setContent(data);
					dialog.show();
				},
				error : function(msg){
					console.log(msg);
				}
			})
	 	return false;
	});*/
})











