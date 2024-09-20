<!-- resources/views/posts.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>


<body ng-controller="PostController">
<div class="container mt-5">
    <h1>Create post</h1>
    <br>
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Post Creation Form -->
    <form ng-submit="createPost()" class="mb-4">
        <div class="mb-3">
            <textarea ng-model="newPost.content" class="form-control" placeholder="Write something..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>

    <ul>
        <li ng-repeat="post in posts">
            <p>{{ 'post' }} </p>
            <small> BY {{ post.user.name }} on {{ post.created_at }}</small>
        </li>
    </ul>

<!-- AngularJS -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
<script src="js/angular.js"></script>
<script>
    angular.module('social-media').controller('PostController', function($scope, $http) {
    $scope.posts = [];
    $scope.newPost = {};

    // Function to create a new post
    $scope.createPost = function() {
        $http.post('/api/posts', $scope.newPost)
        .then(function(response) {
            $scope.posts.unshift(response.data);
            $scope.newPost = {}; // Clear the form
        }, function(error) {
            alert('Error creating post');
        });
    };

    // Function to get all posts
    $scope.getPost = function() {
        $http.get('/api/posts').then(function(response) { 
            $scope.posts = response.data;
        }, function(error) {
            alert('Error fetching posts');
        });
    };

    // Fetch posts on controller initialization
    $scope.getPost();
});

</script>

</body>
</html>
