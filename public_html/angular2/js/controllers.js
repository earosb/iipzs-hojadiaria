app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];
    $scope.orderByField = 'km_inicio';
    $scope.reverseSort = false;
    $scope.currentPage = 0;
    $scope.pageSize = 20;

    $http.get('programar').success(function (data) {
        $scope.trabajos = data;
        console.info('trabajos', data.length);
    });

    $http.get('grupos').success(function (data) {
        $scope.grupos = data;
        console.info('grupos', data.length);
    });

    $http.get('trabajo').success(function (data) {
        $scope.partidas = data;
        console.info('partidas', data.length);
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

    // Select all
    $scope.selectAll = function () {
        var toggleStatus = !$scope.isAllSelected;
        angular.forEach($scope.trabajos, function(trabajo){ trabajo.selected = toggleStatus; });
        $scope.isAllSelected = toggleStatus;
    };

    function isAllSelected(elemento, indice, arrreglo) {
        return elemento.selected === true;
    }

    // Toggle selection
    $scope.toggleSelection = function () {
        $scope.isAllSelected = $scope.trabajos.every(isAllSelected);
    };

    // Elimina trabajos seleccionados
    $scope.deleteSelected = function () {
        var selected = [];
        angular.forEach($scope.trabajos, function(trabajo){
            if (trabajo.selected){
                selected.push(trabajo);
            }
        });
        selected.forEach(function(trabajo){
            $http.delete('programar/' + trabajo.id)
                .success(function (data) {
                    if (!data.error) {
                        var idx = $scope.trabajos.indexOf(trabajo);
                        $scope.trabajos.splice(idx, 1);
                    }
                });
        });
    };

    // Actualiza trabajos seleccionados
    $scope.updateSelected = function (modal) {
        var selected = [];
        angular.forEach($scope.trabajos, function(trabajo){
           if (trabajo.selected){
               selected.push(trabajo);
           }
        });

        var t = {};

        if (modal.causa) t.causa = modal.causa;
        if (modal.grupo_trabajo_id) t.grupo_trabajo_id = modal.grupo_trabajo_id;
        if (modal.semana) t.semana = modal.semana;
        if (modal.vencimiento) t.vencimiento = modal.vencimiento;
        if (modal.lun) t.lun = modal.lun;
        if (modal.mar) t.mar = modal.mar;
        if (modal.mie) t.mie = modal.mie;
        if (modal.juv) t.juv = modal.juv;
        if (modal.vie) t.vie = modal.vie;
        if (modal.sab) t.sab = modal.sab;
        if (modal.dom) t.dom = modal.dom;

        var data = {
            modal: t,
            trabajos: selected
        };

        $http.post('programar/selected', data)
            .success(function (response) {
                if (response.error) return;
                var status = response.status;
                angular.forEach($scope.trabajos, function (trabajo) {
                    if (trabajo.selected) {
                        trabajo.selected = false;
                        status.forEach(function (s) {
                            if (trabajo.id == s.id) {
                                trabajo.status = s.class;
                            }
                        });
                        if (data.modal.causa) trabajo.causa = data.modal.causa;
                        if (data.modal.grupo_trabajo_id) trabajo.grupo_trabajo_id = data.modal.grupo_trabajo_id;
                        if (data.modal.semana) trabajo.semana = data.modal.semana;
                        if (data.modal.vencimiento) trabajo.vencimiento = data.modal.vencimiento;
                        if (data.modal.lun) trabajo.lun = data.modal.lun;
                        if (data.modal.mar) trabajo.mar = data.modal.mar;
                        if (data.modal.mie) trabajo.mie = data.modal.mie;
                        if (data.modal.juv) trabajo.juv = data.modal.juv;
                        if (data.modal.vie) trabajo.vie = data.modal.vie;
                        if (data.modal.sab) trabajo.sab = data.modal.sab;
                        if (data.modal.dom) trabajo.dom = data.modal.dom;
                    }
                });
            });

        modal.causa = null;
        modal.grupo_trabajo_id = null;
        modal.semana = null;
        modal.vencimiento = null;
        modal.lun = null;
        modal.mar = null;
        modal.mie = null;
        modal.juv = null;
        modal.vie = null;
        modal.sab = null;
        modal.dom = null;
    };

    // Archiva trabajos seleccionados
    $scope.archiveSelected = function() {
        var selected = [];
        angular.forEach($scope.trabajos, function(trabajo){
            if (trabajo.selected){
                selected.push(trabajo);
            }
        });
        selected.forEach(function(trabajo){
            trabajo.realizado = true;
            trabajo.status = 'success';
            $http.put('programar/' + trabajo.id, trabajo)
                .success(function (data) {
                    if (!data.error) trabajo.status = data.status;
                });
        });
    };

    // Calcula el número de páginas
    $scope.numberOfPages = function() {
        return Math.floor($scope.trabajos.length/$scope.pageSize);
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
