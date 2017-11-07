module.exports = (function($, common){
    var SelectParser = require('./selectParser.chosen'),
        FuzzyQuery = function(opts, chosenOpts) {
            common.inherit(this, common.Observer);

            var defOpts = {
                    'select': '#chosen',
                    'resources': null,
                    'params': {},
                    'firstOption': '<option>请选择</option>'
                },
                defChosenOpts = {
                    'display_selected_options': false,
                    'disable_search_threshold': Number.NEGATIVE_INFINITY,
                    'placeholder_text': ' ',
                    'no_results_text': '暂无结果匹配'
                };

            this.opts = $.extend({}, defOpts, opts);
            this.chosenOpts = $.extend({}, defChosenOpts, chosenOpts || {});

            this.init();
        };

    FuzzyQuery.prototype = {
        constructor: FuzzyQuery,

        init: function() {
            var opts = this.opts,
                $select = typeof opts.select === 'string' ? $(opts.select) : opts.select;

            if ($select.length) {
                $select = $select.eq(0).chosen(this.chosenOpts);
            } else {
                return;
            }

            this.$select = $select;
            this.chosen = $select.data('chosen');

            this._chosenHook();
            this._bindEvent();
        },

        getVal: function() {
            return this.$select.val();
        },

        update: function(data, keyword) {
            var format = this.opts.format;

            if (format) {
                data = format(data);
            }

            this._renderSelect(data, keyword);
        },

        _bindEvent: function() {
            var self = this,
                chosen = self.chosen;

            chosen.search_field.unbind('keyup.chosen')
                .bind('keyup.chosen', function(e) {
                    keyupChecker.apply(chosen, [self, e]);
                });

            if (chosen.is_multiple) {
                chosen.search_choices.unbind('click.chosen')
                    .bind('click.chosen', function(evt) {
                        choicesClick.apply(chosen, [evt]);
                    });
            }

            self.$select.on('change', function(e, data) {
                if (data.selected !== undefined) {
                    self.trigger('option_seleted', [{value: data.selected}]);
                } else if (data.deselected !== undefined) {
                    self.trigger('option_delete', [{value: data.deselected}]);
                }
            });
        },

        _searchKeyword: function(keyword) {
            var self = this,
                resources = self.opts.resources,
                req = $.extend({'keyword': keyword}, self.opts.params);

            if (typeof resources === 'string') {
                $.ajax({
                    type: 'GET',
                    url: resources,
                    data: req,
                    dataType: 'json',
                    success: function(res) {
                        self.update(res, keyword);
                    }
                });
            } else if (typeof resources === 'function') {
                try {
                    resources({
                        data: req,
                        success: function(res) {
                            self.update(res, keyword);
                        }
                    });
                } catch (err) {}
            }
        },

        _renderSelect: function(data, keyword) {
            var selectedVal, selectOptionTpl;

            if (this.chosen.is_multiple) {
                if (keyword === undefined) {
                    selectedVal = [];
                    selectOptionTpl = '';
                } else {
                    selectedVal = this.$select.val() || [];
                    selectOptionTpl = this._getSelectOptionTpl();
                }
            } else {
                selectedVal = [];
                selectOptionTpl = this.opts.firstOption;
            }

            $.each(data, function(i, item) {
                if (!~selectedVal.indexOf(item.value + '')) {
                    selectOptionTpl += '<option value="' + item.value + '"' + (item.selected ? ' selected="true"' : '') + '>' + item.name + '</option>';
                }
            });

            this.$select.empty().append(selectOptionTpl);
            this._chosenUpdate(keyword);
        },

        _getSelectOptionTpl: function() {
            var tpl = '';

            this.$select.find('option').each(function() {
                var $target = $(this);

                if ($target.prop('selected')) {
                    tpl += '<option value="' + $target.val() + '" selected="true">' + $target.text() + '</option>';
                }
            });

            return tpl;
        },

        _chosenUpdate: function(keyword) {
            var chosen = this.chosen;

            resultsUpdateField.call(chosen);

            (keyword !== undefined) && chosen.results_show();
        },

        _chosenHook: function() {
            this.chosen.winnow_results = winnowResults;
        }
    };

    // 接管搜索框keyup事件
    function keyupChecker(self, evt) {
        var stroke, _ref;

        stroke = (_ref = evt.which) != null ? _ref : evt.keyCode;
        this.search_field_scale();
        switch (stroke) {
            case 8:
                if (this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0) {
                    return this.keydown_backstroke();
                } else if (!this.pending_backstroke) {
                    this.result_clear_highlight();
                    self._searchKeyword(this.get_search_text());
                    return this;
                }
                break;
            case 13:
                evt.preventDefault();
                if (this.results_showing) {
                    return this.result_select(evt);
                }
                break;
            case 27:
                if (this.results_showing) {
                    this.results_hide();
                }
                return true;
            case 9:
            case 38:
            case 40:
            case 16:
            case 91:
            case 17:
            case 18:
                break;
            default:
                self._searchKeyword(this.get_search_text());
                return this;
        }
    }

    function choicesClick(evt) {
        evt.preventDefault();
        this.search_field.focus();
        if (!(this.results_showing || this.is_disabled)) {
            return this.results_show();
        }
    }

    // 复写results_update_field方法  调用resultsBuild;
    function resultsUpdateField() {
        this.set_default_text();
        if (!this.is_multiple) {
            this.results_reset_cleanup();
        }
        this.result_clear_highlight();
        resultsBuild.call(this);
        if (this.results_showing) {
            return this.winnow_results();
        }
    }

    // 复写results_build方法  去除清空搜索框操作
    function resultsBuild() {
        this.parsing = true;
        this.selected_option_count = null;
        this.results_data = SelectParser.select_to_array(this.form_field);
        if (this.is_multiple) {
            this.search_choices.find("li.search-choice").remove();
        } else if (!this.is_multiple) {
            this.single_set_selected_text();
            if (this.disable_search || this.form_field.options.length <= this.disable_search_threshold) {
                this.search_field[0].readOnly = true;
                this.container.addClass("chosen-container-single-nosearch");
            } else {
                this.search_field[0].readOnly = false;
                this.container.removeClass("chosen-container-single-nosearch");
            }
        }
        this.update_results_content(this.results_option_build({
            first: true
        }));
        this.search_field_disabled();
        this.search_field_scale();
        return this.parsing = false;
    }

    // 复写winnow_results方法 去除match逻辑 search_match group_match 设为true;
    function winnowResults() {
        var escapedSearchText, option, regex, results, results_group, searchText, startpos, text, zregex, _i, _len, _ref;

        this.no_results_clear();
        results = 0;
        searchText = this.get_search_text();
        escapedSearchText = searchText.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
        zregex = new RegExp(escapedSearchText, 'i');
        regex = this.get_search_regex(escapedSearchText);
        _ref = this.results_data;

        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            option = _ref[_i];
            option.search_match = true;
            results_group = null;
            if (this.include_option_in_results(option)) {
                if (option.group) {
                    option.group_match = true;
                    option.active_options = 0;
                }
                if ((option.group_array_index != null) && this.results_data[option.group_array_index]) {
                    results_group = this.results_data[option.group_array_index];
                    if (results_group.active_options === 0 && results_group.search_match) {
                        results += 1;
                    }
                    results_group.active_options += 1;
                }
                option.search_text = option.group ? option.label : option.html;
                if (!(option.group && !this.group_search)) {
                    option.search_match = true;
                    if (option.search_match && !option.group) {
                        results += 1;
                    }
                    if (option.search_match) {
                        if (searchText.length) {
                            startpos = option.search_text.search(zregex);
                            text = option.search_text.substr(0, startpos + searchText.length) + '</em>' + option.search_text.substr(startpos + searchText.length);
                            option.search_text = text.substr(0, startpos) + '<em>' + text.substr(startpos);
                        }
                        if (results_group != null) {
                            results_group.group_match = true;
                        }
                    } else if ((option.group_array_index != null) && this.results_data[option.group_array_index].search_match) {
                        option.search_match = true;
                    }
                }
            }
        }

        this.result_clear_highlight();

        if (results < 1 && searchText.length) {
            this.update_results_content("");
            return this.no_results(searchText);
        } else {
            this.update_results_content(this.results_option_build());
            return this.winnow_results_set_highlight();
        }
    }

    return FuzzyQuery;

})(jQuery, AGJ.common);