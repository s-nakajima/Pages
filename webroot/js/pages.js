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
    ['$scope', '$http', function($scope, $http) {

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
        var nest = $scope.parentList[parentId][pageId]['nest'];
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
        var nest = $scope.parentList[parentId][pageId]['nest'];

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
        if (type === 'up') {
          if ($scope.parentList[parentId][pageId]['weight'] === 1) {
            return true;
          } else {
            return false;
          }
        } else if (type === 'down') {
          var maxWeight = 0;
          angular.forEach($scope.parentList[parentId], function(page) {
            maxWeight = page['weight'];
          });
          if ($scope.parentList[parentId][pageId]['weight'] === maxWeight) {
            return true;
          } else {
            return false;
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

    }]);


/**
 * PagesMoveController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('PagesMoveController',
    ['$scope', function($scope) {

      /**
       * Initialize
       */
      $scope.initialize = function() {
      };

      /**
       * 表示順の登録
       */
      $scope.saveWeight = function() {

      };

    }]);
