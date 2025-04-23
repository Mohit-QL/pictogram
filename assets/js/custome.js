// Preview Post Image

var input = document.querySelector('#select_post_image');
input.addEventListener('change', preview);

function preview() {
    var fileObject = this.files[0];
    var fileReader = new FileReader();

    fileReader.readAsDataURL(fileObject);
    fileReader.onload = function () {
        var image_src = fileReader.result;
        var image = document.querySelector('#post_image');
        image.setAttribute('src',image_src);
        image.setAttribute('style','display:');
    }

}

// For Follow List

// $(".followbtn").click(function(){
//     var userId = $(this).data('userId');

//     $(this).text(userId);
// })