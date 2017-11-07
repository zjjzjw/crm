;(function(){
    var moduleName = (function($, common) {
        var Autocomplete = function(_op) {
            common.inherit(this, common.Observer);
            var self = this;

            self.op = $.extend({}, {
                keyword: '#keyword',
                searchContainer: '.content-wrap',
                resources: [],
                reqData: {},
                formatData: null
            }, _op);

            self._itemListData = [];

            this.bindEvent();
        };

        Autocomplete.prototype.bindEvent = function() {
            var self = this;
            var $keyword = typeof self.op.keyword === 'string' ? $(self.op.keyword) : self.op.keyword;
            var $searchContainer = typeof self.op.searchContainer === 'string' ? $(self.op.searchContainer) : self.op.searchContainer;

            $keyword.autocomplete({
                minLength: 0,
                source: function (request, response) {
                    self.getSearchData(request.term, response);
                },
                messages: {
                    noResults: '',
                    results: function() {}
                },
                focus: function (event, ui) {
                    this.value = ui.item.name;
                    $(this).attr('data-id', ui.item.id);
                    self.trigger('search_box_focused', [ui]);
                    event.preventDefault();
                },
                select: function (event, ui) {
                    ui.item.value = ui.item.name;
                    $(this).attr('data-id', ui.item.id);
                    self.trigger('search_box_selected', [ui, event]);
                }
            });

            $keyword.autocomplete('instance')._renderItem = function (ul, item) {
                return $("<li></li>").append("<a href='javascript:;'>" + item.name + "</a>").appendTo(ul);
            };

            $keyword.autocomplete('instance')._resizeMenu = function () {
                var ul = this.menu.element;
                ul.outerWidth(Math.max(0, this.element.outerWidth()));
                $searchContainer.append(ul);
            };
        };

        Autocomplete.prototype.getSearchData =function (keyword, response) {
            var self = this;

            if($.isArray(self.op.resources)) {
                response(self.op.resources);
            } else if (typeof self.op.resources == 'string') {
                $.ajax({
                    type: 'GET',
                    url: self.op.resources,
                    data: self.op.reqData,
                    dataType: 'json',
                    success: function(da) {
                        response(da);
                    }
                });
            } else {
                var requestData = $.extend({}, self.op.reqData, {
                    keyword: keyword
                });
                self.op.resources({
                    data: requestData,
                    success: function (data) {
                        if(self.op.formatData) {
                            data = self.op.formatData(data);
                        }
                        self._itemListData = data;
                        response(data);
                    },
                    error: function () {}
                });
            }
        };

        Autocomplete.prototype.changeResquestData = function(reqData) {
            this.op.reqData = reqData;
         };

        Autocomplete.prototype.getItemListData = function() {
            return this._itemListData;
        };

        return Autocomplete;
    })(jQuery, AGJ.common);
    
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
