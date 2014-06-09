var ncPutBoxId = null;


NetCommonsApp.controller("PluginController", function($scope,$filter) {
	$scope.plugins = [
		{id:1, name:"お知らせ"},
		{id:2, name:"掲示板", disabled:true},
		{id:3, name:"TODO", disabled:true},
		{id:4, name:"ブログ", disabled:true}
	];

    $scope.frameId = 0;
    $scope.blockId = 0;
    $scope.dataId  = 0;
    $scope.boxId   = 0;
    $scope.pluginName = '';
    $scope.PluginId = 0;

    $scope.getPluginName = function (pluginId){
        $scope.pluginName = $filter("filter")($scope.plugins, {
            name: pluginId
        });
        alert($scope.pluginName);
        $scope.PluginId = pluginId;
    };

	$scope.snapshot = function(url) {
		if (url) {
			return url;
		}

		return "/pages/img/snapshot_noimage.png";
	};

	$scope.selectPlugin = function(pluginId) {
		$("#pagesPlugin [name=box_id]").val(ncPutBoxId);
		$("#pagesPlugin [name=plugin_id]").val(pluginId);
		$("#pagesPlugin").submit();
	};

	$scope.showPluginList = function(boxId) {
		ncPutBoxId = boxId;
        $scope.boxId = boxId;
	};

    $scope.deleteFrame = function (flameId) {
        /*
        $scope.frameId = flameId ;
        var FrameTag = "#frame-id-" + $scope.frameId;
        $(FrameTag).addClass('hidden'); */
    }


});

NetCommonsApp.controller("BoxController", function($scope) {
	$scope.showPluginList = function(boxId) {
		ncPutBoxId = boxId;
        $scope.boxId = boxId;
	};

});

NetCommonsApp.controller("PagesBlockSetting", function($scope, $http,$filter) {
    $scope.PluginId = 0;
    $scope.frameId = 0;

    $scope.PagesBlockSettingShow = function (pluginId , frameId, getUrl){
        $scope.frameId = frameId;
        $scope.PluginId = pluginId;

        var modalTag = '#frame-setting-show_'
            + $scope.frameId;

        //get
        $http({method: 'GET', url: getUrl + '/' + Math.random()})
            .success(function(data, status, headers, config) {
                 $(modalTag + ' .modal-body').html(data);
                //モーダルを開く
                $(modalTag).modal("show");
            })
            .error(function(data, status, headers, config) {
                alert('ERROR!');
            });
    }

});
