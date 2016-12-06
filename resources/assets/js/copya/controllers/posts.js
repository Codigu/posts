'use strict';

function PostCtrl($scope, $sce, $state, $stateParams, postService) {
    $scope.posts = [];
    $scope.post = {};


    $scope.submitPostForm = function(isValid) {
        // check to make sure the form is completely valid
        console.log(isValid);
        if (isValid) {
            if($scope.post.id){
                postService.update({id: $scope.category.id}, $scope.category, function (result) {
                    $scope.category = {};
                    $scope.category_.$setUntouched();
                    $scope.category_.$setPristine();
                }, function (err) {
                    console.log(err);
                });
            } else {
                postService.save({}, $scope.post, function (result) {
                    $scope.posts.push(result.data);
                    $scope.posts = {};
                    $scope.post_.$setUntouched();
                    $scope.post_.$setPristine();
                    $state.go('posts.index');
                }, function (err) {
                    console.log(err);
                });
            }
        }
    };

    $scope.dropzoneConfig = {
        parallelUploads: 3,
        maxFileSize: 30,
        maxFiles: 1,
        url: '/api/files',
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        },
        headers: {
            'X-CSRF-TOKEN': Laravel.csrfToken
        },
    };

    $scope.success = function(file, response){
        $scope.post.featured_image = response.data.file;
        console.log($scope.post.featured_image);
    };


    $scope.addNewPost = function(){
        $state.go('posts.add');
    };

    $scope.editCategory = function(category){
        $scope.category = category;
        $scope.toggleSlideUpSize();
    };

    if($state.is('posts.index')){
        postService.query({}, function(result){
            $scope.posts = result.data;
            console.log(result.data);
        }, function(err){

        });
    }

}

PostCtrl.$inject = ['$scope', '$sce', '$state', '$stateParams', 'postService'];

angular.module('copya', ['ui.tree'])
    // Chart controller 
    .controller('PostCtrl', PostCtrl);


