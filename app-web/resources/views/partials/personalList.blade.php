@if(!empty($properties))
    <div class="hot-sale">
        <ul class="property-list">
            @foreach($properties as $items)
                <li class="list-item track-link">
                    <a class="sale-item" href="{{$items['url']}}">
                        <img src="{{$items['cover_image']}}-200x150">
                        <div class="right-box">
                            <p class="title">{{$items['title']}}<em>&nbsp;&nbsp;{{$items['sale_status']}}</em></p>
                            @if(!empty($items['district']))
                                <p>{{!empty($items['district']['name']) ? $items['district']['name'] : ''}}{{!empty($items['block']['name']) ? '-'.$items['block']['name'] : ''}}</p>
                            @endif
                            <div class="tag-box">
                                @foreach($items['tags'] as $tags)
                                    <span>{{$tags}}</span>
                                @endforeach
                            </div>
                            @if(!empty($items['metro_stations']))
                                <span class="underline"><i class="iconfont">&#xe666;</i>{{implode('、',array_unique(
                                    explode(',',
                                    implode(',',
                                    array_map(function ($item) {
                                    return implode(',', array_pluck($item, 'number'));
                                    }, array_pluck($items['metro_stations'], 'lines'))
                                    )
                                    )
                                    )).'号线'}}</span>
                            @endif
                            @if(!empty($items['discount_desc']))
                                <p class="privilege"><em>惠</em>&nbsp;{{$items['discount_desc']}}</p>
                            @endif
                        </div>
                        <span class="price">{{$items['unit_price']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @else
    <div class="no-result">
        <i class="iconfont search-icon">&#xe606;</i>

        <p class="h3">没有符合条件的结果</p>

        <p class="h3">换个条件试试</p>
    </div>
@endif
<!-- 查看更多 -->
    <script type="text/html" id="common_list_tpl">
        <% for ( var i = 0; i < names.length; i++ ) { %>
            <% var name = names[i]; var url = '';url = name['url'];%>
             <li class="list-item track-link">
                <a class="sale-item" href="<%=url%>">
                    <img class="lazy" src="<%=name.cover_image%>-200x150">
                    <div class="right-box">
                        <p class="title"><%=name.title%><em>&nbsp;&nbsp;<%=name.sale_status%></em></p>
                        <%if(name.district&&name.block){%>
                             <p><%=name.district.name%>-<%=name.block.name%></p>
                         <%}else if(name.district){%>
                             <p><%=name.district.name%></p>
                        <%}%>
                        <div class="tag-box">
                            <% for (var k = 0;k<name.tags.length;k++){%>
                                <span><%=name.tags[k]%></span>
                           <% } %>
                        </div>
                        <%if(name.metro_stations){
                            var metroStations = name.metro_stations;
                            var num = [];
                            for(var m=0;m<metroStations.length; m++) {
                                var lines = metroStations[m].lines;
                                for(var j=0; j<lines.length; j++) {
                                    num.push(lines[j].number);
                                }
                            }
                            var linesStr = num.join(",");
                        %>
                            <span class="underline"><i class="iconfont">&#xe666;</i><%=linesStr%>号线</span>
                        <%}%>
                        <%if(name.discount_desc){%>
                            <p class="privilege"><em>惠</em>&nbsp;<%=name.discount_desc%></p>
                        <%}%>
                    </div>
                    <span class="price"><%=name.unit_price%></span>
                </a>
            </li>
        <% } %>
    </script>