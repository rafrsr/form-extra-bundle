(function ($) {
    $.fn.angularController = function (callback, services, modules) {

        function randomString(length) {
            var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');

            if (!length) {
                length = Math.floor(Math.random() * chars.length);
            }

            var str = '';
            for (var i = 0; i < length; i++) {
                str += chars[Math.floor(Math.random() * chars.length)];
            }
            return str;
        }

        this.each(function (controller) {
                //get origin data
                var modelValues = {};
                var element = this;
                $(element).find('[ng-model]').each(function () {
                    var modelName = $(this).attr('ng-model');
                    var modelValue = $(this).val();
                    if ($(this).is('[type="checkbox"]')) {
                        modelValue = $(this).prop('checked');
                    }
                    modelValues[modelName] = modelValue;
                });

                //init angular for this element
                var name = randomString(20);
                $(element).attr('ng-controller', name);
                if (modules === undefined) {
                    modules = [];
                }

                if (services) {
                    callback.$inject = services;
                }

                angular.module(name, modules).controller(name, callback);
                angular.bootstrap(element, [name]);

                //populate with origin data
                var $scope = angular.element(element).scope();
                $scope.$apply(function () {
                    $.each(modelValues, function (index, value) {
                        $scope[index] = value;
                    });
                });
            }
        );

        return this;
    };
}(jQuery));