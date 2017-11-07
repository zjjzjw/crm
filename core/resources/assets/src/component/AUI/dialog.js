;(function(){
    var moduleName = (function($, common) {
        
        var Dialog = function(_op) {
            common.inherit(this, common.Observer);

            var self = this;

            self.op = $.extend({}, Dialog._op, _op || {});
            
            this.init();
            this.initEvent();
        };

        Dialog.prototype.init = function() {
            var self = this;

            if($('#' + self.op.id).length > 0) {
                self.dom = $('#' + self.op.id);
            } else {
                $('body').append(common.rander(this.op.tpl, {id: this.op.id, title: this.op.title}));
                $(document).foundation();
                self.dom = $('#' + self.op.id);
                if (self.op.btnGroupTpl) {
                    self.dom.find('.dialog-footer').html(self.op.btnGroupTpl);
                }

                if (self.op.contentTpl) {
                    self.dom.find('.dialog-body').html(self.op.contentTpl);
                }
            }

            self.$body = self.dom.find('.dialog-body');
            self.$closeSelect = self.dom.find(self.op.closeSelect);
            self.$dialogBoxFooter = self.dom.find('.dialog-footer');
        };

        Dialog.prototype.initEvent = function() {
            var self = this;

            self.$dialogBoxFooter.on('click', '.button', function() {
                self.trigger('dialog_closed', [$(this)]);
            });

            self.$closeSelect.on('click', function() {
                self.close();
                self.trigger('dialog_closed', []);
            });
        };

        Dialog.prototype.open = function(str) {
            if (str) {
                this.$body.html(str);
            }
            this.dom.foundation('open');
            this.trigger('dialog_opened', []);
        };

        Dialog.prototype.close = function() {
            this.dom.foundation('close');
        };

        Dialog.prototype.setTitle = function(title) {
            this.dom.find('.dialog-title').text(title);
        };

        Dialog.prototype.setButtonGroup = function(buttonGroup) {
            this.dom.find('.dialog-footer').html(buttonGroup);
        };

        Dialog._op = {
            id: 'dialog',
            title: '标题',
            closeSelect: '.close-button',
            tpl: '<div class="reveal" id="{% id %}" data-reveal>\
                    <div class="dialog-header">\
                        <h5 class="dialog-title">{% title %}</h5>\
                        <button class="close-button" type="button">\
                            <span aria-hidden="true">&times;</span>\
                        </button>\
                    </div>\
                    <div class="dialog-body">\
                    </div>\
                    <div class="dialog-footer">\
                    </div>\
                </div>',
            btnGroupTpl: '<button class="hollow button small" data-status="0">取消</button>\
                        <button class="button small" data-status="1">确定</button>',
            contentTpl: '<p class="lead">你确定要删除？</p>'
        }

        return Dialog;
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
