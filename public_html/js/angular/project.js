function TrabajoController($scope, $http) {
    $scope.trabajos = [];
    $scope.tAux = [];

    $http.get('programar/list').
        success(function (data) {
            $scope.trabajos = data;
        });

    $scope.getTotaltrabajos = function () {
        return $scope.trabajos.length;
    };

    $scope.addTrabajo = function (programa) {
        var formData = {
            'causa': programa.causa,
            'trabajo_id': programa.trabajo_id,
            'km_inicio': programa.km_inicio,
            'km_termino': programa.km_termino,
            'cantidad': programa.cantidad
        };
        $http.post('programar', formData).
            success(function (data) {
                if (!data.error) {
                    console.log(data);
                    $scope.trabajos.push(data.t);
                }
            });

        $scope.programa.causa = '';
        $scope.programa.trabajo_id = '';
        $scope.programa.km_inicio = '';
        $scope.programa.km_termino = '';
        $scope.programa.cantidad = '';
    };

    $scope.removeTrabajo = function () {
        var id = this.t.id;
        $http.delete('programar/' + id).
            success(function (data) {
                console.debug('data: ', data);
                $scope.trabajos = _.filter($scope.trabajos, function (trabajo) {
                    return trabajo.id != id;
                });
            });
    };

    $scope.editModalTrabajo = function () {
        $scope.tAux = this.t;
        console.debug('this.t', this.t);
        $('#modalPlanificarTrabajo').modal('toggle')
    };

    $scope.editTrabajo = function (tAux) {
        $('#modalPlanificarTrabajo').modal('toggle');
        console.debug('tAux', tAux);
    };

    $scope.newCausa = function () {
        var op = $scope.formData.causa;
        if (op == 'new') {
            $('#modalCausa').modal('toggle');
        }
    };

    $scope.addCausa = function (causa) {
        console.log(causa);
        $scope.causas.push(causa);
    };

}
