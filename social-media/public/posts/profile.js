angular.module('profileApp', [])
.controller('ProfileController', ['$scope', '$http', function($scope, $http) {
    $scope.user = {};
    $scope.profile = {};
    $scope.editMode = false;

    // Fetch user and profile information when the controller loads
    $scope.fetchProfile = function() {
        $http.get('/api/profile')
            .then(function(response) {
                $scope.user = response.data.user;
                $scope.profile = response.data.profile || {};  // Ensure profile is initialized as an object
            })
            .catch(function(error) {
                console.error('Error fetching profile:', error);
                alert('Error fetching profile: ' + error.data.message);
            });
    };
    
    // Call the function to fetch profile data
    $scope.fetchProfile();

    // Update profile
    $scope.updateProfile = function() {
        var formData = new FormData();
        
        // Append the file object only if a new file has been selected
        if ($scope.profile.profile_picture instanceof File) {
            formData.append('profile_picture', $scope.profile.profile_picture);
        }
    
        formData.append('bio', $scope.profile.bio || '');
        formData.append('address', $scope.profile.address || '');
        formData.append('phone_number', $scope.profile.phone_number || '');
        
        $http.post('/api/profile', formData, {
            headers: {
                'Content-Type': undefined // Let Angular set the content type
            }
        })
        .then(function(response) {
            alert(response.data.message);
            $scope.editMode = false; // Exit edit mode after success
            $scope.fetchProfile(); // Refresh the profile data
        })
        .catch(function(error) {
            console.error('Error updating profile:', error);
            alert('Error updating profile: ' + error.data.message);
        });
    };
    $scope.previewProfilePicture = function() {
        if ($scope.profile.profile_picture instanceof File) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $scope.$apply(function() {
                    $scope.profile.previewSrc = e.target.result;
                });
            };
            reader.readAsDataURL($scope.profile.profile_picture);
        }
    };
    
    
}]);