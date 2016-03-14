/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * PagesLayoutController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('PagesLayoutController', ['$scope', function($scope) {

  /**
   * Initialize
   */
  $scope.initialize = function(header, major, minor, footer) {
    $scope.selectLayout(header, major, minor, footer);
  };

  /**
   * レイアウトの選択
   */
  $scope.selectLayout = function(header, major, minor, footer) {
    $scope.currentLayout =
        header + '_' + major + '_' + minor + '_' + footer + '.png';
    $scope.header = header;
    $scope.major = major;
    $scope.minor = minor;
    $scope.footer = footer;
  };

}]);


/**
 * PagesWeightController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $http)} Controller
 */
NetCommonsApp.controller('PagesEditController',
    ['$scope', 'NetCommonsModal', function($scope, NetCommonsModal) {

      /**
       * ページデータ保持用
       */
      $scope.pages = {};

      /**
       * Initialize
       */
      $scope.initialize = function(pages, treeList, parentList) {
        $scope.pages = pages;
        $scope.treeList = treeList;
        $scope.parentList = parentList;
      };

      /**
       * インデント
       */
      $scope.indent = function(pageId) {
        var range = [];
        var parentId = $scope.pages[pageId]['Page']['parent_id'];
        var nest = $scope.parentList['_' + parentId]['_' + pageId]['nest'];
        for(var i = 1; i < nest; i++) {
          range.push(i);
        }
        return range;
      };

      /**
       * インデント
       */
      $scope.indented = function(pageId) {
        var range = [];
        var parentId = $scope.pages[pageId]['Page']['parent_id'];
        var nest = $scope.parentList['_' + parentId]['_' + pageId]['nest'];

        return (nest !== 0);
      };

      /**
       * パーマリンク
       */
      $scope.permalink = function(pageId) {
        if ($scope.pages[pageId]['Page']['lft'] === '1') {
          return '';
        } else {
          return $scope.pages[pageId]['Page']['permalink'];
        }
      };

      /**
       * 移動ボタンのdisabled
       */
      $scope.moveDisabled = function(type, pageId) {
        if ($scope.$parent.sending) {
          return true;
        }

        var parentId = $scope.pages[pageId]['Page']['parent_id'];
        var parentList = $scope.parentList['_' + parentId];

        if (type === 'up') {
          if (parentList['_' + pageId]['weight'] == 1) {
            return true;
          } else {
            return false;
          }
        } else if (type === 'down') {
          var maxWeight = 0;
          angular.forEach(parentList, function(page) {
            maxWeight = page['weight'];
          });
          if (parentList['_' + pageId]['weight'] == maxWeight) {
            return true;
          } else {
            return false;
          }
        } else if (type === 'move') {
          var rootId = $scope.pages[pageId]['Page']['root_id'];
          if (rootId !== parentId) {
            return false;
          }

          var maxWeight = 0;
          angular.forEach(parentList, function(page) {
            maxWeight = page['weight'];
          });
          if (maxWeight > 1) {
            return false;
          } else {
            return true;
          }
        }
      };

      /**
       * 表示順の登録
       */
      $scope.saveWeight = function(type, pageId) {
        $scope.$parent.sending = true;

        angular.element('input[name="data[Page][id]"]')[0].value = pageId;

        var key = 'input[name="data[Page][parent_id]"]';
        var parentId = $scope.pages[pageId]['Page']['parent_id'];
        angular.element(key)[0].value = parentId;

        angular.element('input[name="data[Page][type]"]')[0].value = type;
        angular.element('form')[0].submit();
      };

      /**
       * ページ移動ダイアログ表示
       *
       * @return {void}
       */
      $scope.showMoveDialog = function(pageId) {
        var roomId = $scope.pages[pageId]['Page']['room_id'];
        NetCommonsModal.show(
            $scope, 'PagesMoveController',
            $scope.baseUrl +
                    '/pages/pages_edit/popup_move/' + roomId + '/' + pageId,
            {backdrop: 'static', size: 'md'}
        );
      };

    }]);


/**
 * PagesMoveController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $modalInstance)} Controller
 */
NetCommonsApp.controller('PagesMoveController',
    ['$scope', '$modalInstance', function($scope, $modalInstance) {

      /**
       * キャンセル処理
       *
       * @return {void}
       */
      $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
      };

    }]);
