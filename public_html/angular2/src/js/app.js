//creamos nuestro modulo llamado app
var app = angular.module("app", ['ngRoute']);

// Sobreescribe headers para detectar AJAX en laravel
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);

// Route provider
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when("/", {
            templateUrl: "angular2/src/templates/index.html"
        })
        .when("/edit/:id", {
            title: 'Editar',
            templateUrl: "angular2/src/templates/edit.html",
            controller: "editController"
        })
        .otherwise({redirectTo: "/"});
}]);

// Filtro que permite paginar la tabla principal
app.filter('startFrom', function () {
    return function (input, start) {
        start = +start;
        return input.slice(start);
    };
});

// Datepicker directive select day
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
app.directive("modalShow", ['$parse', function ($parse) {
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
            //Hide or show the modal
            scope.showModal = function (visible, elem) {
                if (!elem)
                    elem = element;

                if (visible)
                    $(elem).modal("show");
                else
                    $(elem).modal("hide");
            };
            //Watch for changes to the modal-visible attribute
            scope.$watch(attrs.modalShow, function (newValue, oldValue) {
                scope.showModal(newValue, attrs.$$element);
            });
            //Update the visible value when the dialog is closed through UI actions (Ok, cancel, etc.)
            $(element).bind("hide.bs.modal", function () {
                $parse(attrs.modalShow).assign(scope, false);
                if (!scope.$$phase && !scope.$root.$$phase)
                    scope.$apply();
            });
        }

    };
}]);

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

// Convierte strings en numeros para inputs de tipo number
app.directive('stringToNumber', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return '' + value;
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value, 2);
            });
        }
    };
});
