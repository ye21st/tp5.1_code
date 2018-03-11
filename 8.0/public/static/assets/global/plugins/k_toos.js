
(function ($) {
    var Token_key = "user_authentication";
    var user_key = "user_key";
    var gateway = "http://58.64.132.212:8089";
    //扩展jQuery对象本身
    jQuery.extend({
        /// <summary>
        /// 图片目录
        ///</summary>
        "imgFilePath": function () {
            return "http://58.64.132.212:8089/api/file/get/";
        },
        /// <summary>
        /// 图片目录
        ///</summary>
        "getGateway": function () {
            return gateway;
        },
        /// <summary>
        /// 字母+数字，字母+特殊字符，数字+特殊字符
        ///</summary>
        "verifyPwd": function (str) {
            var patrn = /^(?![a-zA-z]+$)(?!\d+$)(?![!@#$%^&*.><]+$)[a-zA-Z\d!@#$%^&*.><]+$/;
            if (!patrn.exec(str)) return false
            return true;
        },
        ///<summary>
        /// 生成签名
        ///</summary>
        "toSign": function (str) {
            try {
                str = str + getKey();
                return CryptoJS.MD5(str).toString();
            } catch (e) {
                return "";
            }

        },
        ///<summary>
        /// json对象转码Base64
        ///</summary>
        "toBase64": function (obj) {
            try {
                if ("payPwd" in obj) {
                    obj["payPwd"] = passWord(obj["payPwd"]);
                }
                if ("password" in obj) {
                    obj["password"] = passWord(obj["password"]);
                }
                if ("pwd" in obj) {
                    obj["pwd"] = passWord(obj["pwd"]);
                }
                if ("paypass" in obj) {
                    obj["paypass"] = passWord(obj["paypass"]);
                }
                var str = JSON.stringify(obj);

                return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(str));
            } catch (e) {
                return "";
            }

        },
        ///<summary>
        /// Base64解码成json对象
        ///</summary>
        "Base64ToObj": function (str) {
            try {
                var words = CryptoJS.enc.Base64.parse(str);
                var jsonStr = words.toString(CryptoJS.enc.Utf8);

                return JSON.parse(jsonStr);
            } catch (e) {
                return null;
            }

        },
        ///<summary>
        /// Base64解码成str
        ///</summary>
        "Base64ToStr": function (str) {
            try {
                var words = CryptoJS.enc.Base64.parse(str);
                var jsonStr = words.toString(CryptoJS.enc.Utf8);

                return JSON.stringify(jsonStr);
            } catch (e) {
                return "";
            }

        },
        ///<summary>
        /// 登录写入鉴权
        ///</summary>
        "loginSet": function (token, userKey) {
            setCookie(Token_key, token);
            setCookie(user_key, userKey);
        },
        ///<summary>
        /// 读取鉴权信息
        ///</summary>
        "getToken": function () {
            return getCookie(Token_key);
        },
        ///<summary>
        /// 读取用户key
        ///</summary>
        "getUserKey": function () {
            return getCookie(user_key);
        },
        ///<summary>
        /// 登出
        ///</summary>
        "loginOut": function () {
            delCookie(user_key);
            delCookie(Token_key);
        },
        ///<summary>
        /// 请求数据
        ///</summary>
        "sendData": function (strObgect, strSign, strApi) {
            var data;
            $.ajax({
                type: "POST",
                url: gateway + strApi,
                data: JSON.stringify({ "object": strObgect, "sign": strSign }),
                async: false,
                dataType: "json",
                contentType: "application/json;charset=UTF-8",
                beforeSend: function (xhr) {
                    var Authorization = getCookie(Token_key);
                    xhr.setRequestHeader("Access-Control-Allow-Origin", "*");
                    xhr.setRequestHeader("Accept", "*/*");
                    xhr.setRequestHeader("Access-Control-Max-Age", "3600");
                    xhr.setRequestHeader("Authorization", "Bearer " + Authorization);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    data = XMLHttpRequest.responseJSON;

                },
                success: function (resdata) {
                    data = resdata;
                }
            });

            return data;
        },
        "getUrlParam": function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) {
                return unescape(r[2]);
            } else {
                return null;
            }
        }


    });

    //获取用户key
    function getKey() {
        try {
            var key = getCookie(user_key);
            return key;
        } catch (e) {
            return "";
        }

    }
    ///<summary>
    /// 创建一个cookie
    ///</summary>
    function setCookie(key, value) {
        $.cookie(key, value, {
            path: "/"
        });
    }
    ///<summary>
    /// 获取cookie
    ///</summary>
    function getCookie(key) {
        try {
            var value = $.cookie(key);
            return undefinedCheck(value);
        } catch (e) {
            return "";
        }
    }
    ///<summary>
    /// 删除cookie
    ///</summary>
    function delCookie(key) {
        return $.cookie(key, null, {
            path: "/"
        });
    }

    function undefinedCheck(reValue) {
        if (typeof (reValue) == "undefined") {
            return "";
        } else if (reValue == null || typeof (reValue) == "null" || reValue == "null") {
            return "";
        } else {
            return reValue;
        }
    }

    function passWord(str) {
        try {
            str = CryptoJS.MD5(str).toString();
            return CryptoJS.MD5(str).toString();
        } catch (e) {
            return "";
        }
    }
})(window.jQuery);

