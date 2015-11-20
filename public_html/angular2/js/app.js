//creamos nuestro modulo llamado app
var app = angular.module("app", ['ngRoute'])
    .config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    }]);

//hacemos el ruteo de nuestra aplicación
app.config(function ($routeProvider) {
    $routeProvider.when("/", {
        templateUrl: "angular2/templates/index.html"
    })
        .when("/edit/:id", {
            title: 'Editar',
            templateUrl: "angular2/templates/edit.html",
            controller: "editController"
        })
        .when("/remove/:id", {
            title: 'Eliminar',
            templateUrl: "angular2/templates/remove.html",
            controller: "removeController"
        })
        .otherwise({redirectTo: "/"});
});

// Datepicker directive
app.directive('jqdatepicker', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            $(element).datepicker({
                dateFormat: 'dd/mm/yy',
                beforeShow: function () {
                    $(".ui-datepicker").css('font-size', 12)
                },
                onSelect: function (date) {
                    scope.$apply(function () {
                        ngModelCtrl.$setViewValue(date);
                    });
                }
            });
        }
    };
});

// Datepicker directive select week
app.directive('jqdatepickerweek', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            var startDate;

            $(element).datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: 'dd/mm/yy',
                beforeShow: function () {
                    $(".ui-datepicker").css('font-size', 12);
                },
                onSelect: function (dateText, inst) {
                    var date = $(this).datepicker('getDate');
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 1);
                    var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
                    var dateFinal = $.datepicker.formatDate(dateFormat, startDate, inst.settings);
                    $(this).datepicker('setDate', dateFinal);
                    scope.$apply(function () {
                        ngModelCtrl.$setViewValue(dateFinal);
                    });
                }
            });
        }
    };
});
