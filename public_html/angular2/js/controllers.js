app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];
    $scope.selection = [];
    $scope.orderByField = 'km_inicio';
    $scope.reverseSort = false;
    $scope.showModal = false;

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
    // Clear filter
    /*
     $scope.clearFiltro = function (filtro) {
     $http.get('programar').success(function (data) {
     $scope.trabajos = data;
     filtro.submit = false;
     filtro.causa = '';
     filtro.grupo_trabajo_id = '';
     filtro.semana = '';
     filtro.vencimiento = '';
     });
     };
     */

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
        var idx = $scope.selection.indexOf(trabajo);
        if (idx > -1) $scope.selection.splice(idx, 1);
        else $scope.selection.push(trabajo);
    };

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
            $scope.showModal = !$scope.showModal;
        });
    };

    $scope.toggleModal = function () {
        $scope.showModal = !$scope.showModal;
    };

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

app.controller("editController", function editController($scope, $http, $routeParams, $location) {
    $scope.textButton = "Editar programa trabajo";
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.editTrabajo = function () {
        //actualizamos la información del usuario con la id que lleva $routeParams
        $scope.trabajos[$routeParams.id] = $scope.trabajo;
        $location.url("/");
        $http.put('programar/' + $scope.trabajo.id, $scope.trabajo).
        success(function (data) {
        });
    };
});

app.controller("removeController", function removeController($scope, $http, $routeParams, $location) {
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.removeTrabajo = function () {
        $http.delete('programar/' + $scope.trabajo.id)
            .success(function (data) {
                console.log(data);
                if (!data.error) {
                    $scope.trabajos.splice($routeParams.id, 1);
                    $location.url("/");
                } else {
                    console.log(data);
                }
            });
    };
});
