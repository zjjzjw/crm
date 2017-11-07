/* jshint undef: false, unused: false, camelcase: false, expr: true, eqeqeq: false */
define(['zepto', 'zepto.temp', 'page.params'], function($, temp, params) {
    var Page = function(ops) {
        var aMapOps = {
            'mapPoint': {
                'lng': params.lng,
                'lat': params.lat
            }
        };
        aMap(aMapOps);
    }();

    function aMap(ops) {
        var _aMapPoint = ops.mapPoint;
        var _lng = _aMapPoint.lng;
        var _lat = _aMapPoint.lat;
        var mapObj, marker;
        var iconPath = '/www';

        if (!_lng || !_lat || _lng <= 0 || _lat <= 0) {
            _lng = 121.473701;
            _lat = 31.230416;
        }

        //初始化地图对象，加载地图
        (function mapInit() {
            mapObj = new AMap.Map("map", {
                //二维地图显示视口
                view: new AMap.View2D({
                    center: new AMap.LngLat(_lng, _lat), //地图中心点
                    zoom: 13 //地图显示的缩放级别
                })
            });
            mapObj.plugin(["AMap.ToolBar"], function() {
                toolBar = new AMap.ToolBar({
                    direction: true, //隐藏方向导航
                    ruler: true, //隐藏视野级别控制尺
                    autoPosition: false //禁止自动定位
                });
                mapObj.addControl(toolBar);
            });

            mapObj.plugin(["AMap.Scale"],function(){ //加载比例尺插件
                scale = new AMap.Scale();
                mapObj.addControl(scale);
                scale.show();
            });

        })();

        //添加点标记
        (function addMarker() {
            marker = new AMap.Marker({
                icon:  iconPath ? iconPath + '/image/map_icon.png' : "http://webapi.amap.com/images/marker_sprite.png",
                position: new AMap.LngLat(_lng, _lat)
            });

            marker.setMap(mapObj); //在地图上添加点
            //mapObj.setFitView(); //调整到合理视野
        })();
    }
});