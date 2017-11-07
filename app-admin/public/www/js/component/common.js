define(['jquery'], function ($) {

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
        common.isIE6 = (function () {
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

        /**
         * @param version int. 6, 7, 8, 9
         * @return boolean
         */
        common.ie = function (num) {
            var browser = navigator.appName;
            var version = navigator.appVersion.split(";")[1].replace(/[ ]/g, "");

            if (browser == "Microsoft Internet Explorer") {
                // 6, 7, 8, 9, 10
                return version == ('MSIE' + num + '.0');
            } else if (browser == 'Netscape') {
                // 11
                return num == 11;
            }

            return false;
        };

        common.hasPlaceholder = (function () {
            var d = document.createElement('input');
            d.type = 'text';
            return d.placeholder === undefined;
        })();

        common.inherit = function (my, classParent, args) {
            classParent.apply(my, args || []);
            $.extend(my.constructor.prototype, classParent.prototype);
        };

        common.Observer = function () {
            this.ob = {};
        };

        common.Observer.prototype.on = function (eventNames, callback) {
            var _events = eventNames.split(' ');
            var _eventKeys = {};
            for (var i = 0; i < _events.length; i++) {
                if (!this.ob[_events[i]]) {
                    this.ob[_events[i]] = [];
                }
                var _key = this.ob[_events[i]].push(callback);
                _eventKeys[_events[i]] = _key - 1; // push 返回数组长度，key是 现有长度减一。
            }
            return _eventKeys;
        };

        common.Observer.prototype.off = function (eventName, keys) {
            if (!!keys && !$.isArray(keys)) {
                keys = [keys]
            }
            for (var i = 0; i < this.ob[eventName].length; i++) {
                if (!keys || $.inArray(i, keys) > -1) {
                    this.ob[eventName][i] = undefined;
                }
            }
        };

        common.Observer.prototype.trigger = function (eventName, args) {
            var r;
            if (!this.ob[eventName]) {
                return r;
            }
            var _arg = args || [];
            for (var i = 0; this.ob[eventName] && i < this.ob[eventName].length; i++) {
                if (!this.ob[eventName][i]) {
                    continue;
                }
                var _r = this.ob[eventName][i].apply(this, _arg);
                r = (r === false) ? r : _r;
            }

            return r;
        };

        common.Observer.prototype.once = function (eventName, callback) {
            var self = this;
            var key = self.on(eventName, function () {
                callback.apply(this, arguments);
                self.off(eventName, key);
            });
        };

        common.render = function () {
            var temp = (function () {
                var cache = {};

                function temp(str, data) {
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
        }
    })($, AGJ.common);


    return AGJ.common;
});


