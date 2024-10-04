angular.module('socialMediaApp').factory('notificationService', ['$http', function($http) {
    return {
        fetchNotifications: function() {
            return $http.get('/api/notifications');
        },
        clearNotifications: function() {
            return $http.delete('/api/notifications');
        }
    };
}]);
