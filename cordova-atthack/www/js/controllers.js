function TodoController($scope, Todo, $http) {
    $scope.todos = Todo.query();

    $scope.selectTodo = function (id) {
        $scope.todo = _.where($scope.todos, {_id: id})[0];
    }

    $scope.newTodo = function () {
        $scope.todo = new Todo();
    }

    $scope.saveTodo = function () {
        if ($scope.todo._id == null) {
            Todo.save({}, $scope.todo, function (data) {
                $scope.todos.push(data);
            });
        }
        else {
            Todo.update({todoId: $scope.todo._id}, $scope.todo, function (data) {
            });
        }
    }

    $scope.completeTodo = function (id) {
        Todo.delete({todoId: id}, function () {
            $scope.todos = _.without($scope.todos, $scope.todo);
        });
    }

    $scope.getPrices = function (upc) {
         $http.get('/prices?upc='+upc+'&searchindex=all')
         .success(function(data) {
            $scope.prices = data;
        });
    }    
}

var storeControllers = angular.module('storeControllers', []);

storeControllers.controller('StoreCtrl', ['$scope', 'Store',
  function ($scope, Store) {
    Store.query(function(data) {
      $scope.stores = data;
    });
  }]);

var storeCatalogControllers = angular.module('storeCatalogControllers', []);

storeCatalogControllers.controller('StoreCatalogCtrl', ['$scope', 'StoreCatalog',
  function ($scope, StoreCatalog) {
    StoreCatalog.query(function (data) {
      $scope.storeitems = data;
      console.log(data);
    });
  }]);


