<?php huifang\Web\Http\Controllers\Resource::addJS(array('ui.autocomplete'));?>
<?php huifang\Web\Http\Controllers\Resource::addCSS(array('css/ui/ui.autocomplete'));?>

<div class="header">
    <div>
        <input type="text" class="auto-ipt" id="auto_ipt" placeholder="搜索信息" autocomplete="off">
        <i class="iconfont icon-cancel" id="cancel_all">X</i>
    </div>
    <a href="javascript:;" class="search-icon" id="search_btn"><i class="iconfont">&#xe607;</i></a>
    <a href="javascript:;" class="btn-cancel" id="btn_cancel">取消</a>
</div>
<div class="auto-content" id="auto_content">
</div>


<script type="text/html" id="autocomplete_tpl">
    <% for ( var i = 0; i < names.length; i++ ) { %>
    <div class="item" data-id="<%=names[i].id%>" data-name="<%=names[i].name%>">
        <h3 class="h4"><%=names[i].repName%></h3>
        <p><%=names[i].time%></p>
    </div>
    <% } %>
</script>
