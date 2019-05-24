$(document).ready(function(){
    var i = 0;
    var j = 0;
    var limit = 20;
    $('.post').each(function(){
        i++;
        if(i>limit){
            $(this).hide();
        }
    });

    $('.show-posts').on('click', function(){
        limit +=20;
        $('.post').each(function(){
            j++;
            if(j>limit){
                $(this).hide();
            }else{
                $(this).show();
            }
        })
        j=0;
    })
});

// COMMENT WITH AJAX
$('.btn-comment').on("click", function (e) {
    var post_id = $(this).data('id');
    var element = $(this);
    var text = element.closest('li.post').find('.comment-text').val();
    var user = $('.username').text();

    $.ajax({
        method: "POST",
        url: "./ajax/ajax_comment.php",
        data: { text: text, user: user, post_id: post_id }
    })
    .done(function( res ) {
        if (res.status == "success") {
            var comment = `<li class="comment-li" >
                            <strong> ${res.user} </strong>
                            <p> ${res.text} </p>
                          </li>`;

            element.closest('li.post').find(".comment-ul").prepend(comment);
            element.closest('li.post').find(".comment-li").first().slideDown();
            $('.comment-text').val("");

        }

    });
    e.preventDefault();
});

//$('.flag-p').hide();

$('.flag-btn').on("click", function (e) {
    var post_id = $(this).data('id');
    var element = $(this);
    var flagcount = parseInt(element.closest('li.post').find(".flag-count").text());

    //element.closest('li.post').find('.flag-p').show();

    $.ajax({
        method: "POST",
        url: "./ajax/ajax_flag.php",
        data: { post_id: post_id }
    })
        .done(function( res ) {
            if (res.status == "flagged") {
                var newValue = flagcount + 1;
                element.closest('li.post').find(".flag-count").text(newValue);

                if (newValue > 2) {
                    element.closest('li.post').hide();
                }
                
                if (newValue == 1) {
                    element.closest('li.post').find('span').hide();
                }

            } else {

            }
            });

    e.preventDefault();
});

$('.like-post').on("click", function (e) {
    var p_u = $(this).data('id').split("|");
    var post_id = p_u[0];
    var user_id = p_u[1];

    var element = $(this);
    var classs = element.attr('class');
    
    switch (classs) {
        case "like-post unlike":
            $.ajax({
                method: "POST",
                url: "./ajax/ajax_unlike.php",
                data: { user_id: user_id, post_id: post_id }
            })
                .done(function( res ) {
                    if (res.status == "unliked") {
                        element.removeClass('unlike');
                        element.addClass('like');
                        element.css('background-image:', 'url(\'../images/love.svg\')');
                    } else {
                        alert("derp");
                    }
                });
            break;

        case "like-post like":
            $.ajax({
                method: "POST",
                url: "./ajax/ajax_like.php",
                data: { user_id: user_id, post_id: post_id }
            })
                .done(function( res ) {
                    if (res.status == "liked") {
                        element.removeClass('like');
                        element.addClass('unlike');
                        element.css('background-image:', 'url(\'../images/loved.svg\')');
                    } else {
                        alert("oops");
                    }
                });
            break;
    }

    e.preventDefault();
});

//update posts set flag = 0