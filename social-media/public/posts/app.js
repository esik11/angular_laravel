angular.module('socialMediaApp', [])
    .controller('PostController', function($scope, $http) {
        $scope.posts = [];
        $scope.newPost = {};

        // Create a new post
        $scope.createPost = function() {
            $http.post('/api/posts', $scope.newPost)
                .then(function(response) {
                    $scope.posts.unshift(response.data); // Add new post to the beginning of posts array
                    $scope.newPost = {}; // Clear the form
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
                    post.comments.push(response.data); // Add the new comment to the post's comments array
                    post.newComment = ''; // Clear the comment input
                }, function(error) {
                    alert('Error adding comment: ' + error.data.message);
                });
        };

        // Initialize by fetching posts
        $scope.getPosts();
    });
