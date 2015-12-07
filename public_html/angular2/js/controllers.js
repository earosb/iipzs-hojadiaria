app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];
    $scope.selection = [];
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
        $http.post('programar', nTrabajo)
            .success(function (data) {
                if (!data.error) {
                    $scope.trabajos.push(data.trabajo);
                    $scope.errors = [];
                    nTrabajo.causa = '';
                    nTrabajo.trabajo_id = '';
                    nTrabajo.km_inicio = '';
                    nTrabajo.km_termino = '';
                    nTrabajo.cantidad = '';
                } else $scope.errors = data.msg;
            });
    };

    $scope.deleteTrabajo = function (trabajo) {
        if (confirm('¿Eliminar ' + trabajo.nombre + '?')) {
            $http.delete('programar/' + trabajo.id)
                .success(function (data) {
                    if (!data.error) {
                        var idx = $scope.trabajos.indexOf(trabajo);
                        $scope.trabajos.splice(idx, 1);
                    }
                });
        }
    };

    $scope.updateTrabajo = function (trabajo) {
        $http.put('programar/' + trabajo.id, trabajo)
            .success(function (data) {
                if (!data.error){
                    trabajo.status = data.status;
                    if (trabajo.no_programable) trabajo.semana = '';
                }
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

    // Toggle selection
    $scope.toggleSelection = function toggleSelection(trabajo) {
        var idx = $scope.selection.indexOf(trabajo);
        if (idx > -1) $scope.selection.splice(idx, 1);
        else $scope.selection.push(trabajo);
    };

    // Elimina trabajos seleccionados
    $scope.deleteSelected = function () {
        if (confirm('¿Eliminar ' + $scope.selection.length + ' trabajos seleccionados?')) {
            angular.forEach($scope.selection, function (trabajo) {
                $http.delete('programar/' + trabajo.id)
                    .success(function (data) {
                        if (!data.error) {
                            var idx = $scope.trabajos.indexOf(trabajo);
                            $scope.trabajos.splice(idx, 1);
                            $scope.selection.length = 0;
                        }
                    });
            });
        }
    };

    // Actualiza trabajos seleccionados
    $scope.updateSelected = function (modal) {
        angular.forEach($scope.selection, function (trabajo) {
            trabajo.causa = modal.causa;
            trabajo.grupo_trabajo_id = modal.grupo_trabajo_id;
            trabajo.semana = modal.semana;
            trabajo.vencimiento = modal.vencimiento;
            $http.put('programar/' + trabajo.id, trabajo)
                .success(function (data) {
                    if (!data.error) trabajo.status = data.status;
                });
        });
    };

    // Marca como realizados trabajos seleccionados
    $scope.markAsDone = function() {
        angular.forEach($scope.selection, function (trabajo) {
            trabajo.realizado = true;
            trabajo.status = 'success';
            $http.put('programar/' + trabajo.id, trabajo)
                .success(function (data) {
                    if (!data.error) trabajo.status = data.status;
                });
        });
    };

});

// Edita un trabajo seleccionado en vista completa
app.controller("editController", function editController($scope, $http, $routeParams, $location) {
    $scope.textButton = "Editar programa trabajo";
    var i, item, length = $scope.trabajos.length;
    for (i = 0; i < length; i++) {
        item = $scope.trabajos[i];
        if (item.id == $routeParams.id)
            break;
    }
    $scope.trabajo = item;
    $scope.editTrabajo = function () {
        $location.url("/");
        $http.put('programar/' + $scope.trabajo.id, $scope.trabajo)
            .success(function (data) {
                if (!data.error) $scope.trabajos[i] = $scope.trabajo;
            });
    };
});
