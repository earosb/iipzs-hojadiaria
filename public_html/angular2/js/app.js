//creamos nuestro modulo llamado app
var app = angular.module("app", ['ngRoute']);

// Sobreescribe headers para detectar AJAX en laravel
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);

// Route provider
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