var AGJ = AGJ || {};

AGJ.namespace = function (nsString) {
    var parts = nsString.split('.'),
        parent = AGJ, 
        i;

    if (parts[0] === "AGJ") {
        parts = parts.slice(1); 
    }

    for (i = 0; i < parts.length; i += 1) {
        if (typeof parent[parts[i]] === "undefined") {
            parent[parts[i]] = {}; 
        }
        parent = parent[parts[i]];
    }
    
    return parent;
};

AGJ.namespace('AGJ.common');

(function ($, common) {
    common.isIE6 = (function() {
        var isIe6 = false;

        if (/msie/.test(navigator.userAgent.toLowerCase())) {
            if (jQuery.browser && jQuery.browser.version && jQuery.browser.version == '6.0') {
                isIe6 = true
            } else if (!$.support.leadingWhitespace) {
                isIe6 = true;
            }
        }

        return isIe6;
    })();

    common.isIE = (function(ver) {
        var b = document.createElement('b')
        b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->'
        return b.getElementsByTagName('i').length === 1
    })();

    common.hasPlaceholder = (function() {
        var d = document.createElement('input');
        d.type = 'text';
        return d.placeholder === undefined;
    })();

    common.inherit = function(my, classParent, args) {
        classParent.apply(my, args || []);
        $.extend(my.constructor.prototype, classParent.prototype);
    }

    common.Observer = function() {
        this.ob = {};
    }

    common.Observer.prototype.on = function (eventNames, callback) {
        var _events = eventNames.split(' ');
        var _eventKeys = {};
        for(var i = 0; i < _events.length; i++) {
            if(!this.ob[_events[i]]) {
                this.ob[_events[i]] = [];
            }
            var _key = this.ob[_events[i]].push(callback);
            _eventKeys[ _events[i] ] = _key - 1; // push 返回数组长度，key是 现有长度减一。
        }
        return _eventKeys;
    }

    common.Observer.prototype.off = function(eventName, keys) {
        if(!!keys && !$.isArray(keys)) {
            keys = [keys]
        }
        for(var i = 0; i < this.ob[eventName].length; i++) {
            if(!keys || $.inArray(i,keys) > -1 ) {
                this.ob[eventName][i] = undefined;
            }
        }
    }

    common.Observer.prototype.trigger = function(eventName,args) {
        var r;
        if(!this.ob[eventName]) {
            return r;
        }
        var _arg = args || [];
        for(var i = 0; this.ob[eventName] && i < this.ob[eventName].length; i++) {
            if(!this.ob[eventName][i]) {
                continue;
            }
            var _r = this.ob[eventName][i].apply(this, _arg);
            r = (r === false)? r:_r;
        }

        return r;
    }

    common.Observer.prototype.once = function(eventName, callback) {
        var self = this;
        var key = self.on(eventName, function() {
            callback.apply(this, arguments);
            self.off(eventName, key);
        });
    }

    common.rander = function(tpl,data){
        var daName = [],daVal = [], efn=[];
        for( var i in data ){
            daName.push(i);
            daVal.push('data.'+i);
        }

        var _tpl = "'"+ tpl + "'";
        _tpl = _tpl.replace(/\{\%/g,"'+");
        _tpl = _tpl.replace(/\%\}/g,"+'");
        
        efn.push('(function(');
        efn.push(daName.join(','));
        efn.push('){');
        efn.push('return '+_tpl);
        efn.push('})(');
        efn.push(daVal.join(','));
        efn.push(')');

        return eval(efn.join(''));
    }

    common.dpPosition = function(domA, domB, position, x, y) {
        var DomData = function(dom, aboutMargin) {
            var offset = dom.offset();
            this.w = parseFloat(dom.outerWidth(!!aboutMargin));
            this.h = parseFloat(dom.outerHeight(!!aboutMargin));
            this.x = parseFloat(offset.left);
            this.y = parseFloat(offset.top);
        };
        var daA = new DomData(domA),
            daB = new DomData(domB, true);

        var _pos = {
            left:-1,
            center:0,
            right:1,
            top:-1,
            bottom:1
        };

        var cal = function(dir, pos) {
            var key = dir ? ['x','w'] : ['y','h'];
            var r = daA[key[0]];
            switch(_pos[pos]) {
                case -1:
                    r += _pos[pos]*daB[key[1]];
                    break;
                case 1:
                    r += _pos[pos]*daA[key[1]];
                    break;
                case 0:
                    r += (daA[key[1]] - daB[key[1]])*0.5;
                    break;
                default:
            }
            return r;
        }

        var _position = (position||'').split(' ');
        _position[0] = _position[0]||'center';
        _position[1] = _position[1]||'center';

        domB.css({
            'position':'absolute',
            'left': cal( true, _position[0] ) - (x||0),
            'top': cal( false, _position[1] ) - (y||0)
        });
    }

    $.http = (function(){
        function ajax(options) {
            var $ajaxLoading = $('.ajax-loading');
            // default configurations.
            var defaultOptions = {
                dataType: 'json',
                ignoreAjaxLoading: true
            }, callback = {
                success: options.success,
                error: options.error
            };

            options = $.extend(defaultOptions, options);

            //TODO::format request URL here.

            options.success = function(data, status, xhr) {
                /* jshint expr:true */
                (callback.success) ? callback.success(data, status, xhr) : null;
            };
            options.error = function(xhr, errorType, error) {
                /* jshint expr:true */
                (!options.ignoreAjaxLoading) && $ajaxLoading.hide();
                var dataType = options.dataType,
                    result = xhr.responseText;
                if (result && dataType === 'json') {
                    try{
                        result = $.parseJSON(result);
                    } catch (exception) {
                        result = {msg: 'Invalid JSON format'};
                    }
                    error = result.msg;
                } else if (dataType === 'xml') {
                    result = xhr.responseXML;
                }

                /* jshint expr:true */
                (callback.error) ? callback.error(result, errorType, error, xhr) : null;
            };
            options.complete = function(xhr, status) {
                /* jshint expr:true */
                (!options.ignoreAjaxLoading) && $ajaxLoading.hide();

                (callback.complete) ? callback.complete(xhr, status) : null;
            };

            /* jshint expr:true */
            (!options.ignoreAjaxLoading) && $ajaxLoading.show();

            return $.ajax(options);
        }

        return ajax;
    })();

    $.temp = (function() {
        var cache = {};

        function temp(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.

            var fn = !/\W/.test(str) ?
                cache[str] = cache[str] ||
                    temp(document.getElementById(str).innerHTML) :

                // Generate a reusable function that will serve as a template
                // generator (and which will be cached).
                new Function("obj",
                    "var p=[],\n\tprint=function(){p.push.apply(p,arguments);};\n" +

                        // Introduce the data as local variables using with(){}
                        "\nwith(obj){\np.push('" +

                        // Convert the template into pure JavaScript
                        str
                            .replace(/[\r\t\n]/g, " ")
                            .split("<%").join("\t")
                            .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                            .replace(/\t=(.*?)%>/g, "',\n$1,\n'")
                            .split("\t").join("');\n")
                            .split("%>").join("\np.push('")
                            .split("\r").join("\\'") +
                        "');\n}\nreturn p.join('');");

            // Provide some basic currying to the user
            return data ? fn(data) : fn;
        }

        return temp;
    })();

})(jQuery, AGJ.common);