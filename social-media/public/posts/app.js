angular.module('socialMediaApp', [])
    .controller('PostController', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};
        $scope.loggedInUser = {}; // Add the current logged-in user's data

        // Fetch current logged-in user info
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
            $http.post('/api/posts', $scope.newPost)
                .then(function(response) {
                    $scope.posts.unshift(response.data); 
                    $scope.newPost = {};
                }, function(error) {
                    alert('Error creating post: ' + error.data.message);
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
        $scope.likePost = function(post) {
            $http.post('/api/posts/' + post.id + '/like')
                .then(function(response) {
                    post.like_count++;
                }, function(error) {
                    alert('Error liking post: ' + error.data.message);
                });
        };

        // Add a comment to a post
        $scope.addComment = function(post) {
            $http.post('/api/posts/' + post.id + '/comments', { comment: post.newComment })
                .then(function(response) {
                    post.comments.push(response.data);
                    post.newComment = '';
                }, function(error) {
                    alert('Error adding comment: ' + error.data.message);
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
    });
