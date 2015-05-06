var module1 = angular.module('TodoService', ['ngResource']).factory('Todo', ['$resource', function ($resource) {
    var Todo = $resource('/api/todo/:todoId', {}, {
        update: { method: 'PUT'}
    });
    return Todo;
}]);

//var storeServices = angular.module('storeServices', []);
module1.factory('Store', ['$rootScope',
  function($rootScope){
    return {
      query: function(callback) {
        Tabletop.init({
          key: '0AhPhtlCrkuIFdEQ0TzNsSUl0QmFMdmU3QUcxRlhJV1E',
          simpleSheet: true,
          parseNumbers: true,
          callback: function(data, tabletop) {
            if(callback && typeof(callback) === "function") {
              $rootScope.$apply(function() {
                callback(data);
              });
            }
          }
        });
      }
    };
  }]);

//var storeCatalogServices = angular.module('storeCatalogServices', []);
module1.factory('StoreCatalog', ['$rootScope',
  function ($rootScope) {
    return {
      query: function (callback) {
        Tabletop.init({
          key: '104eFWvSA54xQ7b2HpNt6yTzuGyJxH-CmVLxIYeBeD7w',
          simpleSheet: true,
          parseNumbers: true,
          callback: function (data, tabletop) {
            if (callback && typeof (callback) === "function") {
              $rootScope.$apply(function () {
                callback(data);
              });
            }
          }
        });
      }
    };
  }]);
