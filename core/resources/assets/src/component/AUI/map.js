;(function(){
    var moduleName = (function($, common) {

        function Amap(opts) {
            common.inherit(this, common.Observer);

            var defOpts = {
                'container': 'amap',
                'center': undefined,
                'zoom': 12,
                'lang': 'zh_cn',
                'marks': [],
                'plugin': ['ToolBar', 'Scale'],

                'pageSize': 1, // placeSearch
                'city': {
                    'quanpin': 'shanghai',
                    'name': '上海'
                },
            };

            this.opts = $.extend({}, defOpts, opts);

            this.init();
        }

        Amap.prototype = {
            constructor: Amap,

            init: function() {
                var opts = this.opts;
                var self = this;
                var mapData = {
                    zoom: opts.zoom,
                    lang: opts.lang
                };

                if (this.opts.center) {
                    mapData.center = this.opts.center;
                }

                this.map && this.map.destroy();
                this.map = new AMap.Map(opts.container, mapData);

                if (!this.opts.center) {
                    this.map.setCity(opts.city.quanpin, function(data) {
                        self.trigger('amap_city_set', [data]);
                    });
                }

                this.addMarker(opts.marks);
                this.addPlugins(opts.plugin);

                AMap.service(["AMap.PlaceSearch"], function() {
                    self.placeSearch = new AMap.PlaceSearch({
                        pageSize: opts.pageSize,
                        city: opts.city.quanpin,
                        map: self.map
                    });
                });

                return this;
            },

            addEventListener: function(eventName, handler, instance) {
                AMap.event.addListener(instance || this.map, eventName, handler);

                return this;
            },

            addMarker: function(marks, markerOpts, events) {
                var self = this,
                    len;

                if (!$.isArray(marks)) {
                    marks = [marks];
                }

                self.markers = self.markers || [];
                len = self.markers.length;

                $.each(marks, function(i, item) {
                    var marker = self._createMarker(item, markerOpts || {});

                    marker.identifier = len + i;
                    events && self._addMarkerEvents(events, marker);

                    self.markers.push(marker);
                });

                return this;
            },

            removeMarker: function(marker) {
                if (marker) {
                    this.map.remove(marker);
                    this.markers[marker.identifier] = null;
                } else {
                    this.map.remove(this.markers);
                    this.markers = [];
                }

                return this;
            },

            addPlugins: function(plugins, opts) {
                if ($.isArray(plugins)) {
                    var self = this;

                    $.each(plugins, function(i, item) {
                        self._addPlugin(item);
                    });
                } else {
                    this._addPlugin(plugins, opts || {});
                }

                return this;
            },

            placeSearchByKey: function(keywords) {
                var self = this;

                if (Object.prototype.toString.call(keywords) === '[object Array]') {
                    keywords = keywords.join('|');
                }

                this.placeSearch && this.placeSearch.search(keywords, function(status, result) {
                    self.trigger('place_searched', [status, result]);
                });
            },

            getAllOverlays: function(type) {
                return this.map.getAllOverlays(type);
            },

            _createMarker: function(mark, markerOpts) {
                var opts = $.extend({
                        position: [mark.lng, mark.lat],
                        map: mark.hide ? null : this.map
                    }, markerOpts),
                    marker = new AMap.Marker(opts);

                marker = $.extend(marker, mark);

                return marker;
            },

            _addMarkerEvents: function(events, marker) {
                var self = this;

                if (!$.isArray(events)) {
                    events = [events];
                }

                $.each(events, function(i, item) {
                    self.addEventListener(item.type, item.cbk, marker);
                });
            },

            _addPlugin: function(plugin, opts) {
                var self = this;

                self.plugins = self.plugins || {};

                self.map.plugin(['AMap.' + plugin], function() {
                    self.map.addControl(self.plugins[plugin] = new AMap[plugin](opts || null));   
                });
            }
        };

        return Amap;
    }(jQuery, AGJ.common));
    
    if (typeof module !== 'undefined' && typeof exports === 'object') {
        module.exports = moduleName;
    } else if (typeof define === 'function' && (define.amd || define.cmd)) {
        define(function() { return moduleName; });
    } else {
        this.moduleName = moduleName;
    }
}).call(function() {
    return this || (typeof window !== 'undefined' ? window : global);
});
