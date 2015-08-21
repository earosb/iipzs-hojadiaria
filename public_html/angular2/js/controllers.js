app.controller("appController", function appController($scope, $http) {
    $scope.trabajos = [];

    $http.get('programar').
    success(function(data) {
        $scope.trabajos = data;
    });

    $http.get('grupos').
    success(function(data) {
        $scope.grupos = data;
    });

    $http.get('trabajo').
    success(function(data) {
        $scope.partidas = data;
    });

    $scope.addTrabajo = function(programa) {
        $http.post('programar', programa).
        success(function(data) {
            if (!data.error) {
                $scope.trabajos.push(data.t);
            }
        });
    };

    //Filtrar
    $scope.filtrar = function(filtro) {
        $location.path() == '/a';
        $http.get('programar/list', {
            params: filtro
        }).success(function(data) {
            $scope.trabajos = data;
        });
    };

    $scope.pdf = function(pdf) {
        var url = "/programar/pdf?g=" + pdf.g.id + '&s=' + pdf.s;
        console.log(url);
        // window.location = url;
        window.open(
            url,
            '_blank'
        );
        // $http.post('programar/pdf', pdf).
        //     success(function (data) {
        //         console.log(data);
        //     });
    };
});

//route params es para identificar los segmentos de la url, en este caso, para reconocer usuarios
app.controller("infoController", function infoController($scope, $routeParams) {
    $scope.trabajo = $scope.trabajos[$routeParams.id];
});

//creamos el controlador addController para guardar usuarios nuevos con push
app.controller("addController", function addController($scope, $location) {
    $scope.textButton = "Añadir un nuevo usuario";
    $scope.usuario = {};
    $scope.newUser = function() {
        $scope.usuarios.push($scope.usuario);
        $location.url("/");
    };
});

app.controller("editController", function editController($scope, $http, $routeParams, $location) {
    //obtenemos el usuario a editar con routeParams
    $scope.textButton = "Editar programa trabajo";
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.editTrabajo = function() {
        //actualizamos la información del usuario con la id que lleva $routeParams
        $scope.trabajos[$routeParams.id] = $scope.trabajo;
        $location.url("/");
        console.log($scope.trabajo);
        $http.put('programar/' + $scope.trabajo.id, $scope.trabajo).
        success(function(data) {
            console.debug(data);
        });
    };
});

//eliminamos el usuario dependiendo de su id
app.controller("removeController", function removeController($scope, $routeParams, $location) {
    $scope.trabajo = $scope.trabajos[$routeParams.id];
    $scope.removeTrabajo = function() {
        //con splice  eliminamos un usuario del array usuarios, en este caso le decimos que debe eliminar
        //el que tenga el id que le pasamos con $routeParams, y con el 1, le decimos que sólo
        //debe eliminar 1, la función splice, como primer parámetro necesita la posición, que en este caso
        //es la id, y el segundo debe ser el número de elementos a eliminar, cabe decir que splice tiene
        //más variantes, y que sirve para añadir y eliminar elementos en un array, pero eso para otro momento
        $scope.trabajos.splice($routeParams.id, 1);
        $location.url("/");
    };
});
