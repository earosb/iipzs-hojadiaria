//creamos nuestro modulo llamado app
var app = angular.module("app", ['ngRoute']);

// Sobreescribe headers para detectar AJAX en laravel
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);

// Route provider
app.config(['$routeProvider', function ($routeProvider) {
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
}]);

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
                    var dayFlag = date.getDay() != 0 ? 7 : 0;
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + dayFlag);
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

// Tabs with panels directive
/*
 app.directive('showTab', function () {
 return {
 link: function (scope, element, attrs) {
 element.on('click', function (e) {
 e.preventDefault();
 $(element).tab('show');
 });
 }
 };
 });
 */

// Bootstrap tooltip and popover directive
app.directive('toggle', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            if (attrs.toggle == "tooltip") {
                $(element).tooltip();
            }
            if (attrs.toggle == "popover") {
                $(element).popover();
            }
        }
    };
});

// capitalize input (mayúsculas) directive
app.directive('capitalize', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, modelCtrl) {
            var capitalize = function (inputValue) {
                if (inputValue == undefined) inputValue = '';
                var capitalized = inputValue.toUpperCase();
                if (capitalized !== inputValue) {
                    modelCtrl.$setViewValue(capitalized);
                    modelCtrl.$render();
                }
                return capitalized;
            };
            modelCtrl.$parsers.push(capitalize);
            capitalize(scope[attrs.ngModel]);  // capitalize initial value
        }
    };
});

// Loading view directive
app.directive('loading', ['$http', function ($http) {
    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            scope.isLoading = function () {
                return $http.pendingRequests.length > 0;
            };
            scope.$watch(scope.isLoading, function (v) {
                if (v) {
                    elm.show();
                } else {
                    elm.hide();
                }
            });
        }
    };
}]);

// Bootstrap modal directive
app.directive('modal', function () {
    return {
        template: '<div class="modal fade">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +
        '<div class="modal-header">' +
        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
        '<h4 class="modal-title">Editar {{ selection.length }} trabajo(s) seleccionado(s)</h4>' +
        '</div>' +
        '<div class="modal-body" ng-transclude></div>' +
        '</div>' +
        '</div>' +
        '</div>',
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: true,
        link: function postLink(scope, element, attrs) {
            scope.title = attrs.title;

            scope.$watch(attrs.visible, function (value) {
                if (value == true)
                    $(element).modal('show');
                else
                    $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = true;
                });
            });

            $(element).on('hidden.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = false;
                });
            });
        }
    };
});

// Alert confirm message directive
app.directive('ngConfirmClick', function () {
    return {
        link: function (scope, element, attr) {
            var msg = attr.ngConfirmClick || "¿Confirmar acción?";
            var clickAction = attr.confirmedClick;
            element.bind('click', function (event) {
                if (window.confirm(msg)) {
                    scope.$apply(clickAction)
                }
            });
        }
    };
});