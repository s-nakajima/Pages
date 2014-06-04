var ncPutBoxId = null;


NetCommonsApp.controller("PluginController", function($scope) {
	$scope.plugins = [
		{id:1, name:"お知らせ"},
		{id:2, name:"掲示板", disabled:true},
		{id:3, name:"TODO", disabled:true},
		{id:4, name:"ブログ", disabled:true}
	];

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
	};
});

NetCommonsApp.controller("BoxController", function($scope) {
	$scope.showPluginList = function(boxId) {
		ncPutBoxId = boxId;
	};
});
