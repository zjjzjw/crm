<?php Huifang\Admin\Http\Controllers\Resource::addJS(array('app/company/user/data')); ?>
<?php Huifang\Admin\Http\Controllers\Resource::addCSS(['css/company/user/data']); ?>

@extends('layouts.master')

@section('master.content')

    <div class="wrap-content">
        @if (count($errors) > 0)
            <p class="error-alert">
                @foreach ($errors->all() as $key => $error)
                    {{$key + 1}}、 {{ $error }}
                @endforeach
            </p>
        @endif

        <form id="form" action="{{route('company.user.data.store')}}"
              method="POST">
            <div class="content">
                <span class="title">数据权限：</span>
                <ul class="first-level level-box">
                    @foreach($departs ?? [] as $depart)
                        <li class="permission">
                            <div class="level">
                                <span class="left-icon to-all" data-parentid="0" data-id="{{$depart['id']}}">+</span>
                                <input name="depart_ids[]" id="checkbox{{$depart['id']}}" type="checkbox"
                                       @if(in_array($depart['id'], $user_data_ids ?? []))
                                       checked
                                       @endif
                                       value="{{$depart['id']}}">
                                <label for="checkbox{{$depart['id']}}">{{$depart['name'] or ''}}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="text-center">
                <input type="hidden" name="id" value="{{$id ?? 0}}">
                <input type="submit" class="button" value="保存">
            </div>
        </form>
    </div>
<script type="text/html" id="node_tpl">
    <ul class="level-box">
        <% for ( var i = 0; i < result.length; i++ ) { %>
            <li class="permission">
                <div class="level">
                    <span class="left-icon to-all" data-parentid="<%=result[i].parent_id%>" data-id="<%=result[i].id%>">+</span>
                    <input name="depart_ids[]" id="checkbox<%=result[i].id%>" type="checkbox"
                        <%if(result[i].select){%>
                            checked
                          <%}%>
                           value="<%=result[i].id%>">

                    <label for="checkbox"><%=result[i].name%></label>
                </div>
            </li>
        <% } %>
    </ul>
</script>
@endsection