var core = {
    h: !!(window.history && history.pushState),

    extend: function(destination, source)
    {
        if(destination.prototype) {
            for (var property in source)
                destination.prototype[property] = source[property];
        } else {
            for (var property in source)
                destination[property] = source[property];
        }
        return destination;
    },

    redirect: function(url, ask, timeout)
    {
        if(!ask || (ask && confirm(ask))) {
            window.setTimeout(function(){ window.location.href = url; }, (timeout || 0) * 1000);
        }
        return false;
    },

    isEmail: function(str)
    {
        if(str.length<=6) return false;
        var re = /^\s*[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\s*$/i;
        return re.test(str);
    },

    ajax_utils: (function(){
        return {
            errors: function(errors, system){
                console.log(errors);
            },
            progress: function(progressSelector){
                var timer_reached = false, response_received = false, progress = null,
                    progressIsFunc = false, progressIsButton = false;
                if(progressSelector!=undefined && progressSelector!=false) {
                    if( (progressIsFunc = (Object.prototype.toString.call(progressSelector) === "[object Function]")) ) {
                        progress =  progressSelector;
                    } else {
                        progress = $(progressSelector);
                        if( ! progress.length) progress = false;
                        else if (progress.is('input[type="button"]') || progress.is('button')) {
                            progressIsButton = true;
                        }
                    }
                }
                if(progress) {
                    if(progressIsFunc) { progress.call(this, true); }
                    else if (progressIsButton) { progress.prop('disabled', true); }
                    else { progress.show(); }
                    setTimeout(function() {
                        timer_reached = true;
                        that.finish();
                    }, 400);
                }
                var that = {
                    finish: function(response_received_set) {
                        if( response_received_set ) { response_received = true; }
                        if(timer_reached && response_received && progress){
                            if(progressIsFunc) { progress.call(this, false); }
                            else if (progressIsButton) { progress.removeProp('disabled'); }
                            else { progress.hide(); }
                        }
                    }
                };
                return that;
            }
        }
    }()),

    ajax: function(url, params, callback, progressSelector, o)
    {
        o = o || {async: true, crossDomain: false};
        var progress = core.ajax_utils.progress(progressSelector);
        return $.ajax({
            url: url, data: params, dataType: 'json', type: 'POST', crossDomain: (o.crossDomain || false), async: (o.async && true),
            success: function(resp, status, xhr) {
                progress.finish(true);

                if(resp == undefined) {
                    if(status!=='success')
                        core.ajax_utils.errors(0, true);
                    if(callback) callback(false); return;
                }

                if(resp.errors && (($.isArray(resp.errors) && resp.errors.length) || $.isPlainObject(resp.errors)) )
                    core.ajax_utils.errors(resp.errors, false);

                if(callback) callback(resp.data, resp.errors);
            },
            error: function(xhr, status, e){
                progress.finish(true);
                core.ajax_utils.errors(xhr.status, true);
                if(o.onError) o.onError(xhr, status, e);
                if(callback) callback(false);
            }
        });
    },

    input: {
        file: function(self, id) {
            var file = self.value.split("\\");
            file = file[file.length-1];
            if( file.length>30 ) file = file.substring(0, 30)+'...';
            var html = '<a href="#delete" onclick="core.input.reset(\''+self.id+'\'); $(\'#'+id+'\').html(\'\'); $(this).blur(); return false;"></a>' + file;
            $('#'+id).html(html);
        },
        reset: function(id) {
            var o = document.getElementById(id);
            if (o.type == 'file') {
                try{
                    o.parentNode.innerHTML = o.parentNode.innerHTML;
                } catch(e){}
            } else {
                o.value = '';
            }
        }
    },

    declension: function(count, forms, add) {
        var prefix = (add!==false ? count+' ':'');
        var n = Math.abs(count) % 100; var n1 = n % 10;
        if (n > 10 && n < 20) { return prefix+forms[2]; }
        if (n1 > 1 && n1 < 5) { return prefix+forms[1]; }
        if (n1 == 1) { return prefix+forms[0]; }
        return prefix+forms[2];
    },

    /**
     * Создает куки или возвращает значение.
     * @examples:
     * core.cookie('the_cookie', 'the_value'); - Задает куки для сессии.
     * core.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'site.com', secure: true }); Создает куки с опциями.
     * core.cookie('the_cookie', null); - Удаляет куки.
     * core.cookie('the_cookie'); - Возвращает значение куки.
     *
     * @param {String} name Имя куки.
     * @param {String} value Значение куки.
     * @param {Object} options Объект опций куки.
     * @option {Number|Date} expires Either an integer specifying the expiration date from now on in days or a Date object.
     *                               If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
     *                               If set to null or omitted, the cookie will be a session cookie and will not be retained
     *                               when the the browser exits.
     * @option {String} path The value of the path atribute of the cookie (default: path of page that created the cookie).
     * @option {String} domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
     * @option {Boolean} secure If true, the secure attribute of the cookie will be set and the cookie transmission will
     *                          require a secure protocol (like HTTPS).
     *
     * @return {mixed} значение куки
     * @author Klaus Hartl (klaus.hartl@stilbuero.de), Vlad Yakovlev (red.scorpix@gmail.com)
     * @version 1.0.1, @date 2009-11-12
     */
    _cookie: function(name, value, options) {
        if ('undefined' != typeof value) {
            options = options || {};
            if (null === value) {
                value = '';
                options.expires = -1;
            }
            // CAUTION: Needed to parenthesize options.path and options.domain in the following expressions,
            // otherwise they evaluate to undefined in the packed version for some reason…
            var path = options.path ? '; path=' + options.path : '',
                domain = options.domain ? '; domain=' + options.domain : '',
                secure = options.secure ? '; secure' : '',
                expires = '';

            if (options.expires && ('number' == typeof options.expires || options.expires.toUTCString)) {
                var date;
                if ('number' == typeof options.expires) {
                    date = new Date();
                    date.setTime(date.getTime() + (options.expires * 86400000/*24 * 60 * 60 * 1000*/));
                } else {
                    date = options.expires;
                }
                expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
            }
            window.document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
            return true;
        }

        var cookieValue = null;
        if (document.cookie && '' != document.cookie) {
            $.each(document.cookie.split(';'), function() {
                var cookie = $.trim(this);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    return false;
                }
            });
        }

        return cookieValue;
    },

    cookie: function(name, value, options) {
        return core._cookie(name, value, options);
    },

    fp: function(){
        return md5([navigator.userAgent,[screen.height,screen.width,screen.colorDepth].join("x"),(new Date).getTimezoneOffset(),!!window.sessionStorage,!!window.localStorage,$.map(navigator.plugins,function(n){return[n.name,n.description,$.map(n,function(n){return[n.type,n.suffixes].join("~")}).join(",")].join("::")}).join(";")].join("###"));
    }

};

