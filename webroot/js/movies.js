function search(form) {
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(), // serializes the form's elements.
        headers: {"Authorization": localStorage.getItem('user_token')},
        success: function (data)
        {
            var tbody = $('table tbody');
            tbody.find('tr').empty().remove();

            if (data.data) {
                $.each(data.data, function (index, value) {

                    var button_remove = $('<button class="btn btn-danger btn-delete-movie">' +
                            '<i class="fa fa-times"></i>' +
                            '</button>');

                    var checkbox_viewed = $('<input type="checkbox" name="checked" value="true" class="set-watched">');

                    tbody.append($('<tr movies_users_id="' + value.id + '">').append(
                            $('<td class="text-center">').html(button_remove.attr('movie_id', value.id)),
                            $('<td class="text-center">').text(value.title),
                            $('<td class="text-center">').text(value.created),
                            $('<td class="text-center">').html(checkbox_viewed
                            .attr('movie_id', value.id)
                            .prop('checked', value.watched)))
                            );
                });
            }
        }
    });
}

$(document).on("change", ".set-watched", function (event) {
    var checked = $(this).is(':checked') ? 1 : 0;
    var id = $(this).attr('movie_id')

    $.ajax({
        type: "POST",
        url: '/API/movies/setWatched',
        data: {id: id, watched: checked},
        headers: {"Authorization": localStorage.getItem('user_token')},
        success: function (data) {
            if (data <= 0) {
                alert('Si è verificato un errore');
            }
        },
        error: function () {
            alert('Si è verificato un errore');
        },
    });
});

$(document).on("click", ".btn-delete-movie", function (event) {
    var id = $(this).attr('movie_id');
    var element = $(this);

    $.ajax({
        type: "POST",
        url: '/API/movies/delete',
        data: {id: id},
        headers: {"Authorization": localStorage.getItem('user_token')},
        success: function (data) {
            if (data > 0) {
                element.closest('tr').fadeOut('fast').remove();
            }
            else {
                alert("si è verificato un errore");
            }
        },
        error: function () {
            alert("si è verificato un errore");
        },
    });
});

$(document).on('ready', function () {

    // Add user
    $("#add_movie").submit(function (e) {
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(), // serializes the form's elements.
            headers: {"Authorization": localStorage.getItem('user_token')},
            success: function (data)
            {
                if (data.type == 'success') {
                    $('.flash-success').removeClass('hidden').show();
                    $('.flash-error').hide();
                    $('.flash-success .message').html(data.message);

                    if (data.type == 'error') {
                        $('.flash-success').hide();
                        $('.flash-error').removeClass('hidden').show();
                        $('.flash-error .message').html(data.message);
                    }

                }
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    // Search Movies
    $("#search_movies").submit(function (e) {
        search($(this));
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

});

$("#movie_name").keypress(function (event) {
    var availableMovies = [];
    $.getJSON("https://api.themoviedb.org/3/search/movie?api_key=" + api_key + "&language=it-IT&query=" + $(this).val(), function (data) {
        $.each(data.results, function (index, value) {
            availableMovies.push(value.title);
        });
        $(event.target).autocomplete({
            source: availableMovies
        });
    });
});