$(document).ready(function () {

    $('i').click(function () {
        let publicationId = $(this).find('i');
        const recipeId = this.dataset.recipeId;
        console.log(recipeId);

        $.ajax({
            url: 'https://127.0.0.1:8000/api/likes/recipes/' + recipeId,
            type: 'post',
            success: function (data) {
                // Code pour gérer la réponse de la requête AJAX
            }
        });
    });

    $('.recipeImg').hover(function() {
        $(this).find('i').css('display', 'flex');
    }, function() {
        $(this).find('i').css('display', 'none');
    });
});