/**
 * @fileoverview Announcements Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * PagesController Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('PagesController', function($scope) {

  /**
   * Initialize
   *
   * @return {void}
   */
  $scope.initialize = function(header, major, minor, footer) {
    $scope.selectLayout(header, major, minor, footer);
  };

  /**
   * selectLayout
   *
   * @return {void}
   */
  $scope.selectLayout = function(header, major, minor, footer) {
    $scope.currentLayout = header + '_' + major + '_' + minor + '_' + footer + '.png';
    $scope.header = header;
    $scope.major = major;
    $scope.minor = minor;
    $scope.footer = footer;
  };

});
