var ajax_url = base_url+'/';
var popup_box = false;
function open_popup(valname) {
    if (popup_box == false) {
        load_captcha();
        $("#" + valname).css("left", ($(window).width() - $("#" + valname).width()) / 2).fadeIn(200);
        $(".pop-overlay").fadeIn(300).css("display", "inline-block");
        popup_box = true;
    }
}
function set_loading(value) {
	if (typeof value == 'undefined' || !value) {
		$("#loading").fadeOut('slow')
	} else {
		$("#loading").fadeIn(150)
	}
}
function close_popup() {
    if (popup_box == true) {
        $(".box-pop").fadeOut(100);
        $(".pop-overlay").fadeOut(300);
        popup_box = false;
    }
}
function load_captcha() {
    var timestamp = new Date().getTime();
    $("#reg_box_ser, #reg_page img, #lost_pass img").attr('src', base_url + '/include/lib/security.php?' + timestamp);
    return false;
}
function add_fav_feature(filmid) {
    if(is_login !== '1') open_popup('login_box');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Fav_Feature: 1,
			filmid: filmid
		}, function (data) {
			set_loading(false);
			if(data == 'err') Msgbox('error','Không thể thực hiện. Phim đã tồn tại trong danh sách');
			else if(data == 'user') open_popup('login_box');
			else {
				Msgbox("success", 'Thêm thành công');
			}
		});
	}
    return false;
}
function add_fav_playlist(filmid) {
    if(is_login !== '1') open_popup('login_box');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Fav_Playlist: 1,
			filmid: filmid
		}, function (data) {
			set_loading(false);
			if(data == 'err') Msgbox('error','Không thể thực hiện. Phim đã tồn tại trong danh sách');
			else if(data == 'user') open_popup('login_box');
			else {
				Msgbox("success", 'Thêm thành công');
			}
		});
	}
    return false;
}
function remove_film(filmid,type) {
	set_loading(true);
	$.post(ajax_url, {
		RK_Remove: 1,
		filmid: filmid,
		type: type
	}, function (data) {
		set_loading(false);
		if(data) $(".film_"+filmid+'-'+type).remove();
	});
    return false;
}
var error_on = false;
function error_post(epid) {
    if(is_login !== '1') open_popup('login_box');
	else if(error_on == true) Msgbox('error','Bạn vừa báo lỗi.');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Error: 1,
			epid: epid
		}, function (data) {
			set_loading(false);
			if(data == 1) Msgbox("success", 'Báo lỗi thành công!');
			else Msgbox('error','Không thể thực hiện.');
			error_on = true;
		});
	}
    return false;
}
function support_popup() {
	var type = $("select#broken_type").val(),
		text = $("textarea#broken_error").val();
	if(!type || !text) Msgbox('notify','Chưa nhập đủ thông tin!');
    else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Support: 1,
			type: type,
			text: text
		}, function (data) {
			set_loading(false);
			if(data == 'user') Msgbox('error','Bạn chưa đăng nhập, vui lòng đăng nhập trước khi gửi yêu cầu hỗ trợ!');
			else if(data == 'err') Msgbox('error','Bạn đã gửi yêu cầu trước đó, vui lòng chờ 24h để gửi yêu cầu tiếp theo!');
			else if(data == 'done') Msgbox('success','Yêu cầu đã được gửi. Cảm ơn bạn đã sử dụng chức năng');
			else Msgbox('error','Lỗi hệ thống, bạn không thể thực hiện yêu cầu vào lúc này.');
		});
	}
    return false;
}
function load_vote(star,filmid) {
	if(is_login !== '1') open_popup('login_box');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Votes: 1,
			star: star,
			filmid: filmid
		}, function (data) {
			set_loading(false);
			if(data == 'err') Msgbox('error','Không thể thực hiện. Bạn đã bình chọn rồi');
			else if(data == 'user') open_popup('login_box');
			else {
				$(".unvote-line .vote-line").animate({"width": star+'0%'},100);
				$(".unvote-line .vote-line-hv").remove();
				$(".vote .vote-stats").html('('+data+' lượt bình chọn)');
			}
		});
	}
    return false;
}
(function ($) {
    $.jNotify = {
        defaults: {
            autoHide: true,
            clickOverlay: false,
            MinWidth: 200,
            TimeShown: 1500,
            ShowTimeEffect: 200,
            HideTimeEffect: 200,
            LongTrip: 15,
            HorizontalPosition: 'right',
            VerticalPosition: 'bottom',
            ShowOverlay: true,
            ColorOverlay: '#000',
            OpacityOverlay: 0.3,
            onClosed: null,
            onCompleted: null
        },
        init: function (msg, options, id) {
            opts = $.extend({}, $.jNotify.defaults, options);
            if ($("#" + id).length == 0) $Div = $.jNotify._construct(id, msg);
            WidthDoc = parseInt($(window).width());
            HeightDoc = parseInt($(window).height());
            ScrollTop = parseInt($(window).scrollTop());
            ScrollLeft = parseInt($(window).scrollLeft());
            posTop = $.jNotify.vPos(opts.VerticalPosition);
            posLeft = $.jNotify.hPos(opts.HorizontalPosition);
            if (opts.ShowOverlay && $("#jOverlay").length == 0) $.jNotify._showOverlay($Div);
            $.jNotify._show(msg);
        },
        _construct: function (id, msg) {
            $Div = $('<div id="' + id + '"/>').css({
                opacity: 0,
                minWidth: opts.MinWidth
            }).html(msg).appendTo('body');
            return $Div;
        },
        vPos: function (pos) {
            switch (pos) {
            case 'top':
                var vPos = ScrollTop + parseInt($Div.outerHeight(true) / 2);
                break;
            case 'center':
                var vPos = ScrollTop + (HeightDoc / 2) - (parseInt($Div.outerHeight(true)) / 2);
                break;
            case 'bottom':
                var vPos = ScrollTop + HeightDoc - parseInt($Div.outerHeight(true));
                break;
            }
            return vPos;
        },
        hPos: function (pos) {
            switch (pos) {
            case 'left':
                var hPos = ScrollLeft;
                break;
            case 'center':
                var hPos = ScrollLeft + (WidthDoc / 2) - (parseInt($Div.outerWidth(true)) / 2);
                break;
            case 'right':
                var hPos = ScrollLeft + WidthDoc - parseInt($Div.outerWidth(true));
                break;
            }
            return hPos;
        },
        _show: function (msg) {
            $Div.css({
                top: posTop,
                left: posLeft
            });
            switch (opts.VerticalPosition) {
            case 'top':
                $Div.animate({
                    top: posTop + opts.LongTrip,
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted();
                });
                if (opts.autoHide) $.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    $.jNotify._close();
                });
                break;
            case 'center':
                $Div.animate({
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted();
                });
                if (opts.autoHide) $.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    $.jNotify._close();
                });
                break;
            case 'bottom':
                $Div.animate({
                    top: posTop - opts.LongTrip,
                    opacity: 1
                }, opts.ShowTimeEffect, function () {
                    if (opts.onCompleted) opts.onCompleted();
                });
                if (opts.autoHide) $.jNotify._close();
                else $Div.css('cursor', 'pointer').click(function (e) {
                    $.jNotify._close();
                });
                break;
            }
        },
        _showOverlay: function (el) {
            var overlay = $('<div id="jOverlay" />').css({
                backgroundColor: opts.ColorOverlay,
                opacity: opts.OpacityOverlay
            }).appendTo('body').show();
            if (opts.clickOverlay) overlay.click(function (e) {
                e.preventDefault();
                opts.TimeShown = 0;
                $.jNotify._close();
            });
        },
        _close: function () {
            switch (opts.VerticalPosition) {
            case 'top':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    top: posTop - opts.LongTrip,
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    $(this).remove();
                    if (opts.ShowOverlay && $("#jOverlay").length > 0) $("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed();
                });
                break;
            case 'center':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    $(this).remove();
                    if (opts.ShowOverlay && $("#jOverlay").length > 0) $("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed();
                });
                break;
            case 'bottom':
                if (!opts.autoHide) opts.TimeShown = 0;
                $Div.stop(true, true).delay(opts.TimeShown).animate({
                    top: posTop + opts.LongTrip,
                    opacity: 0
                }, opts.HideTimeEffect, function () {
                    $(this).remove();
                    if (opts.ShowOverlay && $("#jOverlay").length > 0) $("#jOverlay").remove();
                    if (opts.onClosed) opts.onClosed();
                });
                break;
            }
        },
        _isReadable: function (id) {
            if ($('#' + id).length > 0) return false;
            else return true;
        }
    };
    jNotify = function (msg, options) {
        if ($.jNotify._isReadable('jNotify')) $.jNotify.init(msg, options, 'jNotify');
    };
    jSuccess = function (msg, options) {
        if ($.jNotify._isReadable('jSuccess')) $.jNotify.init(msg, options, 'jSuccess');
    };
    jError = function (msg, options) {
        if ($.jNotify._isReadable('jError')) $.jNotify.init(msg, options, 'jError');
    };
})(jQuery);
var play_rkmedia = false,
	download_video = false,
	rk_light = false;
