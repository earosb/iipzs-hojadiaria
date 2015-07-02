function TrabajoController($scope, $http) {
    $scope.trabajos = [];
    $scope.errors = [];

    $http.get('programar/list').
        success(function (data) {
            $scope.trabajos = data;
            $scope.loading = false;
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

}
