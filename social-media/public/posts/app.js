angular.module('socialMediaApp', [])
    .controller('PostController', ['$scope', '$http', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};
        $scope.loggedInUser = {}; // Add the current logged-in user's data
        $scope.notifications = []; // Initialize notifications
        $scope.unreadCount = 0; // Initialize unread notifications count

        // Fetch current logged-in user info
        $scope.getLoggedInUser = function() {
            $http.get('/api/user') // Assumes there's an API route to fetch the logged-in user's info
                .then(function(response) {
                    $scope.loggedInUser = response.data;
                    console.log($scope.loggedInUser); // Debug logged-in user data
                });
        };

        // Create a new post
        $scope.createPost = function() {
            const postData = {
                content: $scope.newPost.content,
                // Include other required fields here, if any
            };
        
            $http.post('/api/posts', postData)
                .then(function(response) {
                    // Handle success
                    $scope.posts.push(response.data);
                    $scope.newPost.content = ''; // Clear input field
                })
                .catch(function(error) {
                    console.error('Error creating post:', error);
                });
        };

        // Fetch all posts
        $scope.getPosts = function() {
            $http.get('/api/posts')
                .then(function(response) {
                    $scope.posts = response.data;
                }, function(error) {
                    alert('Error fetching posts: ' + error.data.message);
                });
        };

        // Like a post
// Like or unlike a post
$scope.likePost = function(post) {
    $http.post('/api/posts/' + post.id + '/like')
        .then(function(response) {
            // Update the post based on the response
            post.like_count = response.data.likes_count; // Update like count from response
            post.user_has_liked = response.data.liked; // Update UI to reflect like/unlike state
        }, function(error) {
            alert('Error liking post: ' + error.data.message);
        });
};

        // Add a comment to a post
        $scope.addComment = function(post) {
            const data = {
                comment: post.newComment
            };
    
            $http.post('/api/posts/' + post.id + '/comments', data).then(function(response) {
                // Push the new comment to the post's comments array
                post.comments.push(response.data);
    
                // Clear the comment input field
                post.newComment = '';
            }, function(error) {
                console.error('Error adding comment:', error);
            });
        };

        // Edit a post (only the creator can edit)
        $scope.editPost = function(post) {
            console.log(post.user.id); // Debug the user ID associated with the post
            if (post.user.id === $scope.loggedInUser.id) {
                post.editing = true;
                post.updatedContent = post.content;
            } else {
                alert('You are not authorized to edit this post.');
            }
        };

        // Save changes to a post after editing
        $scope.savePost = function(post) {
            $http.put('/api/posts/' + post.id, { content: post.updatedContent })
                .then(function(response) {
                    post.content = post.updatedContent; // Update post content
                    post.editing = false; // Exit editing mode
                }, function(error) {
                    alert('Error updating post: ' + error.data.message);
                });
        };

        // Initialize by fetching posts and user info
        $scope.getPosts();
        $scope.getLoggedInUser();
    }])
    .controller('NotificationController', ['$scope', '$http', function($scope, $http) {
        $scope.notifications = [];
        $scope.unreadCount = 0;

        // Fetch notifications for the logged-in user
        $scope.fetchNotifications = function() {
            $http.get('/api/notifications') // Assumes there's an API route to fetch notifications
                .then(function(response) {
                    $scope.notifications = response.data;
                    $scope.unreadCount = $scope.notifications.filter(n => !n.is_read).length; // Count unread notifications
                })
                .catch(function(error) {
                    console.error('Error fetching notifications:', error);
                });
        };

        // Clear all notifications
        $scope.clearNotifications = function() {
            $http.post('/api/notifications/clear') // Assumes there's an API route to clear notifications
                .then(function(response) {
                    $scope.notifications = [];
                    $scope.unreadCount = 0;
                })
                .catch(function(error) {
                    console.error('Error clearing notifications:', error);
                });
        };

        // Call fetchNotifications on controller initialization
        $scope.fetchNotifications();

        var pusher = new Pusher('27594a89bb0dc5e5956c', {
            cluster: 'ap1'
          });
          var channel = pusher.subscribe('my-channel');
          channel.bind('my-event',function(data){
            alert
          });
          $scope.showNotifications = function() {
            $http.get('/api/notifications')
                .then(function(response) {
                    $scope.notifications = response.data;
                    $scope.unreadCount = response.data.filter(n => !n.is_read).length;
                });
        };
    }]);
