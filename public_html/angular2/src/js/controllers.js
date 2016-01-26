app.controller("appController", ['$scope', '$http', 'alertify', function appController($scope, $http, alertify) {
    alertify.logPosition("bottom right");
    $scope.trabajos = [];
    $scope.orderByField = 'km_inicio';
    $scope.reverseSort = false;
    $scope.currentPage = 0;
    $scope.pageTotal = 0;
    $scope.nextPage = 0;
    $scope.currentPage = 1;
    $scope.lastPage = 1;
    $scope.filtro = {
        page: 1,
        causa: null,
        trabajo_id: null,
        km_inicio: null,
        km_termino: null,
        grupo_trabajo_id: null,
        semana: null,
        vencimiento: null,
        realizado: false
    };

    $http.get('programar', $scope.filtro).success(function (data) {
        $scope.trabajos = data.data;
        $scope.currentPage = data.current_page;
        $scope.lastPage = data.last_page;
        $scope.nextPage = data.current_page + 1;
        $scope.pageTotal = data.total;
        console.info('trabajos', data.data.length);
    });

    $http.get('grupos').success(function (data) {
        $scope.grupos = data;
        console.info('grupos', data.length);
    });

    $http.get('trabajo').success(function (data) {
        $scope.partidas = data;
        console.info('partidas', data.length);
    });

    $scope.loadMore = function () {
        $scope.filtro.page = $scope.nextPage;
        $http.get('programar', {
            params: $scope.filtro
        }).success(function (data) {
            var trabajos = data.data;
            trabajos.forEach(function (t) {
                $scope.trabajos.push(t);
            });
            $scope.currentPage = data.current_page;
            $scope.lastPage = data.last_page;
            $scope.nextPage = data.current_page + 1;
            $scope.pageTotal = data.total;
            console.info('current_page', data.current_page);
        });
    };

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
                if (!data.error) {
                    trabajo.status = data.status;
                    if (trabajo.no_programable) trabajo.semana = '';
                }
            });
    };

    //Filtrar
    $scope.filtrar = function () {
        $scope.filtro.page = 1;
        $http.get('programar', {
            params: $scope.filtro
        }).success(function (data) {
            console.info('filtro', $scope.filtro);
            $scope.trabajos = data.data;
            $scope.currentPage = data.current_page;
            $scope.lastPage = data.last_page;
            $scope.nextPage = data.current_page + 1;
            $scope.pageTotal = data.total;
        });
    };

    // Select all
    $scope.selectAll = function () {
        var toggleStatus = !$scope.isAllSelected;
        angular.forEach($scope.trabajos, function (trabajo) {
            trabajo.selected = toggleStatus;
        });
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
        angular.forEach($scope.trabajos, function (trabajo) {
            if (trabajo.selected) {
                selected.push(trabajo);
            }
        });

        if (!validateSelected(selected, 'eliminar')) return;

        selected.forEach(function (trabajo) {
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
        angular.forEach($scope.trabajos, function (trabajo) {
            if (trabajo.selected) {
                selected.push(trabajo);
            }
        });

        if (!validateSelected(selected, 'editar')) return;

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
    $scope.archiveSelected = function () {
        var selected = [];
        angular.forEach($scope.trabajos, function (trabajo) {
            if (trabajo.selected) {
                selected.push(trabajo);
            }
        });

        if (!validateSelected(selected, 'archivar')) return;

        selected.forEach(function (trabajo) {
            trabajo.realizado = true;
            trabajo.status = 'success';
            $http.put('programar/' + trabajo.id, trabajo)
                .success(function (data) {
                    if (!data.error) trabajo.status = data.status;
                });
        });
    };

    // Agrupa trabajos seleccionados
    $scope.mergeSelected = function () {
        var selected = [];
        angular.forEach($scope.trabajos, function (trabajo) {
            if (trabajo.selected) {
                selected.push(trabajo);
            }
        });

        if (!validateSelected(selected, 'agrupar')) return;

        $http.post('programar/merge', {trabajos: selected})
            .success(function (data) {
                if (!data.error) {
                    $scope.trabajos.push(data.trabajo);
                    $scope.deleteSelected();
                } else {
                    alertify.error(data.msg);
                }
            });
    };

    // Calcula el número de páginas
    $scope.numberOfPages = function () {
        return Math.floor($scope.trabajos.length / $scope.pageSize);
    };

    $scope.checkByClick = function (t) {
        t.selected = !t.selected;
    };

    function validateSelected(selected, functionName) {
        if (selected.length <= 1) {
            alertify.error('Seleccione dos o más trabajos para ' + functionName);
            return false;
        } else {
            return true;
        }
    }
}]);

// Edita un trabajo seleccionado en vista completa
app.controller("editController", ['$scope', '$http', '$routeParams', '$location', 'alertify', function editController($scope, $http, $routeParams, $location, alertify) {
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
}]);
