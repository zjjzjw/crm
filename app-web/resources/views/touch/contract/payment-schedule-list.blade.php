<?php Huifang\Web\Http\Controllers\Resource::addCSS(array('css/contract/payment-schedule-list')); ?>

@extends('layouts.touch')
@section('content')
    <div class="list-content">
        @include('partials.list-header', [
               'choose' => $choose
        ])
        <ul class="hinder">
            @foreach($months as $key => $name)
                <li>
                    <a href="{{route('contract.payment-schedule-detail',['user_id' => $user_id, 'month' => $key])}}">
                        {{$name}}<span>></span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection