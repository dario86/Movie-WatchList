$(document).on('ready', function () {
// Add user
    $("#add_movie").submit(function (e) {
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(), // serializes the form's elements.
            success: function (data)
            {
//                var message = data.message.replace(/\n/g, "<br/>");
//                if (data.type == 'success') {
//                    $('.flash-success').removeClass('hidden').show();
//                    $('.flash-error').hide();
//                    $('.flash-success .message').html(message);
//                    console.log($(this));
//                    console.log($(this).find("input[type=text]"));
//                    form.find("input").val("");
//                } 
                if (data.type == 'error') {
                    $('.flash-success').hide();
                    $('.flash-error').removeClass('hidden').show();
                    $('.flash-error .message').html(message);
                }

            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

    // Add user
    $("#list_movies").submit(function (e) {
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(), // serializes the form's elements.
            success: function (data)
            {
//                var message = data.message.replace(/\n/g, "<br/>");
//                if (data.type == 'success') {
//                    $('.flash-success').removeClass('hidden').show();
//                    $('.flash-error').hide();
//                    $('.flash-success .message').html(message);
//                    console.log($(this));
//                    console.log($(this).find("input[type=text]"));
//                    form.find("input").val("");
//                } 
                if (data.type == 'error') {
                    $('.flash-success').hide();
                    $('.flash-error').removeClass('hidden').show();
                    $('.flash-error .message').html(message);
                }

            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.

    });
    
    $("#delete_movie").submit(function (e) {
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(), // serializes the form's elements.
            success: function (data)
            {
//                var message = data.message.replace(/\n/g, "<br/>");
//                if (data.type == 'success') {
//                    $('.flash-success').removeClass('hidden').show();
//                    $('.flash-error').hide();
//                    $('.flash-success .message').html(message);
//                    console.log($(this));
//                    console.log($(this).find("input[type=text]"));
//                    form.find("input").val("");
//                } 
                if (data.type == 'error') {
                    $('.flash-success').hide();
                    $('.flash-error').removeClass('hidden').show();
                    $('.flash-error .message').html(message);
                }

            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
});