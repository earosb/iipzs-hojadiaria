function TrabajoController($scope, $http) {
    $scope.trabajos = [];
    $scope.errors = [];
    $scope.tAux = [];

    $http.get('programar/list').
        success(function (data) {
            $scope.trabajos = data;
        });

    $scope.getTotaltrabajos = function () {
        return $scope.trabajos.length;
    };

    $scope.addTrabajo = function () {
        var formData = {
            'causa': $scope.formData.causa,
            'trabajo_id': $scope.formData.trabajo_id,
            'km_inicio': $scope.formData.km_inicio,
            'km_termino': $scope.formData.km_termino,
            'cantidad': $scope.formData.cantidad
        };

        $http.post('programar', formData).
            success(function (data) {
                if (!data.error) {
                    $scope.trabajos.push(data.t);
                } else {
                    $scope.errors.push(data.msg);
                }
            });

        $scope.formData.causa = '';
        $scope.formData.trabajo_id = '';
        $scope.formData.km_inicio = '';
        $scope.formData.km_termino = '';
        $scope.formData.cantidad = '';
    };

    $scope.removeTrabajo = function () {
        var id = this.t.id;
        $http.delete('programar/' + id).
            success(function (data) {
                console.debug('data: ', data);
                $scope.trabajos = _.filter($scope.trabajos, function(trabajo){
                    return trabajo.id != id;
                });
            });
    };

    $scope.editModalTrabajo = function () {
        $scope.tAux = this.t;
        $('#modalPlanificarTrabajo').modal('toggle')
    };

    $scope.editTrabajo = function () {
        $scope.tAux = this.t;
        $('#modalPlanificarTrabajo').modal('toggle')
    };

}
