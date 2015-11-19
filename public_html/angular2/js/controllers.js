app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];

    $http.get('programar')
        .success(function (data) {
            $scope.trabajos = data;
        });

    $http.get('grupos')
        .success(function (data) {
            $scope.grupos = data;
        });

    $http.get('trabajo')
        .success(function (data) {
            $scope.partidas = data;
        });

    $scope.addTrabajo = function (programa) {
        $http.post('programar', programa)
            .success(function (data) {
                if (!data.error) {
                    $scope.trabajos.push(data.t);
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

    $scope.pdf = function (pdf) {
        var url = "/programar/pdf?g=" + pdf.g.id + '&s=' + pdf.s;
        window.open(url, '_blank');
    };

    $scope.updateDayTrabajo = function (dia, id) {
        $http.get('programar/' + id + '/edit-day', {
            params: {dia: dia}
        }).success(function (data) {
            console.log(data);
        });
    };

    $scope.updateGrupoTrabajo = function (trabajo) {
        $http.get('programar/' + trabajo.id + '/edit-grupo-trabajo', {
            params: {grupo_trabajo_id: trabajo.grupo_trabajo_id}
        }).success(function (data) {
            console.log(data);
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
                console.debug(data);
                if (!data.error) {
                    //NO ERROR
                } else {
                    //ERROR
                }
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
