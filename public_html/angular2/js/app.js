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
        //esta es la forma de decirle a angular que vamos a pasar una variable por la url
        .when('/info/:id', {
            templateUrl: "angular2/templates/info.html",
            controller: "infoController"
        })
        .when("/add", {
            title: 'Añadir usuario',
            templateUrl: "angular2/templates/add.html",
            controller: "addController"
        })
        .when("/edit/:id", {
            title: 'Editar usuario',
            templateUrl: "angular2/templates/edit.html",
            controller: "editController"
        })
        .when("/remove/:id", {
            title: 'Eliminar usuario',
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
            var endDate;

            var selectCurrentWeek = function () {
                window.setTimeout(function () {
                    $(element).find('.ui-datepicker-current-day a').addClass('ui-state-active');
                }, 1);
            };

            $(element).datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                beforeShow: function () {
                    $(".ui-datepicker").css('font-size', 12);
                },
                onSelect: function (dateText, inst) {
                    var date = $(this).datepicker('getDate');
                    startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
                    endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
                    var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
                    $('#startDate').text($.datepicker.formatDate(dateFormat, startDate, inst.settings));
                    $('#endDate').text($.datepicker.formatDate(dateFormat, endDate, inst.settings));

                    selectCurrentWeek();
                },
                beforeShowDay: function (date) {
                    var cssClass = '';
                    if (date >= startDate && date <= endDate)
                        cssClass = 'ui-datepicker-current-day';
                    return [true, cssClass];
                },
                onChangeMonthYear: function (year, month, inst) {
                    selectCurrentWeek();
                }
            });

            $('.week-picker .ui-datepicker-calendar tr').live('mousemove', function () {
                $(this).find('td a').addClass('ui-state-hover');
            });
            $('.week-picker .ui-datepicker-calendar tr').live('mouseleave', function () {
                $(this).find('td a').removeClass('ui-state-hover');
            });
        }
    };
});
