angular.module('socialMediaApp').factory('notificationService', ['$http', '$rootScope', function($http, $rootScope) {
    // Initialize Pusher
    const pusher = new Pusher('YOUR_PUSHER_APP_KEY', {
        cluster: 'YOUR_PUSHER_APP_CLUSTER',
        encrypted: true
    });

    // Subscribe to the notification channel
    const channel = pusher.subscribe('notification-channel');

    // Listen for new notification events
    channel.bind('new-notification', function(data) {
        // Broadcast the notification event to the Angular app
        $rootScope.$broadcast('newNotification', data);
    });

    return {
        // Fetch notifications from the server
        fetchNotifications: function() {
            return $http.get('/api/notifications');
        },
        
        // Clear notifications on the server
        clearNotifications: function() {
            return $http.delete('/api/notifications');
        }
    };
    
}]);
