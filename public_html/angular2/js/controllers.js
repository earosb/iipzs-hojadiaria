app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];
    $scope.selection = [];
    $scope.loading_div = 0;
    $scope.orderByField = 'km_inicio';
    $scope.reverseSort = false;

    $http.get('programar').success(function (data) {
        $scope.trabajos = data;
    });

    $http.get('grupos').success(function (data) {
        $scope.grupos = data;
    });

    $http.get('trabajo').success(function (data) {
        $scope.partidas = data;
    });

    $scope.createTrabajo = function (nTrabajo) {
        $scope.loading_div = +1;
        $http.post('programar', nTrabajo)
            .success(function (data) {
                if (!data.error) {
                    $scope.trabajos.push(data.trabajo);
                    $scope.errors = [];
                    $scope.loading_div = -1;
                } else $scope.errors = data.msg;
            });
    };

    $scope.deleteTrabajo = function (trabajo, index) {
        if (confirm('¿Eliminar ' + trabajo.nombre + '?')) {
            $scope.loading_div = +1;
            $http.delete('programar/' + trabajo.id)
                .success(function (data) {
                    if (!data.error) {
                        $scope.trabajos.splice(index, 1);
                        $scope.loading_div = -1;
                    }
                });
        }
    };

    $scope.updateTrabajo = function (trabajo) {
        $scope.loading_div = +1;
        $http.put('programar/' + trabajo.id, trabajo).
        success(function (data) {
            if (!data.error) $scope.loading_div = -1;
        });
    };
    //Filtrar
    $scope.filtrar = function (filtro) {
        $http.get('programar', {
            params: filtro
        }).success(function (data) {
            $scope.trabajos = data;
        });
    };

    $scope.pdf = function (pdf) {
        var url = "/programar/pdf?g=" + pdf.g.id + '&s=' + pdf.s;
        window.open(url);
    };

    // Select all
    /*
     $scope.selectAll = function () {
     $scope.selection.length = 0;
     if ($scope.selectedAll) {
     $scope.selectedAll = true;
     } else {
     $scope.selectedAll = false;
     }
     console.log($scope.selectedAll);
     angular.forEach($scope.Items, function (item) {
     item.Selected = $scope.selectedAll;
     });
     };
     */
    // Toggle selection
    $scope.toggleSelection = function toggleSelection(trabajo) {
        var idx = $scope.selection.indexOf(trabajo.id);
        // is currently selected
        if (idx > -1) {
            $scope.selection.splice(idx, 1);
        }
        // is newly selected
        else {
            $scope.selection.push(trabajo.id);
        }
    };

    $scope.deleteSelected = function () {
        console.log($scope.selection.length);
        if (confirm('¿Eliminar trabajos seleccionados?')) {
            angular.forEach($scope.selection, function (value, key) {
                console.log('value ' + value + ' key ' + key);
                $http.delete('programar/' + value)
                    .success(function (data) {
                        if (!data.error) {
                            //$scope.trabajos.splice(index, 1);
                        }
                    });
            });
        }
    }

});

app.controller("editController", function editController($scope, $http, $routeParams, $location) {
    $scope.loading_div = +1;
    $scope.textButton = "Editar programa trabajo";
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.editTrabajo = function () {
        //actualizamos la información del usuario con la id que lleva $routeParams
        $scope.trabajos[$routeParams.id] = $scope.trabajo;
        $location.url("/");
        $http.put('programar/' + $scope.trabajo.id, $scope.trabajo).
        success(function (data) {
            if (!data.error) $scope.loading_div = -1;
        });
    };
});

app.controller("removeController", function removeController($scope, $http, $routeParams, $location) {
    $scope.loading_div = +1;
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.removeTrabajo = function () {
        $http.delete('programar/' + $scope.trabajo.id)
            .success(function (data) {
                console.log(data);
                if (!data.error) {
                    $scope.trabajos.splice($routeParams.id, 1);
                    $location.url("/");
                    $scope.loading_div = -1;
                } else {
                    console.log(data);
                }
            });
    };
});
