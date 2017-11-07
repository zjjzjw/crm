/**
 *  this.alterableSector = new AlterableSector({
 *      wrap: '#builder_names',
 *      rowWrap: '.row',
 *      template: '#builder_names_tmpl'
 *  });
 **/

;(function(){
    var Alert = require('./alert');

    var moduleName = (function($, common) {
        var AlterableSector = function(_op) {
            var self = this;

            common.inherit(this, common.Observer);

            self.op = $.extend({}, AlterableSector._op, _op || {});

            self.$wrap = $(self.op.wrap);
            self.$template = $(self.op.template);

            this.init();
            this.initEvent();
        };

        AlterableSector.prototype.init = function() {

        };

        AlterableSector.prototype.initEvent = function() {
            var self = this;

            self.$wrap.on('click', self.op.addClass, function(e) {
                self.trigger('beforeAdd', [$(this)]);

                var $temp = $(self.$template.html());

                $(this).closest(self.$wrap).append($temp);

                self.trigger('afterAdd', [$(this), $temp]);
            });

            self.$wrap.on('click', self.op.deleteClass, function(e) {
                var $this = $(this);

                self.trigger('beforeDelete', [$(this)]);

                Alert.confirm(self.op.deleteMsg || '你确定删除吗？', function(data) {
                    if (data.status) {
                        $this.closest(self.op.rowWrap).remove();
                    }
                    self.trigger('afterDelete', [$this]);
                })
            });

            self.$wrap.on('click', self.op.editClass, function(e) {
                self.trigger('edit', [$(this)]);
            });
        };

        AlterableSector._op = {
            addClass: '.add',
            deleteClass: '.delete',
            editClass: '.edit',
            wrap: '.wrap',
            rowWrap: '.row',
            template: '.template'
        };

        return AlterableSector;

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