function onjwplayer(link,captions,nextid) {
    var plugins = "timeslidertooltipplugin,http://127.0.0.1/player/plugins/proxy.swf,http://127.0.0.1/content/template/jwplayer/captions.swf",
        player = "http://127.0.0.1/player/player.swf",
		skin = "http://127.0.0.1/content/template/jwplayer/skin/skins.xml";
    jwplayer("rkplayer").setup({
        flashplayer: player,
        plugins: plugins,
        "proxy.link": link,
		"proxy.image": 'http://socghe.com/content/template/images/cover.jpg',
        "stretching": "uniform",
        //"bufferlength": "50",
        "controlbar": "bottom",
        "captions.file": captions,
        "captions.color": "#FFff80",
        "captions.fontFamily": "Arial",
        "captions.fontSize": "20",
		"controlbar":"over",
		"proxy.reloader": false,
		controlbar: "bottom",
        skin: skin,
        width: "100%",
        height: "100%",
        provider: 'http',
        autostart: "true",
		events: {
			onComplete: function() {
				if(nextid) {
					next_url = $('.episodelist a#episode_'+nextid).attr('href');
					window.location.href = next_url;
				}
			},
			onPlay: function() {
				if(rk_light == false) {
					$("#lightout").click();
					rk_light = true;
				}
				if(play_rkmedia == true) load_datadownload();
			}
		}
    });
}
function getVideoLink(){	
	var currentIndex = thisMovie("rkplayer").jwGetPlaylistIndex();	
	var item = thisMovie("rkplayer").getPlaylist()[currentIndex];	
	return item.file;
}
function thisMovie(movieName) {	
	if (navigator.appName.indexOf("Microsoft") != -1) {	
		return window[movieName];	
	}else{	
		return document[movieName];	
	}
}
function load_datadownload(epid) {
	if(download_video == false) {
		$('.download-box').show().html("<img src='"+base_url+"/content/template/images/loading.gif'> Đang tải, vui lòng chờ trong giây lát ...");
		$.post(ajax_url, {
			RK_Download: 1,
			epid: epid
		}, function (data) {
			if(data) {
				$('.download-box').html('Chọn chất lượng phim sau đó nhấn chuột phải để lưu phim về máy<br />'+data);
				download_video = true;
			}
			else {
				play_rkmedia = true;
				var link = getVideoLink();
				if(link) $('.download-box').html("Nhấn chuột phải <a href='"+link+"' title='Tải video này' target='_blank'>vào đây</a> để lưu phim về máy.");
			}
		});
	}
	return false;
}
function Msgbox(type, msg) {
    if (type == "notify") {
        jNotify(msg, {
            autoHide: true,
            clickOverlay: true,
            TimeShown: 3000,
            LongTrip: 20,
            HorizontalPosition: 'center',
            VerticalPosition: 'center',
            OpacityOverlay: 0.8
        })
    } else if (type == "success") {
        jSuccess(msg, {
            autoHide: true,
            clickOverlay: true,
            TimeShown: 3000,
            LongTrip: 20,
            HorizontalPosition: 'center',
            VerticalPosition: 'center',
            OpacityOverlay: 0.8
        })
    } else {
        jError(msg, {
            autoHide: true,
            clickOverlay: true,
            TimeShown: 3000,
            LongTrip: 20,
            HorizontalPosition: 'center',
            VerticalPosition: 'center',
            OpacityOverlay: 0.8
        })
    }
}
function do_search () {
    kw = $("#keyword").val();
    if (!kw || kw == "Tìm kiếm...") {
        Msgbox("notify", 'Bạn chưa nhập từ khóa')
    } else {
        kw = encodeURIComponent(kw);
        kw = kw.replace(/%20/g, '-');
        window.location.href = base_url + '/search/' + kw + '/'
    };
    return false
}
function reg_ajax() {
    var username = $("#reg_box #r_username").val(),
		password = $("#reg_box #r_pass").val(),
		confirmpass = $("#reg_box #r_confirmpass").val(),
		email = $("#reg_box #r_email").val(),
		captcha = $("#reg_box #r_security").val(),
		agree = $("#reg_box #agree:checked").val();
	if(!username || !password || !confirmpass || !email || !captcha) Msgbox('notify','Chưa nhập đủ thông tin!');
	else if(!agree) Msgbox('notify','Bạn chưa đồng ý quy định của chúng tôi');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Registry: 1,
			username: username,
			password: password,
			confirmpass: confirmpass,
			email: email,
			captcha: captcha
		}, function (data) {
			set_loading(false);
			if(data == 'user') Msgbox('error','Tên đăng nhập đã tồn tại');
			else if(data == 'email') Msgbox('error','Địa chỉ email không hợp lệ hoặc đã được đăng ký');
			else if(data == 'confirmpass') Msgbox('error','Mật khẩu không trùng khớp');
			else if(data == 'password') Msgbox('error','Mật khẩu phải có độ dài từ 6 đến 15 ký tự');
			else if(data == 'captcha') Msgbox('error','Mã bảo mật không đúng');
			else if(data == 'done') {
				Msgbox('success','Đăng ký hoàn tất. Bạn có thể đăng nhập với tài khoản vừa đăng ký!');
				load_captcha();
			}
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
    return false;
}
function reg_ajax_page() {
    var username = $("#reg_page #r_username").val(),
		password = $("#reg_page #r_pass").val(),
		confirmpass = $("#reg_page #r_confirmpass").val(),
		email = $("#reg_page #r_email").val(),
		captcha = $("#reg_page #r_security").val(),
		agree = $("#reg_page #agree:checked").val();
	if(!username || !password || !confirmpass || !email || !captcha) Msgbox('notify','Chưa nhập đủ thông tin!');
	else if(!agree) Msgbox('notify','Bạn chưa đồng ý quy định của chúng tôi');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Registry: 1,
			username: username,
			password: password,
			confirmpass: confirmpass,
			email: email,
			captcha: captcha
		}, function (data) {
			set_loading(false);
			if(data == 'user') Msgbox('error','Tên đăng nhập đã tồn tại');
			else if(data == 'email') Msgbox('error','Địa chỉ email không hợp lệ hoặc đã được đăng ký');
			else if(data == 'confirmpass') Msgbox('error','Mật khẩu không trùng khớp');
			else if(data == 'password') Msgbox('error','Mật khẩu phải có độ dài từ 6 đến 15 ký tự');
			else if(data == 'captcha') Msgbox('error','Mã bảo mật không đúng');
			else if(data == 'done') {
				Msgbox('success','Đăng ký hoàn tất. Bạn có thể đăng nhập với tài khoản vừa đăng ký!');
				load_captcha();
			}
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
    return false;
}
function login_ajax() {
	var username = $("#login_box #l_user").val(),
		password = $("#login_box #l_pass").val(),
		remember = $("#login_box #l_rmb:checked").val();
	if(!username || !password) Msgbox('notify','Chưa nhập đủ thông tin!');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Login: 1,
			username: username,
			password: password,
			remember: remember
		}, function (data) {
			set_loading(false);
			if(data == 'user') Msgbox('error','Tài khoản hoặc email không chính xác');
			else if(data == 'pass') Msgbox('error','Mật khẩu khống đúng');
			else if(data == 'done') location.reload();
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
    return false;
}
function login_ajax_page() {
	var username = $("#login_page #l_user").val(),
		password = $("#login_page #l_pass").val(),
		remember = $("#login_page #l_rmb:checked").val();
	if(!username || !password) Msgbox('notify','Chưa nhập đủ thông tin!');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Login: 1,
			username: username,
			password: password,
			remember: remember
		}, function (data) {
			set_loading(false);
			if(data == 'user') Msgbox('error','Tài khoản hoặc email không chính xác');
			else if(data == 'pass') Msgbox('error','Mật khẩu khống đúng');
			else if(data == 'done') window.location.href = base_url;
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
    return false;
}
function logout_site() {
	set_loading(true);
	$.post(ajax_url, {
		RK_Logout: 1,
	}, function (data) {
		set_loading(false);
		if(data == '1') location.reload();
		else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
	});
    return false;
}
function lost_ajax_page() {
	var email = $("#lost_pass #email").val(),
		captcha = $("#lost_pass #security").val();
	if(!email || !captcha) Msgbox('notify','Chưa nhập đủ thông tin!');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Forgot: 1,
			email: email,
			captcha: captcha
		}, function (data) {
			set_loading(false);
			if(data == 'captcha') Msgbox('error','Sai mã bảo mật.');
			else if(data == 'email') Msgbox('error','Không tồn tại email');
			else if(data == 'done') {
				Msgbox('success','Yêu cầu đã được gửi. Bạn vui lòng chờ email xác nhận từ admin.');
				load_captcha();
			}
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
    return false;
}
function edit_user() {
	var fullname = $("#edit_user #fullname").val(),
		facebookid = $("#edit_user #facebookid").val(),
		captcha = $("#edit_user #security").val();
	if(!fullname || !facebookid || !captcha) Msgbox('notify','Chưa nhập đủ thông tin!');
	else {
		set_loading(true);
		$.post(ajax_url, {
			RK_Edituser: 1,
			fullname: fullname,
			facebookid: facebookid,
			captcha: captcha
		}, function (data) {
			set_loading(false);
			if(data == 'captcha') Msgbox('error','Sai mã bảo mật.');
			else if(data == 'done') location.reload();
			else Msgbox('error','Lỗi hệ thống, bạn vui lòng liên hệ với hỗ trợ viên để biết thêm chi tiết');
		});
	}
}
var RKLIST = {
    init: function () {
        $(document).ready(function (e) {
            $(".btn-filter").fadeToggle(300);
            $(".fitter_title").click(function (e) {
                $(this).parent().parent().find("div.show-list").fadeToggle(200);
                return false
            });
            $(".fitter-box").click(function (e) {
                $(".fitter-box-data").fadeToggle(300);
                return false
            });
            $(".filter-click").click(function (e) {
                $(".filter-type, .btn-filter").fadeToggle(300);
                $(".filter-type").removeClass("hidden")
            });
            $(".bycountry a").click(function (e) {
                $("#bycountry").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active")
            });
            $(".bycat a").click(function (e) {
                $("#bycat").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active")
            });
            $(".byfilmlb a").click(function (e) {
                $("#byfilmlb").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active")
            });
            $(".byquality a").click(function (e) {
                $("#byquality").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active")
            });
            $(".byyear a").click(function (e) {
                $("#byyear").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active")
            });
            $(".byorder a").click(function (e) {
                $("#byorder").val($(this).data('value'));
                $(this).parent().find("a").removeClass("active");
                $(this).addClass("active");
                if ($(".filter-type").css("display") != "block") {
                    RKLIST.load_filter()
                }
            });
            $(".btn-filter").click(function (e) {
                RKLIST.load_filter();
				return false;
            })
        })
    },
    load_filter: function () {
        var bcat = $("#bycat").val();
        var bcty = $("#bycountry").val();
        var bquality = $("#byquality").val();
        var byear = $("#byyear").val();
        var border = $("#byorder").val();
        var op = new Array();
        if (bcat) {
            op.push("bycat=" + bcat)
        };
        if (bcty) {
            op.push("bycountry=" + bcty)
        };
        if (bquality) {
            op.push("byquality=" + bquality)
        };
        if (byear) {
            op.push("byyear=" + byear)
        };
        if (border) {
            op.push("byorder=" + border)
        };
        if (op.length > 0) {
            var href = window.location.href;
            if (href.indexOf("?") > 0) {
                href = href.substr(0, href.indexOf("?"))
            };
            var option = "?" + op.join("&");
			set_loading(true);
            window.location.href = href + option
        };
        return false;
    },
    listshow: function (type) {
        Msgbox("error", "Tính năng đang xây dựng.")
    }
};
var RKINFO = {
    init: function () {
        $(document).ready(function ($) {})
    },
    list_load: function (id, items, num) {
        var list = [];
        $(id + " " + items).find("li").each(function () {
            list.push($(this).html())
        });
        if (list.length > num) {
            $(id + " " + items).html("");
            for (var i = 0; i < num; i++) {
                $(id + " " + items).append("<li>" + list[i] + "</li>").fadeIn()
            };
            $(id + " .control .btn-back").attr("rel", "disable")
        } else {
            $(id + " .control").fadeOut(100)
        };
        var now = 0;
        $(id + " .control .btn-next").click(function () {
            if ($(this).attr("rel") == "disable") {
                return false
            };
            $(id + " " + items).html("");
            now++;
            for (var i = now * num; i < ((now + 1) * num); i++) {
                if (list[i]) $(id + " " + items).append("<li>" + list[i] + "</li>").fadeIn()
            };
            if ((now + 1) * num >= list.length) {
                $(id + " .control .btn-next").attr("rel", "disable")
            };
            if (now != 0) {
                $(id + " .control .btn-back").attr("rel", "none")
            };
            return false
        });
        $(id + " .control .btn-back").click(function () {
            if ($(this).attr("rel") == "disable") {
                return false
            };
            $(id + " " + items).html("");
            now--;
            for (var i = now * num; i < ((now + 1) * num); i++) {
                if (list[i]) $(id + " " + items).append("<li>" + list[i] + "</li>").fadeIn()
            };
            if (now * num <= 0) {
                $(id + " .control .btn-back").attr("rel", "disable")
            };
            if (now >= 0) {
                $(id + " .control .btn-next").attr("rel", "none")
            };
            return false
        })
    }
};
function search_key() {
    $("#keyword").keyup(function (event) {
        var obj = $("#search .ui-autocomplete");
        var objnor = $("#search .ui-autocomplete li");
        var objsel = $("#search .ui-autocomplete li.active");
        if (event.which == 40) {
            if (objsel.length == 0) {
                objnor.first().next().addClass('active')
            } else if (objsel.length > 0) {
                objsel.next().addClass('active');
                objsel.first().removeClass('active')
            };
            return
        };
        if (event.which == 38) {
            if (objsel.length == 0) {
                objnor.last().addClass('active')
            } else if (objsel.length > 0) {
                objsel.prev().addClass('active');
                objsel.last().removeClass('active')
            };
            return
        };
        if (event.which == 13) {
            if (objsel.length > 0) {
                var slink = objsel.find("a").attr("href");
                if (slink) {
                    window.location.href = slink
                }
            }
        };
        if ($("#keyword").val().length > 0) {
            var search = $("#keyword").val();
            var obj = $("#search .search_value");
            obj.find(".ui-autocomplete").html("");
            var result = new Array();
            $.map(ins_search, function (value, key) {
                if (value.title_ascii.indexOf(search) >= 0 || value.title_real.toLowerCase().indexOf(search) >= 0 || value.title.indexOf(search) >= 0) {
                    result.push('<li class="ui-menu-item"><a href="' + value.link + '" title="' + value.title + ' - ' + value.title_real + '"><img src="' + value.img + '" /><span class="title">' + value.title + ' (' + value.year + ')<br/>' + value.title_real + '</span></a></li>')
                }
            });
            var kw = encodeURIComponent(search);
            kw = kw.replace(/%20/g, '-');
            var slink = base_url + "/search/" + kw + "/";
            if (result.length) {
                obj.find("#search_movie").append('<li class="ui-autocomplete-category"><span>Phim (' + result.length + ')' + (result.length > 5 ? '</span><span class="all-movies"><a href="' + slink + '">Tất cả</a></span>' : '') + '</li>');
                for (var y = 0; y < 5; y++) {
                    if (result[y]) {
                        obj.find("#search_movie").append(result[y])
                    }
                }
            };
            var resulta = new Array();
            $.map(ins_actor, function (value, key) {
                if (value.name_ascii.indexOf(search) >= 0 || value.name.toLowerCase().indexOf(search) >= 0 || value.name_other.indexOf(search) >= 0) {
                    resulta.push('<li class="ui-menu-item"><a href="' + value.link + '" title="' + value.name + '"><img src="' + value.img + '" />' + value.name + '</a></li>')
                }
            });
            if (resulta.length) {
                obj.find("#search_actor").append('<li class="ui-autocomplete-category"><span>Diễn viên (' + resulta.length + ')' + (resulta.length > 5 ? '</span><span class="all-movies"><a href="' + slink + '">Tất cả</a></span>' : '') + '</li>');
                for (var z = 0; z < 5; z++) {
                    if (resulta[z]) {
                        obj.find("#search_actor").append(resulta[z])
                    }
                }
            };
            if (result.length == 0 && resulta.length == 0) {
                obj.fadeIn();
                obj.find(".ui-autocomplete").fadeIn();
                obj.find("#search_actor").fadeOut("fast");
                obj.find("#search_movie").css("width", "100%");
                obj.find("#search_movie").append('<li class="ui-menu-item"><a><span class="title">Nhấn enter để tìm kiếm.</span></a></li>')
            } else {
                obj.fadeIn();
                obj.find(".ui-autocomplete").fadeIn();
                if (result.length > 0 && resulta.length == 0) {
                    obj.find("#search_actor").fadeOut("fast");
                    obj.find("#search_movie").css("width", "100%")
                } else if (result.length == 0 && resulta.length > 0) {
                    obj.find("#search_movie").fadeOut("fast");
                    obj.find("#search_actor").css("width", "100%")
                } else {
                    obj.find(".ui-autocomplete").css("width", "50%")
                }
            }
        } else {
            obj.fadeOut()
        }
    })
}
$(document).ready(function () {
	search_key();
	RKINFO.list_load(".actors",".actor_list",2);
	RKINFO.list_load(".directors",".dir_list",2);
	$(".screenshot-items").carouFredSel({
		circular: false,
		infinite: false,
		auto: false,
		width: "98%",
		prev: {
			button: ".wap-screenshot .screen-prev",
			key: "left"
		},
		next: {
			button: ".wap-screenshot .screen-next",
			key: "right"
		}
	});
	$(".head_search").click(function (e) {
		$("#box_search").fadeIn("fast");
		$("#box_search").css("left", ($(window).width() - $("#box_search").width()) / 2);
		$("#keyword").focus()
	});
	$("#keyword").focusout(function () {
		$(".search_value").fadeOut("fast")
	});
	$("#login_box input.btn-login").click(function () {
		login_ajax();
		return false;
    });
	$("#login_page input[type='submit']").click(function () {
		login_ajax_page();
		return false;
    });
	$("#reg_box input.btn-login").click(function () {
		reg_ajax();
		return false;
    });
	$("#reg_page input[type='submit']").click(function () {
		reg_ajax_page();
		return false;
    });
	$("#lost_pass input[type='submit']").click(function () {
		lost_ajax_page();
		return false;
    });
	$(".user_conner .logout_site").click(function () {
		logout_site();
		return false;
    });
	$("#edit_user input[type='submit']").click(function () {
		edit_user();
		return false;
    });
	$(".box-email").click(function () {
		if (popup_box == false) {
			$("#popup-section").css("left", ($(window).width() - $("#popup-section").width()) / 2).fadeIn(200);
			$(".pop-overlay").fadeIn(300).css("display", "inline-block");
			popup_box == true;
		}else {
			$(".pop-overlay").click();
			$("#popup-section").css("left", ($(window).width() - $("#popup-section").width()) / 2).fadeIn(200);
			$(".pop-overlay").fadeIn(300).css("display", "inline-block");
			popup_box == true;
		}
		return false;
    });
	$("#popup-section input[type='button']").click(function () {
		support_popup();
		return false;
    });
	$(".add_fav_feature, #add_fav_feature, .bxh-control-cong").click(function () {
		var filmid = $(this).attr('data-id');
		add_fav_feature(filmid);
		return false;
	});
	$("#add_fav_playlist").click(function () {
		var filmid = $(this).attr('data-id');
		add_fav_playlist(filmid);
		return false;
	});
	var lightout = false;
	$("#lightout,#plugin_lightout").click(function () {
		if(lightout == false) {
			$("#plugin_lightout").css("opacity",.89).fadeIn();
			$("#lightout").html('Bật đèn');
			lightout = true;
		}else {
			$("#plugin_lightout").fadeOut();
			$("#lightout").html('Tắt đèn');
			lightout = false;
		}
		return false;
	});
	var zoombtn = false;
	$("#zoombtn").click(function () {
		if(zoombtn == false) {
			$(".watch-now .player").animate({"width": "100%", "height": "600px"},200);
			$("#zoombtn").html('Thu nhỏ');
			zoombtn = true;
		}else {
			$(".watch-now .player").animate({"width": "900px", "height": "500px"},100);
			$("#zoombtn").html('Phóng to');
			zoombtn = false;
		}
		return false;
	});
	$("#binh-luan").click(function () {
		$('html,body').animate({ scrollTop: $('.comment-box').offset().top - 60}, 'slow');
		return false;
	});
	$("#tai-phim").click(function () {
		var epid = $(this).attr('data-id');
		load_datadownload(epid);
		return false;
	});
	$("#errorbtn").click(function () {
		var epid = $(this).attr('data-id');
		error_post(epid);
		return false;
	});
    $("#navigation li").hover(function () {
        var valname = $(this).attr('class');
        $(this).addClass('active');
    }, function () {
        $(this).removeClass('active');
    });
	var show_readmore = false;
	$("a.readmore-js-toggle").click(function () {
		height = $(".box-info .fdesc p").height();
		if(show_readmore == false) {
			$(this).html("« Thu gọn");
			$(".box-info .fdesc").animate({"height": height},100);
			show_readmore = true;
		}else {
			$(this).html("Xem tiếp »");
			$(".box-info .fdesc").animate({"height": "60px"},100);
			show_readmore = false;
		}
		return false;
	});
    $("li .head_search").click(function () {
		$(".pop-overlay").fadeIn(300).css("display", "inline-block");
        $('#box_search').css("left", ($(window).width() - $("#box_search").width()) / 2).fadeIn(100);
		$('#keyword').focus();
    });
    $(".close-box-search, .pop-overlay, #popup-section .close-box").click(function (e) {
        $("#box_search").fadeOut(100);
        $(".pop-overlay").fadeOut(300);
		$("#popup-section").fadeOut(300);
		
    });
    $(".show_pop").click(function (e) {
        var valname = $(this).attr('rel');
        open_popup(valname);
        return false;
    });
	$("#search_form .search_submit").click(function (e) {
        do_search ();
        return false;
    });
    $(".close-box, .pop-overlay").click(function (e) {
        close_popup();
        return false;
    });
    $("#feature .caroufredsel_wrapper").height($("#wrapper").width() / 2.66 + 1);
    $('.btn_hide,.play_btn_big,.meta_feature').hover(function () {
        $('.play_btn_big,.add_fav_feature,.view_fav_feature,.btn_pre_ft,.btn_next_ft').addClass('hover_jquery')
    }, function () {
        $('.play_btn_big,.add_fav_feature,.view_fav_feature,.btn_pre_ft,.btn_next_ft').removeClass('hover_jquery')
    });
	$(".short-img a[rel^='screen']").prettyPhoto({
		social_tools: '',
		allow_resize: true
	});
	var subw = $(window).width() * 0.9;
	if (subw >= 900) {
		$("#full-mn-phim-le .mn-last,#full-mn-phim-bo .mn-last,#full-mn-boxtv .mn-last").show();
		$("#full-mn-phim-le .mn-last").width(subw - 550);
		$("#full-mn-phim-bo .mn-last").width(subw - 550);
		$("#full-mn-boxtv .mn-last").width(subw - 510)
	} else {
		$("#full-mn-phim-le .mn-last,#full-mn-phim-bo .mn-last,#full-mn-boxtv .mn-last").hide()
	} 
	$("#mainVideo").each(function () {
		var width_btn = 100;
		var w = $(this).parent().width() - width_btn;
		var mR = $(this).find("ul li").stop().css("marginRight");
		var mL = $(this).find("ul li").stop().css("marginLeft");
		var mT = $(this).find("ul li").stop().css("marginTop");
		var mB = $(this).find("ul li").stop().css("marginBottom");
		mR = 5;
		if (mL) {
			mL = mL.replace('px', '')
		} else {
			mL = 0
		}; if (mT) {
			mT = mT.replace('px', '')
		} else {
			mT = 0
		}; if (mB) {
			mB = mB.replace('px', '')
		} else {
			mB = 0
		};
		var marginR = Number(mR) + Number(mL);
		var marginT = Number(mT) + Number(mB);
		var wli = $(this).find("ul li").stop().width() + marginR;
		var hli = $(this).find("ul li").stop().height() + marginT;
		var nw = 0;
		var limovie = 178;
		for (var i = 1; i <= Math.round(w / limovie); i++) {
			nw = i * limovie;
			if (nw > w) {
				nw = (i - 1) * limovie;
				break
			}
		};
		var items = $(this).find("ul li").size();
		$(this).width(nw);
		$(this).css("padding-left", "0px");
		$(this).css("margin-left", (w - nw) / 2 + "px");
		var scroll_obj = $(this).find(".scroll").stop();
		scroll_obj.width(nw - 16);
		scroll_obj.css("margin-left", (width_btn + 16) / 2 + "px");
		var scrolls = $(this).find("ul").stop();
		scrolls.width(nw + width_btn);
		scrolls.css("margin-left", "0px");
		var destitle = $("div[rel^='" + scrolls.attr("id") + "']");
		destitle.width(nw + width_btn);
		destitle.find("span").stop().css("margin-left", (width_btn + 16) / 2 + "px");
		destitle.find("h2").stop().css("margin-left", (width_btn + 16) / 2 + "px");
		destitle.find("h3").stop().css("margin-left", (width_btn + 16) / 2 + "px");
		destitle.css("margin-left", (w + width_btn - (nw + width_btn)) / 2 + "px");
		var realnw = 0;
		var listnow = 0;
		for (var c = 1; c <= (nw) / wli; c++) {
			realnw = c * wli;
			listnow = c;
			if (realnw > w) {
				listnow = c - 1;
				realnw = (i - 1) * wli;
				break
			}
		};
		var mar = Number((nw - 16 - realnw) / (listnow)) + Number(mR);
		mar = (mar * listnow) / (listnow - 1);
		$(this).find("ul li").each(function (index, element) {
			$(this).css("margin-right", mar + "px");
			if ((index + 1) % listnow == 0) {
				$(this).css("margin-right", "0px")
			}
		})
	});
	$(".spec_block").each(function () {
		var e = 100;
		if ($(this).hasClass("l-items")) return;
		var t = $(this).parent().width() - e;
		var n = $(this).find("ul li").stop().css("marginRight");
		var r = $(this).find("ul li").stop().css("marginLeft");
		var i = $(this).find("ul li").stop().css("marginTop");
		var s = $(this).find("ul li").stop().css("marginBottom");
		n = 0;
		if (r) {
			r = r.replace("px", "")
		} else {
			r = 0
		}
		if (i) {
			i = i.replace("px", "")
		} else {
			i = 0
		}
		if (s) {
			s = s.replace("px", "")
		} else {
			s = 0
		}
		var o = Number(n) + Number(r);
		var u = Number(i) + Number(s);
		var a = $(this).find("ul li").stop().width() + o;
		var f = $(this).find("ul li").stop().height() + u;
		var l = 0;
		var c = 178;
		for (var h = 1; h <= Math.round(t / c); h++) {
			l = h * c;
			if (l > t) {
				l = (h - 1) * c;
				break
			}
		}
		var p = $(this).find("ul li").size();
		$(this).width(l + e);
		$(this).css("margin-left", (t - l) / 2 + "px");
		var d = $(this).find(".scroll_list").stop();
		d.width(l - 16);
		d.css("margin-left", (e + 16) / 2 + "px");
		var v = $(this).find("ul").stop();
		v.width((p + 1) * c / 2);
		v.css("margin-left", "0px");
		var m = $("div[rel^='" + v.attr("id") + "']");
		m.width(l + e);
		m.find("span").stop().css("margin-left", (e + 16) / 2 + "px");
		m.find("h2").stop().css("margin-left", (e + 16) / 2 + "px");
		m.find("h3").stop().css("margin-left", (e + 16) / 2 + "px");
		m.css("margin-left", (t + e - (l + e)) / 2 + "px");
		var g = 0;
		var y = 0;
		for (var b = 1; b <= l / a; b++) {
			g = b * a;
			y = b;
			if (g > t) {
				y = b - 1;
				g = (h - 1) * a;
				break
			}
		}
		var w = Number((l - 16 - g) / y) + Number(n);
		w = w * y / (y - 1);
		if (p < y) {
			$(this).height(f);
			d.height(f)
		} else {
			$(this).height(2 * f);
			d.height(2 * f)
		}
		if (p >= y * 2) {
			$(this).find("ul li").each(function (e, t) {
				$(this).css("margin-right", w + "px")
			})
		} else {
			$(this).find("ul li").fadeIn();
			$(this).find("ul li").css("margin-right", w + "px")
		}
		v.width((p + 1) * (a + w) / 2);
		var E = $(this).find(".wrap_next_block .next_block").stop();
		var S = $(this).find(".wrap_prev_block .prev_block").stop();
		var x = E.attr("data-scroll");
		E.attr("data-scroll", h);
		E.attr("data-width", a + w);
		S.attr("data-scroll", h);
		S.attr("data-width", a + w);
		v.css("left", "0px");
		E.removeClass("disabled");
		S.removeClass("disabled");
		S.addClass("disabled");
		if (p <= h - 1) {
			E.addClass("disabled")
		}
		if (x != null) {
			return
		}
		S.click(function (e) {
			var t = Number($(this).attr("data-scroll"));
			var n = Number($(this).attr("data-width"));
			var r = v.css("left");
			if (!r || r == "auto") {
				r = 0
			} else {
				r = r.replace("px", "")
			}
			var i = Number(r) + (t - 2) * n;
			if (i > 0) {
				i = 0
			}
			v.animate({
				left: i + "px"
			}, 500);
			if (i == 0) {
				$(this).addClass("disabled")
			}
			E.removeClass("disabled");
			return false
		});
		E.click(function (e) {
			var t = Number($(this).attr("data-scroll"));
			var n = Number($(this).attr("data-width"));
			var r = v.css("left");
			if (!r || r == "auto") {
				r = 0
			} else {
				r = r.replace("px", "")
			}
			var i = Number(r) - (t - 2) * n;
			v.animate({
				left: i + "px"
			}, 500);
			if (Math.abs(i - (t - 1) * n) >= (p + 1) * n / 2) {
				$(this).addClass("disabled")
			}
			S.removeClass("disabled");
			return false
		})
	});
    $(".rich_list, .ftcat, .tv_list, .tv_channel, .stream-line").each(function () {
        if ($(this).hasClass('l-items')) return;
        var width_btn = 100;
        var w = $(this).parent().width() - width_btn;
        var mR = $(this).find("ul li").stop().css("marginRight");
        var mL = $(this).find("ul li").stop().css("marginLeft");
        var mT = $(this).find("ul li").stop().css("marginTop");
        var mB = $(this).find("ul li").stop().css("marginBottom");
        if (mR) {
            mR = mR.replace('px', '')
        };
        if (mL) {
            mL = mL.replace('px', '')
        };
        if (mT) {
            mT = mT.replace('px', '')
        };
        if (mB) {
            mb = mB.replace('px', '')
        };
        var marginR = Number(mR) + Number(mL);
        var marginT = Number(mT) + Number(mB);
        var wli = $(this).find("ul li").stop().width() + marginR;
        var hli = $(this).find("ul li").stop().height() + marginR;
        var nw = 0;
        for (var i = 1; i <= Math.round(w / wli); i++) {
            nw = i * wli;
            if (nw > w) {
                nw = (i - 1) * wli;
                break
            }
        };
        var items = $(this).find("ul li").size();
        $(this).height(hli + marginT);
        var btop = 0;
        if ($(this).hasClass('ftcat')) {
            $(this).width("100%");
            btop = (w - nw) / 2
        } else {
            $(this).width(nw + width_btn);
            $(this).css("margin-left", (w + width_btn - (nw + width_btn)) / 2)
        };
        var scroll_obj = $(this).find(".scroll_list").stop();
        scroll_obj.width(nw - marginR);
        scroll_obj.height(hli + marginT);
        scroll_obj.css("margin-left", (width_btn + marginR) / 2 + btop + "px");
        var scrolls = $(this).find("ul").stop();
        scrolls.width(items * wli);
        scrolls.css("margin-left", "0px");
        var destitle = $("div[rel^='" + scrolls.attr("id") + "']");
        destitle.width(nw + width_btn);
        destitle.find("span").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find("h2").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find("h3").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find(".fright").stop().css("margin-right", (width_btn + marginR) / 2 + "px");
        destitle.css("margin-left", (w + width_btn - (nw + width_btn)) / 2);
        var next = $(this).find(".wrap_next_block .next_block").stop();
        var prev = $(this).find(".wrap_prev_block .prev_block").stop();
        var check = next.attr("data-scroll");
        next.attr("data-scroll", i);
        next.attr("data-width", wli);
        prev.attr("data-scroll", i);
        prev.attr("data-width", wli);
        scrolls.css('left', '0px');
        next.removeClass("disabled");
        prev.removeClass("disabled");
        prev.addClass("disabled");
        if (items <= i - 1) {
            next.addClass("disabled")
        };
        if (check != null) {
            return
        };
        prev.click(function (e) {
            var i = Number($(this).attr("data-scroll"));
            var wli = Number($(this).attr("data-width"));
            var sx = scrolls.css("left");
            if (!sx || sx == 'auto') {
                sx = 0
            } else {
                sx = sx.replace("px", '')
            };
            var vl = Number(sx) + (i - 1) * wli;
            if (vl > 0) {
                vl = 0
            };
            scrolls.animate({
                'left': vl + "px"
            }, 500);
            if (vl == 0) {
                $(this).addClass("disabled")
            };
            next.removeClass("disabled");
            return false
        });
        next.click(function (e) {
            var i = Number($(this).attr("data-scroll"));
            var wli = Number($(this).attr("data-width"));
            var sx = scrolls.css("left");
            if (!sx || sx == 'auto') {
                sx = 0
            } else {
                sx = sx.replace("px", '')
            };
            var vl = Number(sx) - (i - 1) * wli;
            scrolls.animate({
                'left': vl + "px"
            }, 500);
            if (Math.abs(vl - (i - 1) * wli) >= items * wli) {
                $(this).addClass("disabled")
            };
            prev.removeClass("disabled");
            return false
        })
    });
    $(window).scroll(function () {
        if ($("#feature").length) {
            if ($(window).scrollTop() > $("#feature").offset().top) {
                $("#header").removeClass("header_gra")
            } else {
                $("#header").addClass("header_gra")
            }
        };
        if ($(".watch-tab").length) {
            if ($(window).scrollTop() > $(".watch-tab").offset().top) {
                $("#header").removeClass("header_gra")
            } else {
                $("#header").addClass("header_gra")
            }
        };
        if ($(".p-profile-cover").length) {
            if ($(window).scrollTop() > $(".p-profile-cover").offset().top) {
                $("#header").removeClass("header_gra")
            } else {
                $("#header").addClass("header_gra")
            }
        };
        if ($(".hdvideo").length) {
            if ($(window).scrollTop() > $(".hdvideo").offset().top) {
                $("#header").removeClass("header_gra")
            } else {
                $("#header").addClass("header_gra")
            }
        };
        if ($("#filter-movie").length) {
            if ($(window).scrollTop() >= ($(".bread-crumb").offset().top)) {
                $("#header").fadeOut(100);
                $("#filter-movie").css({
                    'position': 'fixed',
                    'top': '0px',
                    'left': '0px'
                })
            } else {
                $("#header").fadeIn(100);
                $("#filter-movie").css({
                    'position': '',
                    'top': '',
                    'left': ''
                })
            }
        }
        if ($(".none-space-top").length) {
            if ($(window).scrollTop() > $(".none-space-top").offset().top) {
                $("#header").removeClass("header_gra")
            }
        }
        if ($(window).scrollTop() > 300) {
            $("#google-fl").show().animate({
                opacity: 1
            })
        } else {
            $("#google-fl").animate({
                opacity: 1
            }).hide()
        }
    });
    $(".rich_list, .ftcat, .tv_list, .tv_channel, .stream-line").each(function () {
        if ($(this).hasClass('l-items')) return;
        var width_btn = 100;
        var w = $(this).parent().width() - width_btn;
        var mR = $(this).find("ul li").stop().css("marginRight");
        var mL = $(this).find("ul li").stop().css("marginLeft");
        var mT = $(this).find("ul li").stop().css("marginTop");
        var mB = $(this).find("ul li").stop().css("marginBottom");
        if (mR) {
            mR = mR.replace('px', '')
        };
        if (mL) {
            mL = mL.replace('px', '')
        };
        if (mT) {
            mT = mT.replace('px', '')
        };
        if (mB) {
            mb = mB.replace('px', '')
        };
        var marginR = Number(mR) + Number(mL);
        var marginT = Number(mT) + Number(mB);
        var wli = $(this).find("ul li").stop().width() + marginR;
        var hli = $(this).find("ul li").stop().height() + marginR;
        var nw = 0;
        for (var i = 1; i <= Math.round(w / wli); i++) {
            nw = i * wli;
            if (nw > w) {
                nw = (i - 1) * wli;
                break
            }
        };
        var items = $(this).find("ul li").size();
        $(this).height(hli + marginT);
        var btop = 0;
        if ($(this).hasClass('ftcat')) {
            $(this).width("100%");
            btop = (w - nw) / 2
        } else {
            $(this).width(nw + width_btn);
            $(this).css("margin-left", (w + width_btn - (nw + width_btn)) / 2)
        };
        var scroll_obj = $(this).find(".scroll_list").stop();
        scroll_obj.width(nw - marginR);
        scroll_obj.height(hli + marginT);
        scroll_obj.css("margin-left", (width_btn + marginR) / 2 + btop + "px");
        var scrolls = $(this).find("ul").stop();
        scrolls.width(items * wli);
        scrolls.css("margin-left", "0px");
        var destitle = $("div[rel^='" + scrolls.attr("id") + "']");
        destitle.width(nw + width_btn);
        destitle.find("span").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find("h2").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find("h3").stop().css("margin-left", (width_btn + marginR) / 2 + "px");
        destitle.find(".fright").stop().css("margin-right", (width_btn + marginR) / 2 + "px");
        destitle.css("margin-left", (w + width_btn - (nw + width_btn)) / 2);
        var next = $(this).find(".wrap_next_block .next_block").stop();
        var prev = $(this).find(".wrap_prev_block .prev_block").stop();
        var check = next.attr("data-scroll");
        next.attr("data-scroll", i);
        next.attr("data-width", wli);
        prev.attr("data-scroll", i);
        prev.attr("data-width", wli);
        scrolls.css('left', '0px');
        next.removeClass("disabled");
        prev.removeClass("disabled");
        prev.addClass("disabled");
        if (items <= i - 1) {
            next.addClass("disabled")
        };
        if (check != null) {
            return
        };
        prev.click(function (e) {
            var i = Number($(this).attr("data-scroll"));
            var wli = Number($(this).attr("data-width"));
            var sx = scrolls.css("left");
            if (!sx || sx == 'auto') {
                sx = 0
            } else {
                sx = sx.replace("px", '')
            };
            var vl = Number(sx) + (i - 1) * wli;
            if (vl > 0) {
                vl = 0
            };
            scrolls.animate({
                'left': vl + "px"
            }, 500);
            if (vl == 0) {
                $(this).addClass("disabled")
            };
            next.removeClass("disabled");
            return false
        });
        next.click(function (e) {
            var i = Number($(this).attr("data-scroll"));
            var wli = Number($(this).attr("data-width"));
            var sx = scrolls.css("left");
            if (!sx || sx == 'auto') {
                sx = 0
            } else {
                sx = sx.replace("px", '')
            };
            var vl = Number(sx) - (i - 1) * wli;
            scrolls.animate({
                'left': vl + "px"
            }, 500);
            if (Math.abs(vl - (i - 1) * wli) >= items * wli) {
                $(this).addClass("disabled")
            };
            prev.removeClass("disabled");
            return false
        })
    });
	$("a[rel^='trailer']").prettyPhoto();
	$(".box-top").click(function (e) {
        var targetOffset = $('#wrapper').offset().top;
        $('html,body').animate({
            scrollTop: targetOffset
        }, 500)
		return false;
    });
	$(".info_resize").hide();
	$(".watch-info, .watch-video, .watch-tivi").show();
	$(".wap-tab a").click(function () {
		 var valname = $(this).attr('rel');
		$(".wap-tab a").removeClass('active');
		$(".info_resize").hide();
		$(this).addClass('active');
		$('.'+valname).fadeIn(200);
		return false;
	});
	var width_vote = $(".unvote-line .vote-line").width();
	$(".unvote-line .vote-line-hv").mouseover(function() {
		var valname = $(this).attr('data-id');
        $(".unvote-line .vote-line").animate({"width": valname+'0%'},50);
	});
	$(".unvote-line .vote-line-hv").click(function () {
		var valname = $(this).attr('data-id');
		var filmid = $("#filmid").val();
		load_vote(valname,filmid);
		return false;
	});
	$(".unvote-line .vote-line-box").mouseleave(function() {
		$(".unvote-line .vote-line").animate({"width": width_vote+'px'},50);
	});
	RKLIST.init(); 
	$(".ft-right .ui a").click(function (e) {
		Msgbox("alert", "Tính năng đang cập nhật")
    });
	$(".l-items").each(function () {
		var w = $(window).width();
		var mR = $(this).find("ul li").stop().css("marginRight");
		var mL = $(this).find("ul li").stop().css("marginLeft");
		var mT = $(this).find("ul li").stop().css("marginTop");
		var mB = $(this).find("ul li").stop().css("marginBottom");
		if (mR) {
			mR = mR.replace('px', '')
		} else {
			mR = 0
		};
		if (mL) {
			mL = mL.replace('px', '')
		} else {
			mL = 0
		};
		if (mT) {
			mT = mT.replace('px', '')
		} else {
			mT = 0
		};
		if (mB) {
			mB = mB.replace('px', '')
		} else {
			mB = 0
		};
		var marginR = Number(mR) + Number(mL);
		var marginT = Number(mT) + Number(mB);
		var wli = $(this).find("ul li").stop().width() + marginR;
		if (wli == 0) {
			return
		}
		var nw = 0;
		var maxitem = 0;
		for (maxitem = 1; maxitem <= w / wli; maxitem++) {
			nw = maxitem * wli;
			if (nw > w) {
				nw = (maxitem - 1) * wli;
				break
			}
		};
		maxitem--;
		var marginIndent = Math.round((w - nw) / 2);
		$(this).find("ul").stop().width(nw);
		$(this).find("h2").stop().width(nw);
		$(this).find("ul").stop().css("margin-left", marginIndent + "px");
		$(this).find("h2").stop().css("margin-left", marginIndent + "px");
		var min_item = 28;
		var listitems = $(this).find("ul li").size();
		if (listitems >= maxitem && listitems >= min_item) {
			var listi = 0;
			for (var i = 1; i <= listitems; i++) {
				listi = i * maxitem;
				if (listi > listitems) {
					listi = (i - 1) * maxitem;
					break
				}
			};
			$(this).find("ul li").each(function (index, element) {
				if (index > listi - 1) {
					$(this).fadeOut()
				} else {
					$(this).fadeIn()
				}
			});
		} else {
			$(this).find("ul li").fadeIn()
		}
	});
	$('.tooltip-movie').each(function () {
		$(this).qtip({
			content: {
				text: function (event, api) {
					$.ajax({
						url: "index.php?RK_Film=" + api.elements.target.data('tooltip')
					}).then(function (content) {
						api.set('content.text', content)
					}, function (xhr, status, error) {
						api.set('content.text', status + ': ' + error)
					});
					return 'Đang tải...'
				}
			},
			position: {
				viewport: $(window),
				my: 'center left',
			},
			hide: {
				fixed: true,
				delay: 300
			},
			show: {
				delay: 500
			},
			style: 'qtip-bootstrap'
		})
	});
	$("img.lazy").lazyload({
		effect: "fadeIn"
	});
	$(".load-more span a").click(function (e) {
		set_loading(true);
    });
	$("li .delete_over .remove").click(function (e) {
		var filmid = $(this).attr("data-id"),
			type = $(this).attr("data-type");
		remove_film(filmid,type);
		return false;
    });
	var episodeid = $("#episodeid").val();
	$("#episode_"+episodeid).addClass('active');
	$('.stream-items li a').on({
		mouseenter: function () {
			$(this).find('span.video').stop().fadeIn('fast');
			$(this).find('span.name').stop().hide()
		},
		mouseleave: function () {
			$(this).find('span.video').stop().hide();
			$(this).find('span.name').stop().fadeIn('fast')
		}
	});
	$(".tv_list_page").each(function () {
		var w = $(window).width();
		var mR = $(this).find("ul li").stop().css("marginRight");
		var mL = $(this).find("ul li").stop().css("marginLeft");
		var mT = $(this).find("ul li").stop().css("marginTop");
		var mB = $(this).find("ul li").stop().css("marginBottom");
		if (mR) {
			mR = mR.replace('px', '')
		} else {
			mR = 0
		};
		if (mL) {
			mL = mL.replace('px', '')
		} else {
			mL = 0
		};
		if (mT) {
			mT = mT.replace('px', '')
		} else {
			mT = 0
		};
		if (mB) {
			mB = mB.replace('px', '')
		} else {
			mB = 0
		};
		var marginR = Number(mR) + Number(mL);
		var marginT = Number(mT) + Number(mB);
		var wli = $(this).find("ul li").stop().width() + marginR;
		if (wli == 0) {
			return
		}
		var nw = 0;
		var maxitem = 0;
		for (maxitem = 1; maxitem <= w / wli; maxitem++) {
			nw = maxitem * wli;
			if (nw > w) {
				nw = (maxitem - 1) * wli;
				break
			}
		};
		var marginIndent = Math.round((w - nw) / 2);
		$(this).find("ul").stop().width(nw);
		$(this).find("ul").stop().css("margin-left", marginIndent + "px");
		var listitems = $(this).find("ul li").size()
	});
});