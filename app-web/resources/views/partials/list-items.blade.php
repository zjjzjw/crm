<div class="list-items">
    <ul class="common-list">
        @foreach($list_items as $items)
            <li class="item-info">
                <a href="{{$items['url']}}">
                    <p class="item-title">{{$items['text']}}</p>
                    <p class="time">{{$items['time']}}</p>
                </a>
            </li>
        @endforeach
    </ul>
</div>
<!--下拉分页模板-->
<script type="text/html" id="common_list_tpl">
    <% for ( var i = 0; i < names.length; i++ ) { %>
    <% var name = names[i]; var url = '';url = name['url'];%>
    <li class="item-info">
        <a href="<%=url%>">
                    <p class="item-title"><%=name.text%></p>
                    <p class="time"><%=name.time%></p>
                </a>
            </li>
    <% } %>
</script>