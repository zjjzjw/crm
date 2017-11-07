<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/user/card/list')); ?>
<?php Huifang\Web\Http\Controllers\Resource::addJS(array('app/user/card/list')); ?>
@extends('layouts.touch')
@section('content')
    <div class="card-content">
        @include('partials.list-header',
        [
           'url' => '',
           'choose' => ['title' => '名片夹', 'url'=> route('user.card.edit', ['id' => 0])],
           'add_permission' => 'user.card.add'
        ])
        <div id="slider" class="slider">
            <div class="slider-content">
                <ul class="slider-box">
                    @foreach($alphas as $alpha)
                        @if(!empty($alpha['cards']))
                            <li id="{{$alpha['name']}}"><a name="a" class="title">{{$alpha['name']}}</a>
                                <ul class="node-box">
                                    @foreach($alpha['cards'] as $card)
                                        <li><a href="{{route('user.card.detail', ['id' => $card['id']])}}"><p
                                                        class="name">{{$card['name'] or ''}}
                                                    <span>{{$card['position_name'] or ''}}</span>
                                                </p>
                                                <p class="company">
                                                    {{$card['company_name'] or ''}}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="letter">
                <ul>
                    <li><a href="javascript:;">A</a></li>
                    <li><a href="javascript:;">B</a></li>
                    <li><a href="javascript:;">C</a></li>
                    <li><a href="javascript:;">D</a></li>
                    <li><a href="javascript:;">E</a></li>
                    <li><a href="javascript:;">F</a></li>
                    <li><a href="javascript:;">G</a></li>
                    <li><a href="javascript:;">H</a></li>
                    <li><a href="javascript:;">I</a></li>
                    <li><a href="javascript:;">J</a></li>
                    <li><a href="javascript:;">K</a></li>
                    <li><a href="javascript:;">L</a></li>
                    <li><a href="javascript:;">M</a></li>
                    <li><a href="javascript:;">N</a></li>
                    <li><a href="javascript:;">P</a></li>
                    <li><a href="javascript:;">Q</a></li>
                    <li><a href="javascript:;">R</a></li>
                    <li><a href="javascript:;">S</a></li>
                    <li><a href="javascript:;">T</a></li>
                    <li><a href="javascript:;">W</a></li>
                    <li><a href="javascript:;">X</a></li>
                    <li><a href="javascript:;">Y</a></li>
                    <li><a href="javascript:;">Z</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection