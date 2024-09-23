angular.module('profileApp', [])
.controller('ProfileController', ['$scope', '$http', function($scope, $http) {
    $scope.user = {};
    $scope.profile = {};
    $scope.editMode = false;

    // Fetch user and profile information
    $scope.fetchProfile = function() {
        $http.get('/api/profile').then(function(response) {
            console.log('Profile data:', response.data);
            $scope.user = response.data.user;
            $scope.profile = response.data.profile;
        }, function(error) {
            console.error('Error fetching profile:', error);
        });
    };

    // Update profile
    $scope.updateProfile = function() {
        if (!$scope.profile) {
            alert('Profile data is not available.');
            return;
        }
    
        let formData = new FormData();
        formData.append('bio', $scope.profile.bio || '');
        formData.append('address', $scope.profile.address || '');
        formData.append('phone_number', $scope.profile.phone_number || '');
    
        if ($scope.profile.profile_picture) {
            formData.append('profile_picture', $scope.profile.profile_picture);
        }
    
        $http.put('/api/profile', formData, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        }).then(function(response) {
            $scope.editMode = false;
            alert('Profile updated successfully!');
            $scope.fetchProfile(); // Refresh the profile data
        }, function(error) {
            console.error('Error updating profile:', error);
            alert('An error occurred while updating the profile. Please try again.');
        });
    };
    
    
}]);
