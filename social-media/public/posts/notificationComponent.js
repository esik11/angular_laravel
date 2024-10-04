angular.module('socialMediaApp').controller('NotificationController', ['$scope', 'notificationService', function($scope, notificationService) {
    $scope.notifications = [];
    $scope.unreadCount = 0;

    $scope.fetchNotifications = function() {
        notificationService.fetchNotifications().then(function(response) {
            $scope.notifications = response.data;
            $scope.unreadCount = $scope.notifications.filter(n => !n.is_read).length;
        });
    };

    $scope.clearNotifications = function() {
        notificationService.clearNotifications().then(function(response) {
            $scope.notifications = [];
            $scope.unreadCount = 0;
        });
    };

    // Listen for real-time notifications
    Echo.channel('posts')
        .listen('NotificationSent', (event) => {
            $scope.notifications.push(event.notification);
            $scope.unreadCount++;
            $scope.$apply(); // Update the scope
        });

    $scope.fetchNotifications(); // Initial fetch
}]);
