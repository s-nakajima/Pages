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
        for(var i = 0; i < nest; i++) {
          range.push(i);
        }
        return range;
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
        var data = {
          Page: {
            id: pageId,
            parent_id: $scope.pages[pageId]['Page']['parent_id'],
            type: type
          },
          _Token: $scope.pages[pageId]['_Token']
        }

        $http.get($scope.baseUrl + '/net_commons/net_commons/csrfToken.json')
          .success(function(token) {
              data._Token.key = token.data._Token.key;

              //POSTリクエスト
              $http.post(
                  $scope.baseUrl + '/pages/pages_edit/move.json',
                  $.param({_method: 'POST', data: data}),
                  {cache: false,
                    headers:
                        {'Content-Type': 'application/x-www-form-urlencoded'}
                  }
              ).success(function(data) {
                $scope.flashMessage(data.name, data.class, data.interval);
                $scope.$parent.sending = false;

                $scope.treeList = data.treeList;
                $scope.parentList = data.parentList;

              }).error(function(data, status) {
                $scope.flashMessage(data['name'], 'danger', 0);
                $scope.$parent.sending = false;
              });
            });
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