(function(){
    var ua = navigator.userAgent.toLowerCase(), browser = {};
    var matched = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];
    matched = {
        browser: matched[ 1 ] || "",
        version: matched[ 2 ] || "0"
    };
    if( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }
    if( browser.chrome ) { browser.webkit = true; }
    else if ( browser.webkit ) { browser.safari = true; }
    core.browser = browser;
}());

// Common shortcut-functions
function nothing(e)
{
    if( ! e) {
        if (window.event) e = window.event;
        else return false;
    }
    if (e.cancelBubble != null) e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
    if (e.preventDefault) e.preventDefault();
    if (window.event) e.returnValue = false;
    if (e.cancel != null) e.cancel = true;
    return false;
}

function intval(number)
{
    return number && + number | 0 || 0;
}

(function($){

    // Simple JavaScript Templating, John Resig - http://ejohn.org/blog/javascript-micro-templating/ - MIT Licensed
    var cache = {};
    core.tmpl = function (str, data){
        var fn = !/\W/.test(str) ? cache[str] = cache[str] || core.tmpl(document.getElementById(str).innerHTML) :
            new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" +
                str.replace(/[\r\t\n]/g, " ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g, "$1\r")
                    .replace(/\t=(.*?)%>/g, "',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'")
                + "');}return p.join('');");
        return data ? fn( data ) : fn;
    };

    /* Debounce and throttle function's decorator plugin 1.0.4 Copyright (c) 2009 Filatov Dmitry (alpha@zforms.ru)
     * Dual licensed under the MIT and GPL licenses: http://www.opensource.org/licenses/mit-license.php, http://www.gnu.org/licenses/gpl.html
     */
    $.extend({
        debounce : function(fn, timeout, invokeAsap, context) {
            if(arguments.length == 3 && typeof invokeAsap != 'boolean') {
                context = invokeAsap;
                invokeAsap = false;
            }
            var timer;
            return function() {
                var args = arguments;
                if(invokeAsap && !timer) { fn.apply(context, args); }
                clearTimeout(timer);
                timer = setTimeout(function() { if(!invokeAsap) { fn.apply(context, args); } timer = null; }, timeout);
            };
        },
        throttle : function(fn, timeout, context) {
            var timer, args;
            return function() {
                args = arguments;
                if(!timer) {
                    (function() {
                        if(args) { fn.apply(context, args); args = null; timer = setTimeout(arguments.callee, timeout); }
                        else { timer = null; }
                    })();
                }
            };
        },
        assert : function(cond, msg, force_report) {
            if (!cond) {
                core_report_exception(msg, window.location.href, window.location.href);
            }
        }
    });

})(jQuery);