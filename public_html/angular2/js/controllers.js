app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];
    $scope.orderByField = 'km_inicio';
    $scope.reverseSort = false;
    $scope.currentPage = 0;
    $scope.pageSize = 1;

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
        selected.forEach(function (trabajo) {
            if (modal.causa) trabajo.causa = modal.causa;
            if (modal.grupo_trabajo_id) trabajo.grupo_trabajo_id = modal.grupo_trabajo_id;
            if (modal.semana) trabajo.semana = modal.semana;
            if (modal.vencimiento) trabajo.vencimiento = modal.vencimiento;
            if (modal.lun) trabajo.lun = modal.lun;
            if (modal.mar) trabajo.mar = modal.mar;
            if (modal.mie) trabajo.mie = modal.mie;
            if (modal.juv) trabajo.juv = modal.juv;
            if (modal.vie) trabajo.vie = modal.vie;
            if (modal.sab) trabajo.sab = modal.sab;
            if (modal.dom) trabajo.dom = modal.dom;
            $http.put('programar/' + trabajo.id, trabajo)
                .success(function (data) {
                    if (!data.error) trabajo.status = data.status;
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
