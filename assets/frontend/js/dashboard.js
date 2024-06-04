function createTimer(dateTime) {
    // Set the date we're counting down to
    //Format Time : Jan 5, 2021 15:37:25
    var countDownDate = new Date(dateTime).getTime();
    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        var clockData = '';
        if (days > 0) {
            clockData += days + ' Days : ';
        }

        clockData += hours + ' : ' + minutes + ' : ' + seconds;

        $('.match-timer').html(clockData);

        if (distance < 0) {
            clearInterval(x);
            $('.match-timer').addClass('expired');
            var clockData = '00 : 00 : 00';

            $('.match-timer').html(clockData);
        }
    }, 1000);
}

var intervalTimer;

function renderCountdown(setClass, setID) {
    // Logs 
    let days, hours, minutes, seconds; // variables for time units
    let count = 0;
    var getCountdown = function (c) {
        if (setClass == 'true') {
            var timeStart = $('#match-row-info-' + setID + ' input[name=timeStart]').val();
            var dateTime = $('#match-row-info-' + setID + ' input[name=matchTimeEnd]').val();
        } else {
            var timeStart = $('input[name=timeStart]').val();
            var dateTime = $('input[name=matchTimeEnd]').val();
        }
    
        var dateStart = new Date(timeStart);
        var dateEnd = new Date(dateTime);
        let currentDate = dateStart.getTime();
        let targetDate = dateEnd.getTime(); // set the countdown date
        // find the amount of "seconds" between now and target
        let secondsLeft = ((targetDate - currentDate) / 1000) - c;
        days = pad(Math.floor(secondsLeft / 86400));
        secondsLeft %= 86400;
        hours = pad(Math.floor(secondsLeft / 3600));
        secondsLeft %= 3600;
        minutes = pad(Math.floor(secondsLeft / 60));
        seconds = pad(Math.floor(secondsLeft % 60));
        // format countdown string + set tag value
        var clockData = hours + ':' + minutes + ':' + seconds;

        if (setClass == 'true') {
            clockDiv = '#match-row-info-' + setID + ' .match-timer';
            targetDiv = '#match-row-info-' + setID;
        } else {
            clockDiv = '.match-timer';
            targetDiv = '.match-timer-box';
        }

        if (hours <= '00' && minutes <= '00' && seconds <= '00') {
            clockData = '00:00:00';
            var clockDiv;
            var targetDiv;
            if (setClass == 'true') {
                var matchStatus = $('#match-row-info-' + setID + ' input[name=matchStatus]').val();

                if (matchStatus == 3) {
                    if (!$('#match-row-info-' + setID + ' .match-timer').hasClass('pause-clock')) {
                        resetMatchStatus(setID, $('#match-row-info-' + setID + ' input[name=matchStatusUrl]').val());
                    }
                }                
            } else {
                var matchStatus = $('input[name=matchStatus]').val();

                if (matchStatus == 3) {
                    if (!$('.match-timer').hasClass('pause-clock')) {
                        resetMatchStatus('', $('input[name=matchStatusUrl]').val());
                    }
                }
            }
        }

        if ($(targetDiv + ' input[name=matchTimeEnd]').val() == '') {
            clockData = '00:00:00';
        }

        $(clockDiv).html(clockData);
    }

    function pad(n) {
        return (n < 10 ? '0' : '') + n;
    }

    // Clear the previous interval timer before starting a new one
    clearInterval(intervalTimer);

    // Start the interval timer
    intervalTimer = setInterval(function () {
        getCountdown(count++);
    }, 1000);
}

if ($('.match-timer').length > 0) {
    if ($('.multi-match-timer').length > 0) {
        $('.multi-match-timer').each(function () {
            var setID = $(this).children('input[name=matchRowID]').val();
            if($(this).children('input[name=timeStart]').val() != '') {
                renderCountdown('true', setID);
            }
        });
    } else {
        var dateTime = $('input[name=matchTimeEnd]').val();

        if (dateTime != '') {
            renderCountdown('false', '');
        }
    }
}

$(document).on('change', 'select[name=video_type]', function () {
    var value = $('option:selected', this).val();

    var text_video;

    if (value == 'youtube') {
        text_video = 'https://www.youtube.com/watch?v=';
    }

    if (value == 'vimeo') {
        text_video = 'https://vimeo.com/';
    }

    if (value == 'dailymotion') {
        text_video = 'https://www.dailymotion.com/video/';
    }

    $('input[name=video_text]').val(text_video);

    if (value != '') {
        if (value == 'custom') {
            $('.upload_video').fadeIn();
            $('.url_video').hide();
        } else {
            $('.url_video').fadeIn();
            $('.upload_video').hide();
        }
    } else {
        $('.url_video').hide();
        $('.upload_video').hide();
    }
});

$(document).on('click', '.spec-app', function () {
    $('#login-load').fadeIn();

    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            $('#login-load').fadeOut();
            $('#msg-process').fadeIn().html(response.message);

            setTimeout(function () {
                $('#msg-process').fadeOut();
            }, 3000);

            currentRequest.hide();
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('keyup', '.p-update', function () {
    var v_targ = $(this).attr('data-p');

    $('.' + v_targ).fadeIn();
});

$(document).on('click', '.upd-des-c', function () {
    $('.upd-btn').fadeOut();
});

$(document).on('click', '.upd-des', function (e) {
    e.preventDefault();
    var tagline = $('input[name=tagline]').val();

    $('.loader-de').fadeIn().css({
        'display': 'flex'
    });

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            tagline: tagline
        },
        dataType: 'text',
        success: function (response) {
            $('.loader-de').fadeOut();
            $('.upd-btn').fadeOut();
            console.log(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.upd-desc', function (e) {
    e.preventDefault();
    var p_desc = $('textarea[name=p-desc]').val();

    $('.loader-des').fadeIn().css({
        'display': 'flex'
    });

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            p_desc: p_desc
        },
        dataType: 'text',
        success: function (response) {
            console.log(response);
            $('.loader-des').fadeOut();
            $('.update-btn').fadeOut();
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.edit-cp', function () {
    var value_set = $(this).attr('data-value');

    $('input[name=update_value]').val(value_set);
    $('.p-title').text(value_set);

    if (value_set == 'Cover Photo') {
        $('.dimension').text('1150px x 250px');
    } else {
        $('.dimension').text('115px x 115px');
    }

    $('#updateImage').modal('show');
});

$(document).on('click', '.followPlayer', function (e) {
    e.preventDefault();
    var playerID = $(this).attr('data-player');

    $(this).children('span').hide();
    $(this).children('.btn-loader').fadeIn();

    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            playerID: playerID
        },
        dataType: 'json',
        success: function (response) {
            currentRequest.children('.btn-loader').hide();
            currentRequest.children('span').fadeIn();

            $('.playerFollowersCount').text(response.followersCount);
            $('.playerFollowersCount').attr('data-count', response.followersCount);

            currentRequest.children('span').text(response.followerText);
            currentRequest.attr('href', response.updateUrl);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});


$(document).on('click', '.processCheckout', function () {
    var process_check = true;

    $('.form-control').each(function () {
        if ($(this).val() == '') {
            $('.messageBox').html('<div class="message"><i class="fa fa-times-circle"></i> All Fields are required to be filled</div>');
            $(this).addClass('errorField');
            process_check = false;
        }

        if ($(this).attr('type') == 'email') {
            if (!validateEmail($(this).val())) {
                $('.messageBox').html('<div class="message"><i class="fa fa-times-circle"></i> Please provide a valid email</div>');
                $(this).addClass('errorField');
                process_check = false;
            }
        }
    });

    if (process_check == true) {
        $('#login-load').fadeIn();

        var formData = $('.checkout').serialize();

        $.ajax({
            url: $('.checkout').attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $('#login-load').fadeOut();

                $('.messageBox').fadeOut().html();
                $('input[name=cancel_return]').val(response.cancel_url);
                $('input[name=return]').val(response.return_url);
                $('input[name=item_number]').val(response.item_number);
                $('.checkout_paypal').submit();
            },
            error: function (request, status, error) {
                $('#login-load').fadeOut();
            }
        });
    }


    setTimeout(function () {
        $('.messageBox').fadeOut().html();
    }, 3000);
});

if ($('#chat').length > 0) {
    $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
}

$(document).on('click', '.send-chat', function (e) {
    e.preventDefault();
    var message = $('textarea[name=message]').val();
    var receiver_id = $('input[name=receiver_id]').val();

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            message: message,
            receiver_id: receiver_id
        },
        dataType: 'json',
        success: function (response) {
            $('#chat').append(response.chat);
            $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
            console.log(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });

    $('textarea[name=message]').val('');
});
/*
$(document).on('keypress', 'textarea[name=message]', function (e) {
    if (e.which == 13) {
        e.preventDefault();

        var message = $(this).val();
        var receiver_id = $('input[name=receiver_id]').val();

        $.ajax({
            url: $('.send-chat').attr('href'),
            type: 'POST',
            data: {
                message: message,
                receiver_id: receiver_id
            },
            dataType: 'json',
            success: function (response) {
                $('#chat').append(response.chat);
                $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
            },
            error: function (request, status, error) {
                $('#login-load').fadeOut();
            }
        });

        $(this).val('');
    }
});*/

$(document).on('click', '.edit-header', function () {
    $('.edit-form').fadeIn();
    $('.team-name').hide();
});

$(document).on('click', '.btn-cancel', function () {
    $('.edit-form').hide();

    var team_title = $('input[name=team_title]').val();

    if (team_title == 'show') {
        $('.team-name').fadeIn();
    }
});

$(document).on('submit', '.update_header', function () {
    $('#loader').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#loader').fadeOut();

            $('.team-name').text(response.team_name);
            $('.edit-form').hide();

            if (response.team_title == 'show') {
                $('.team-name').fadeIn();
            }

            if (response.team_logo == 'hide') {
                $('.team-logo').hide();
            } else {
                $('.team-logo').fadeIn();
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.add-member', function () {
    var value_set = $(this).attr('data-value');

    $('.players-inner').hide();
    $('.add-players').fadeIn();
});

$(document).on('click', '.empty-invite-field', function (e) {
    e.preventDefault();
    $(this).parent().find('input[name=email]').val('');
    $('.users-list').html('');
    $(this).hide();
    $(this).parent().removeClass('hide-label');
});

$(document).on('keyup', '.search-invite-user', function () {
    $('#invite-player-load').fadeIn();

    if ($(this).val() != '') {
        $.ajax({
            url: $(this).attr('data-location'),
            type: 'POST',
            data: {
                email: $(this).val(),
                user_type: $(this).attr('data-type')
            },
            dataType: 'text',
            success: function (response) {
                $('#invite-player-load').fadeOut();
                $('.users-list').html(response);
                $('.empty-invite-field').fadeIn();
            },
            error: function (request, status, error) {
                $('#login-load').fadeOut();
            }
        });
    } else {
        $('.users-list').html('');
        $('#invite-player-load').fadeOut();
    }
});

$(document).on('click', '.invite-player-btn', function (e) {
    e.preventDefault();
    $('#invite-player-load').fadeIn();
    var currentRequest = $(this);
    var accessUrl = $(this).attr('href');

    if ($('input[name=teamID]').val()) {
        accessUrl += '/' + $('input[name=teamID]').val();
    }

    $.ajax({
        url: accessUrl,
        type: 'POST',
        dataType: 'text',
        success: function (response) {
            $('#invite-player-load').fadeOut();

            currentRequest.text('Invitation Sent');
            currentRequest.removeClass('invite-player-btn');

            setTimeout(function () {
                currentRequest.parent().parent().fadeOut().remove();
            }, 3000);

            if ($('input[name=playersCount]')) {
                $('input[name=playersCount]').val(response);
                var playersCount = $('input[name=playersCount]').val();

                if (playersCount > 0) {
                    $('.text-btn').text('Done Adding Members');
                }
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.btn-cancel-player', function () {
    $('.add-players').hide();
    $('.players-inner').fadeIn();
});

$(document).on('submit', '.processJoin', function () {
    $('#loader').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#loader').fadeOut();

            $('.processJoin').html(response.message);
            $('.rem-credits').text(response.remain_credits);

            setTimeout(function () {
                window.location.href = response.url;
            }, 3000);
        },
        error: function (request, status, error) {
            $('#loader').fadeOut();
            console.log(request);
            console.log(status);
            console.log(error);
        }
    });
});

$(document).on('click', '.get-team-players', function (e) {
    e.preventDefault();
    $('#load-join').fadeIn();

    var currentReq = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'text',
        success: function (response) {
            $('#load-join').fadeOut();

            $('.tour-details').hide();
            $('.processJoin').hide();
            currentReq.hide();

            $('.players-data').html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.btn-select', function (e) {
    e.preventDefault();

    var reqPlayers = Number($('.req-players-join').text());
    var selectedPlayers = Number($('.selected-players-count').text());
    var playerID = $(this).attr('data-id');
    var processSelection = true;

    if ($(this).parent().parent().hasClass('selected-player')) {
        $(this).parent().parent().removeClass('selected-player');
        $(this).children().text('Select');
        $('.member-' + playerID).remove();
    } else {
        if (selectedPlayers < reqPlayers) {
            $(this).parent().parent().addClass('selected-player');
            $(this).children().text('Selected');
            $('<input>').attr({
                type: 'hidden',
                name: 'team_members[]',
                value: playerID,
                class: 'member-' + playerID
            }).appendTo('.team-members');
        } else {
            processSelection = false;
            $('.message').fadeIn().text('You cannot select more then required players');

            setTimeout(function () {
                $('.message').fadeOut().text('');
            }, 5000);
        }
    }

    if (processSelection == true) {
        var count = 0;

        $('.btn-select').each(function () {
            if ($(this).parent().parent().hasClass('selected-player')) {
                count = count + 1;
            }
        });

        $('.selected-players-count').text(count);

        if (count == reqPlayers) {
            $('.confirm-selection').fadeIn();
        } else {
            $('.confirm-selection').hide();
        }
    }
});

$(document).on('click', '.cancel-selection', function (e) {
    e.preventDefault();

    $('.players-data').html('');
    $('.processJoin').fadeIn();
    $('.tour-details').fadeIn();
});

$(document).on('click', '.add-credits-player-btn', function (e) {
    e.preventDefault();

    $(this).children().find('.dso-btn-text').hide();
    $(this).children().find('.btn-loader').fadeIn();

    var playerID = $(this).attr('data-id');
    var currentSelect = $(this);
    var btn_text = $(this).children().find('.dso-btn-text');
    var btn_loader = $(this).children().find('.btn-loader');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            playerID: playerID
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            btn_loader.hide();
            btn_text.fadeIn();

            if (response.status == 1) {
                currentSelect.parent().parent().find('.player-credits').text(response.playerCredits);
                $('.message').fadeIn().text(response.message);

                setTimeout(function () {
                    $('.message').fadeOut().text('');
                }, 5000);

                currentSelect.remove();
            } else {
                $('html, body').animate({
                    scrollTop: $('.players-required').offset().top
                }, 'slow');

                $('.message').fadeIn().text(response.message);

                setTimeout(function () {
                    $('.message').fadeOut().text('');
                }, 5000);
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.kick-player', function (e) {
    e.preventDefault();
    $(this).children('.dso-btn-text').hide();
    $(this).children('.btn-loader').fadeIn();

    var playerID = $(this).attr('data-id');
    var currentSelect = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            playerID: playerID
        },
        dataType: 'json',
        success: function (response) {
            currentSelect.parent().parent().remove();
            console.log(response);

            $('.players-count').html(response.players_count);
            $('.players-progress').width(response.players_progress);
            $('.players-progress').removeClass(response.current_class);
            $('.players-progress').addClass(response.previous_class);
        },
        error: function (request, status, error) {
            console.log(request);
            console.log(status);
            console.log(error);
            $(this).children('.dso-btn-text').fadeIn();
            $(this).children('.btn-loader').hide();

        }
    });
});

$(document).on('click', '.view-players', function (e) {
    e.preventDefault();
    $('#teamParticipents').modal('show');
    $('#players-load').fadeIn();

    var tournamentID = $(this).attr('data-id');
    var teamID = $(this).attr('data-team');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            teamID: teamID,
            tournamentID: tournamentID
        },
        dataType: 'text',
        success: function (response) {
            $('#players-load').fadeOut();

            $('.playersData').html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.ac-notify', function (e) {
    e.stopPropagation();

    if ($('.notification-bar').hasClass('notify-active') == false) {
        $('.notification-bar').addClass('notify-active');
    }
});

$(document).on('click', '.confirm-selection', function (e) {
    e.preventDefault();

    $('#loader').fadeIn();

    var tournamentMembers = $("input[name='team_members[]']")
        .map(function () {
            return $(this).val();
        }).get();
    var tournamentID = $('input[name=tournament_id]').val();

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            tournamentMembers: tournamentMembers,
            tournament_id: tournamentID
        },
        dataType: 'json',
        success: function (response) {
            $('#loader').fadeOut();

            $('.players-data').remove();
            $('.processJoin').fadeIn().html(response.message);
            $('.rem-credits').text(response.remain_credits);

            setTimeout(function () {
                window.location.href = response.url;
            }, 3000);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', function (e) {
    e.stopPropagation();
    $('.notification-bar').removeClass('notify-active');
});

$(document).on('submit', '.create_topic', function () {
    $('.create_topic #loader').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function (response) {
            $('.create_topic #loader').fadeOut();

            $('.disscussion-board').append(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.p-permalink', function (e) {
    e.preventDefault();
    $('#post-load').fadeIn();

    var postID = $(this).attr('data-id');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            postID: postID
        },
        dataType: 'text',
        success: function (response) {
            $('#post-load').fadeOut();
            $('.discuss-form').hide();
            $('.disscussion-board').hide();
            $('.discussion-details').html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('submit', '.post-comment', function () {
    $('.post-comment #loader').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function (response) {
            $('.post-comment #loader').fadeOut();

            if ($('.list-comments .comment').length > 0) {
                $('.list-comments').append(response);
            } else {
                $('.list-comments').html(response);
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.getMatchRound', function (e) {
    e.preventDefault();
    $('.load-tournament').fadeIn();
    $('.load-tournament #login-load').fadeIn();
    $('.matches-table').html('');

    $('.getMatchRound').each(function () {
        $(this).parent().removeClass('active-btn');
    });

    $(this).parent().addClass('active-btn');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'text',
        success: function (response) {
            $('.load-tournament').fadeOut();
            $('.load-tournament #login-load').fadeOut();
            $('.matches-table').html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

function initializeEditor(classSet) {
    $(classSet + ' textarea').each(function () {
        if (!$(this).hasClass('richText-initial')) {
            var clasEditor = $(this).attr('data-target');
            console.log(clasEditor);
            $('.' + clasEditor).richText();
        }
    });
}

function check_fields(formID) {
    var valid = true;
    $(formID + ' .form-control').each(function () {
        if ($(this).val() == '') {
            if ($(this).attr('required')) {
                valid = false;
            }
        }
    });

    return valid;
}

function checkAnimatedLabels() {
    $('.dso-animated-field-label .form-control').each(function () {
        if ($(this, ':input:not([type=hidden])').val() == '') {
            $(this).parent().removeClass('hide-label');
        } else {
            $(this).parent().addClass('hide-label');
        }
    });
}

$(document).on('click', '.process-next', function (e) {
    e.preventDefault();

    $('#login-tournament').fadeIn();

    var target = $(this).attr('data-target');
    var tournamentID = $('input[name=tournamentID]').val();
    var currentProcess = $(this);

    var formID = '.form-step-' + (Number(target) - 1);
    var checkForm = check_fields(formID);

    if (checkForm == true) {
        $.ajax({
            url: $('.create-tournament-form').attr('action'),
            type: 'POST',
            data: {
                target: target,
                tournamentID: tournamentID
            },
            dataType: 'json',
            success: function (response) {
                $('#login-tournament').fadeOut();

                $('.form-process-step').each(function () {
                    $(this).hide();
                });

                if (!$('.btn-prev')[0]) {
                    $('.btn-wrap-prev').html(response.btnData);
                } else {
                    if ($('.btn-prev').attr('data-target') > 0) {
                        $('.btn-prev').fadeIn();
                    }
                    $('.btn-prev').attr('data-target', response.prevStep);
                }

                currentProcess.attr('data-target', response.nextStep);

                if ($('.form-step-' + response.targetStep).length == 0) {
                    $('.form-steps').append(response.dataForm);
                } else {
                    $('.form-step-' + response.targetStep).fadeIn();
                }

                if ($('.form-step-2')[0]) {
                    initializeEditor('.form-step-2');
                }

                $('.step-' + target).addClass('active');

                if (response.final == 1) {
                    $('.dso-btn-row').hide();
                    $('.create-tournament-form').attr('action', response.url);
                }

                $('html, body').animate({
                    scrollTop: $('.form-progress').offset().top
                }, 'slow');

                checkAnimatedLabels();
            }
        });
    } else {
        $('#login-tournament').fadeOut();
        $('.message-box').fadeIn();
        $('.message').text('Please fill out all fields make sure you do not miss out any field');
        $('html, body').animate({
            scrollTop: $('.form-progress').offset().top
        }, 'slow');

        setTimeout(function () {
            $('.message-box').fadeOut();
        }, 4000);
    }
});

$(document).on('click', '.btn-prev', function (e) {
    e.preventDefault();

    $('#login-tournament').fadeIn();

    var step_next = $('.process-next').attr('data-target');
    var step_prev = $(this).attr('data-target');

    var new_next_step = Number(step_prev) + 1;
    var new_prev_step = Number(step_prev) - 1;

    $('.step-' + new_next_step).removeClass('active');
    $('.form-step-' + new_next_step).hide();
    $('.form-step-' + step_prev).fadeIn();

    if (new_prev_step <= 1) {
        $('.btn-prev').hide();
    }

    if (new_prev_step > 0) {
        $('.btn-prev').attr('data-target', new_prev_step);
    }

    $('.process-next').attr('data-target', new_next_step);

    $('html, body').animate({
        scrollTop: $('.form-progress').offset().top
    }, 'slow');
    $('#login-tournament').fadeOut();
});

$(document).on('click', '.add-desc', function () {
    var html = '<div class="input-row m-b-20"><input type="text" name="placement[]" class="form-control" placeholder="Placement" value="" autocomplete="off" />';
    html += '<input type="text" name="prize[]" class="form-control" placeholder="Prize" value="" autocomplete="off" />';
    html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle"></i></a>';
    html += '</div>';

    $('.pkg-desc-row').append(html);
});

$(document).on('click', '.add-stats', function () {
    var html = '<div class="input-row m-b-20"><input type="text" name="stat_title[]" class="form-control" placeholder="Heading" value="" autocomplete="off" />';
    html += '<input type="text" name="stat_value[]" class="form-control" placeholder="Value" value="" autocomplete="off" />';
    html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle"></i></a>';
    html += '</div>';

    $('.stats-row').append(html);
});

$(document).on('click', '.delete-row', function () {
    $(this).parent().remove();
});

$(document).on('submit', '.create-tournament-form', function () {
    $('#login-tournament').fadeIn();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#login-tournament').fadeOut();

            $('.create-tournament-form').hide().html('');
            $('.confirmation-tournament').fadeIn().html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.tournament-set-mode', function () {
    var status;
    var id = $(this).val();

    if ($(this).prop('checked') == true) {
        status = 1;
        $(this).next().addClass('active');
    } else {
        $(this).next().removeClass('active');
        status = 0;
    }

    $.ajax({
        url: site_url + 'account/updateTournamentStatus',
        type: 'POST',
        data: {
            id: id,
            status: status
        },
        dataType: 'text',
    });
});

$(document).on('click', 'input[name=match_type]', function () {
    var id = $(this).val();

    if (id == 1) {
        $('.team-members').fadeIn();
    } else {
        $('.team-members').fadeOut();
    }
});

$(document).on('click', '.add-score', function () {
    $(this).parent().parent().find('h2').hide();
    $(this).hide();
    $(this).parent().find('.setScore').fadeIn();
});

$(document).on('click', '.btn-cancel-score-set', function () {
    $(this).parent().parent().parent().hide();
    $(this).parent().parent().parent().parent().parent().find('h2').fadeIn();
    $(this).parent().parent().parent().parent().find('.add-score').fadeIn();
});

$(document).on('submit', '.setScore', function () {
    $(this).parent().parent().parent().find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent();
    var formData = new FormData(this);
    var form = $(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            loaderTarget.find('#load-match-row').fadeOut();

            form.hide();
            form.parent().parent().find('h2').text(response.playerScore).fadeIn();
            form.children().find('input[name=player_score]').val(response.playerScore);
            form.parent().find('.add-score').fadeIn();

            if(response.scoreUpdate == 1) {
                $('#decisionBtn').html(response.decisionBtnData);
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.btn-set-winner', function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row');
    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            loaderTarget.fadeOut();

            //Remove Set Winner Button            
            $('#match-' + response.matchID + ' #slot-1 .btn-set-winner').remove();
            $('#match-' + response.matchID + ' #slot-2 .btn-set-winner').remove();

            $('#match-row-info-' + response.matchID + ' #match-' + response.matchID).attr('class', '');
            $('#match-row-info-' + response.matchID + ' #match-' + response.matchID).attr('class', response.matchStatusBadge);
            $('#match-row-info-' + response.matchID + ' #match-' + response.matchID).text(response.matchResultMessage);

            $('#match-row-info-' + response.matchID + ' input[name=matchStatus]').val(response.matchStatus);
            $('#match-row-info-' + response.matchID + ' input[name=timeStart]').val(response.timeStart);
            $('#match-row-info-' + response.matchID + ' input[name=matchTimeEnd]').val(response.matchTimeEnd);

            renderCountdown('true', response.matchID);

            $('#match-' + response.matchID + ' #slot-1 label').append(response.player_1_result);
            $('#match-' + response.matchID + ' #slot-2 label').append(response.player_2_result);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.btn-set-ready', function (e) {
    e.preventDefault();

    $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row');
    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            loaderTarget.fadeOut();
            currentRequest.parent().append(response.startMatch);
            currentRequest.remove();

            if(response.matchStatus == 2) {
                $('.match-status #match-' + response.matchID).attr('class', '');
                $('.match-status #match-' + response.matchID).attr('class', response.matchStatusBadge);
                $('.match-status #match-' + response.matchID).text(response.matchResultMessage);

                $('#slot-'+response.slot+'-score').append(response.setScoreForm);  
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.btn-match-complete', function (e) {
    e.preventDefault();
    $('#load-match-row').fadeIn();

    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            $('#load-match-row').fadeOut();

            if(response.result == 1) {
                currentRequest.remove();

                $('#match-' + response.matchID).attr('class', '');
                $('#match-' + response.matchID).attr('class', response.matchStatusBadge);
                $('#match-' + response.matchID).text(response.matchResultMessage);

                $('.match-timer-box input[name=matchStatus]').val(response.matchStatus);
                $('.match-timer-box input[name=timeStart]').val(response.timeStart);
                $('.match-timer-box input[name=matchTimeEnd]').val(response.matchTimeEnd);

                renderCountdown('false', '');
            } else {
                $('#messageBox').fadeIn().html(response.errorMessage);
                setTimeout(function() {
                    $('#messageBox').fadeOut().html('');
                }, 5000);
            }
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});


$(document).on('click', '.btn-start-match', function (e) {
    e.preventDefault();
    $(this).parent().parent().find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().find('#load-match-row');
    var currentRequest = $(this).parent();
    currentRequest.remove();
    
    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            loaderTarget.fadeOut();
            $('#match-' + response.matchID + ' .start-match').remove();
            $('#match-' + response.matchID + ' #slot-1 label').append(response.player1Html);
            $('#match-' + response.matchID + ' #slot-2 label').append(response.player2Html);
            

            if($('#match-' + response.matchID + ' #slot-1-score .setScore-form').length == 0) {
                $('#match-' + response.matchID + ' #slot-1-score').append(response.setScoreSlot1);
            }

            if($('#match-' + response.matchID + ' #slot-2-score .setScore-form').length == 0) {
                $('#match-' + response.matchID + ' #slot-2-score').append(response.setScoreSlot2);
            }

            $('#match-row-info-' + response.matchID + ' .match-status span').attr('class', '');
            $('#match-row-info-' + response.matchID + ' .match-status span').attr('class', response.matchStatusBadge);
            $('#match-row-info-' + response.matchID + ' .match-status span').text(response.matchResultMessage);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.btn-start-player-match', function (e) {
    e.preventDefault();
    $(this).parent().parent().find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().find('#load-match-row');
    var currentRequest = $(this).parent();
    currentRequest.remove();
    
    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            loaderTarget.fadeOut();
            $('.start-match').remove();
            if(response.slot == 1) {
                $('#slot-1 label').append(response.player1Html);
                if($('#slot-1-score .setScore-form').length == 0) {
                    $('#slot-1-score').append(response.setScoreSlot1);
                }
            } else {
                $('#slot-2 label').append(response.player2Html);
                if($('#slot-2-score .setScore-form').length == 0) {
                    $('#slot-2-score').append(response.setScoreSlot2);
                }
            }

            $('.match-status span').attr('class', '');
            $('.match-status span').attr('class', response.matchStatusBadge);
            $('.match-status span').text(response.matchResultMessage);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});


$(document).on('click', '.chat-now', function (e) {
    e.preventDefault();

    $('.chat-wrapper').addClass('activate-chat');
    $('.close-chat').addClass('jump-in');
});

$(document).on('click', '.close-chat', function (e) {
    e.preventDefault();

    $('.chat-wrapper').removeClass('activate-chat');
    $(this).removeClass('jump-in');
});

$(document).on('click', '.eliminate-player-btn', function (e) {
    e.preventDefault();
    $(this).find('span').fadeOut();
    $(this).find('.btn-loader').fadeIn();

    var currentSelect = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        dataType: 'text',
        success: function (response) {
            currentSelect.parent().append(response);
            currentSelect.parent().parent().parent().find('.status-messg').html(response);
            currentSelect.remove();
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.select-btn-thumb', function (e) {
    e.preventDefault();

    var dataValue = $(this).attr('data-value');
    var dataType = $(this).attr('data-type');
    var dataTarget = $(this).attr('data-target');

    if (dataType == 'checkbox') {
        $(this).toggleClass('selected-thumb');

        var selectedValue = 0;

        if ($(this).hasClass('selected-thumb') == true) {
            selectedValue = 1;
        }

        $('input[name=' + dataTarget + ']').val(selectedValue);
    } else {
        $('.thumb-btn').each(function () {
            if ($(this).find('a').attr('data-target') == dataTarget) {
                $(this).find('a').removeClass('selected-thumb');
            }
        });

        $(this).addClass('selected-thumb');

        $('input[name=' + dataTarget + ']').val(dataValue);

        if(dataTarget == 'type') {
            if(dataValue == 4) {
                $('.advanceStage').fadeIn();
            } else {
                $('.advanceStage').hide();
            }
        }
    }
});

$(document).on('submit', '.updatePlayerAssign', function () {
    $(this).parent().parent().parent().find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent();
    var formData = new FormData(this);
    var form = $(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            loaderTarget.find('#load-match-row').fadeOut();

            $('#' + response.currentPlayerMatchId + ' #matchRow_' + response.currentPlayerID).html(response.replacedPlayerData);
            $('#' + response.currentPlayerMatchId + ' #matchRow_' + response.currentPlayerID).attr('id', 'matchRow_' + response.replacePlayerID);

            $('#' + response.currentPlayerMatchId + ' #match_select_' + response.currentPlayerID).html(response.replacedPlayerDropdown);
            $('#' + response.currentPlayerMatchId + ' #match_select_' + response.currentPlayerID).attr('id', 'match_select_' + response.replacePlayerID);

            loaderTarget.find('#curPlayer-' + response.currentPlayerID).val(response.replacePlayerID);
            loaderTarget.find('#curPlayer-' + response.currentPlayerID).attr('id', 'curPlayer-' + response.replacePlayerID);

            //Rearranged Player Data
            $('#' + response.replacedPlayerMatchId + ' #matchRow_' + response.replacePlayerID).html(response.currentPlayerData);
            $('#' + response.replacedPlayerMatchId + ' #matchRow_' + response.replacePlayerID).attr('id', response.currentPlayerID);

            $('#' + response.replacedPlayerMatchId + ' #match_select_' + response.replacePlayerID).html(response.currentPlayerDropdown);
            $('#' + response.replacedPlayerMatchId + ' #match_select_' + response.replacePlayerID).attr('id', response.currentPlayerID);

            $('#' + response.replacedPlayerMatchId + ' #curPlayer-' + response.replacePlayerID).val(response.currentPlayerID);
            $('#' + response.replacedPlayerMatchId + ' #curPlayer-' + response.replacePlayerID).attr('id', 'curPlayer-' + response.currentPlayerID);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.remove-player', function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent();
    var tournamentID = $(this).attr('id');
    var placement = $(this).attr('placement');
    var playerID = $(this).attr('player');
    var round = $('input[name=round]').val();

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            tournamentID: tournamentID,
            player: placement,
            currentPlayer: playerID,
            round: round
        },
        dataType: 'json',
        success: function (response) {
            loaderTarget.find('#load-match-row').fadeOut();

            $('#' + response.currentPlayerMatchId + ' #matchRow_' + response.currentPlayerID).html(response.replacedPlayerData);
            $('#' + response.currentPlayerMatchId + ' #matchRow_' + response.currentPlayerID).attr('id', 'matchRow_' + response.replacePlayerID);

            $('#' + response.currentPlayerMatchId + ' #match_select_' + response.currentPlayerID).attr('id', 'match_select_' + response.replacePlayerID);

            loaderTarget.find('#curPlayer-' + response.currentPlayerID).val(response.replacePlayerID);
            loaderTarget.find('#curPlayer-' + response.currentPlayerID).attr('id', 'curPlayer-' + response.replacePlayerID);

            $('select[name=player_ID]').each(function () {
                $(this).html(response.replacedPlayerDropdown);
            });
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.spectator-request', function (e) {
    e.preventDefault();
    $(this).children('.dso-btn-text').hide();
    $(this).children('.btn-loader').fadeIn();

    var appID = $(this).attr('data-id');
    var status = $(this).attr('data-status');
    var currentSelect = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            appID: appID,
            status: status
        },
        dataType: 'json',
        success: function (response) {
            $('.spec-counter').html(response.counter);
            $('.spec-progress').removeClass(response.oldClass);
            $('.spec-progress').addClass(response.addClass);
            $('.spec-progress').css({
                'width': response.per
            });

            if (status == 3) {
                currentSelect.parent().parent().parent().remove();
            } else {
                if (response.status == 1) {
                    currentSelect.parent().parent().children('.player-btn-row').html(response.htmlData);
                } else {
                    currentSelect.parent().html(response.htmlData);
                }
            }
        },
        error: function (request, status, error) {
            console.log(request);
            console.log(status);
            console.log(error);
            $(this).children('.dso-btn-text').fadeIn();
            $(this).children('.btn-loader').hide();

        }
    });
});


$(document).on('click', '.play-video', function (e) {
    e.preventDefault();
    $('#video-player').modal('show');
    $('.load-video').fadeIn();

    var videoID = $(this).attr('data-id');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            videoID: videoID
        },
        dataType: 'json',
        success: function (response) {
            $('.load-video').hide();
            $('.video-player').html(response.video_url);
            $('.video-title').html(response.title);
        },
        error: function (request, status, error) {
            console.log(request);
            console.log(status);
            console.log(error);
            $(this).children('.dso-btn-text').fadeIn();
            $(this).children('.btn-loader').hide();

        }
    });
});

$(document).on('submit', '.create-team-form', function () {
    $('#create-team-loader').fadeIn();

    var formTarget = $(this);
    var formData = new FormData(this);
    var form = $(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'text',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#create-team-loader').fadeOut();
            formTarget.hide();
            $('.team-members').html(response);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('click', '.add-spectator', function () {
    var value_set = $(this).attr('data-value');

    $(this).hide();
    $('.current-spectators').hide();
    $('.btn-cancel-spectator').fadeIn();
    $('.add-spectators').fadeIn();
});

$(document).on('click', '.btn-cancel-spectator', function () {
    $(this).hide();
    $('.add-spectators').hide();
    $('.current-spectators').fadeIn();
    $('.add-spectator').fadeIn();
});

$(document).on('click', '.invite-spectator-btn', function (e) {
    e.preventDefault();
    $('#invite-player-load').fadeIn();
    var currentRequest = $(this);
    var accessUrl = $(this).attr('href');

    var tournamentID = $('input[name=tournamentID]').val();

    $.ajax({
        url: accessUrl,
        type: 'POST',
        data: {
            tournamentID: tournamentID
        },
        dataType: 'json',
        success: function (response) {
            $('#invite-player-load').fadeOut();

            currentRequest.text('Invitation Sent');
            currentRequest.removeClass('invite-spectator-btn');
            $('.current-spectators').append(response.spectator_html);

            $('.spec-counter').html(response.spectatorsCounter);
            $('.spec-progress').removeClass(response.spectator_oldClass);
            $('.spec-progress').addClass(response.spectator_addClass);
            $('.spec-progress').css({
                'width': response.spectator_per
            });

            setTimeout(function () {
                currentRequest.parent().parent().fadeOut().remove();
            }, 3000);
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', 'input[name=spectatorRole]', function () {
    var roleSet;
    var id = $(this).val();

    if ($(this).prop('checked') == true) {
        roleSet = 1;

        $('input[name=spectatorRole]').each(function () {
            $(this).prop('checked', false);
        });

        $(this).prop('checked', true);
    } else {
        roleSet = 0;
    }

    $.ajax({
        url: $(this).attr('data-url'),
        type: 'POST',
        data: {
            id: id,
            roleSet: roleSet
        },
        dataType: 'text',
        success: function (response) {
            console.log(response);
        }
    });
});

$("#sort-1, #sort-2").sortable({
    connectWith: "#sort-1, #sort-2",
}).disableSelection();

function resetMatchStatus(matchID, matchUrl) {
    if(matchID == '') {
        $('#load-match-row').fadeIn();
    }

    $.ajax({
        url: matchUrl,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if(matchID == '') {
                $('#load-match-row').fadeOut();
            }

            if(response.status == 1) {
                $('.match-player label').each(function () {
                    $(this).children('.btn-row').remove();
                });

                if(matchID == '') {
                    $('input[name=matchStatus]').val(response.matchStatus);
                    $('#messageBox').html('<div class="message">Please Wait While you be redirected to your next round</div>');
                    
                    setTimeout(function () {
                        window.location.reload();
                    }, 10000);
                } else {
                    $('#match-' + response.matchID).removeClass('badge-info');
                    $('#match-' + response.matchID).addClass(response.matchStatusBadge);
                    $('#match-' + response.matchID).html(response.matchResultMessage);    
                    $('#match-row-info-' + response.matchID + ' input[name=matchStatus]').val(response.matchStatus);           
                }
            }
        }
    });
}

$(document).on('click', '.btn-set-decission', function (e) {
    e.preventDefault();

    $('#load-match-row').fadeIn();
    var slot = $(this).attr('data-slot');
    var currentRequest = $(this);

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            slot: slot
        },
        dataType: 'json',
        success: function (response) {
            $('#load-match-row').fadeOut();

            if (response.checkStatus == 1) {
                $('#match-' + response.matchID).removeClass('badge-info');
                $('#match-' + response.matchID).addClass(response.matchStatusBadge);

                $('#match-' + response.matchID).html(response.matchResultMessage);

                $('input[name=matchStatus]').val(response.matchStatus);

                setTimeout(function () {
                    window.location.reload();
                }, 10000);
            }

            if (response.checkStatus == 0) {
                currentRequest.parent().parent().append(response.playerMessage);
            }

            $('#messageBox').html(response.message);

            $('.match-player label').each(function () {
                $(this).children('.btn-row').remove();
            });
        }
    });
});

$(document).on('click', '.btn-set-decline', function (e) {
    e.preventDefault();

    var urlSet = $(this).attr('href');
    var slot = $(this).attr('data-slot');

    $('.dispute-form').addClass('activeDisputeForm');
    $('.close-dispute-form').addClass('jump-in');

    $('.match-timer').addClass('pause-clock');

    $('.dispute-form form').attr('action', urlSet);
    $('input[name=slot]').val(slot);
});

$(document).on('click', '.close-dispute-form', function (e) {
    e.preventDefault();

    $('.dispute-form').removeClass('activeDisputeForm');
    $('.close-dispute-form').removeClass('jump-in');
    $('.match-timer').removeClass('pause-clock');
});

$(document).on('submit', '.process-dispute-request', function () {
    $('#load-dispute-form').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#load-dispute-form').fadeOut();

            $('.dispute-form').removeClass('activeDisputeForm');
            $('.close-dispute-form').removeClass('jump-in');

            $('input[name=timeStart]').val('');
            $('input[name=matchTimeEnd]').val('');

            $('.match-timer').text('00:00:00');

            $('#match-' + response.matchID).removeClass('badge-info');
            $('#match-' + response.matchID).addClass(response.matchStatusBadge);

            $('#match-' + response.matchID).html(response.matchResultMessage);

            $('input[name=matchStatus]').val(response.matchStatus);

            $('#messageBox').html(response.message);

            var playerSlotMessage = $('#match-' + response.matchID + ' #slot-' + response.playerSlot + ' .player-' + response.playerID + ' .start-match');

            if (playerSlotMessage.length > 0) {
                playerSlotMessage.remove();
            }

            $('#match-' + response.matchID + ' #slot-' + response.playerSlot + ' .player-' + response.playerID).append(response.playerMessage);

            $('.match-player label').each(function () {
                $(this).children('.btn-row').remove();
            });
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

$(document).on('click', '.btn-view-dispute', function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row').fadeIn();

    var loaderTarget = $(this).parent().parent().parent().children('.mid-vs').find('#load-match-row');
    var currentRequest = $(this);

    var slot = $(this).attr('data-slot');

    $.ajax({
        url: $(this).attr('href'),
        type: 'POST',
        data: {
            slot: slot
        },
        dataType: 'json',
        success: function (response) {
            loaderTarget.fadeOut();

            $('.dispute-form').addClass('activeDisputeForm');
            $('.close-dispute-form').addClass('jump-in');

            $('.match-details').html(response.playerResults);

            $('.dispute-description').text(response.description);
            $('.dispute-screeshot img').attr('src', response.imageUrl);

            $('input[name=slot]').val(slot);
            $('input[name=matchID]').val(response.matchID);
            $('input[name=playerID]').val(response.playerID);
        }, error: function (request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
});

$(document).on('submit', '.process-dispute-response', function () {
    $('#load-dispute-form').fadeIn();

    var formData = new FormData(this);
    var form = this;

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (response) {
            $('#load-dispute-form').fadeOut();

            $('.dispute-form').removeClass('activeDisputeForm');
            $('.close-dispute-form').removeClass('jump-in');

            $('#match-' + response.matchID).removeClass('badge-danger');
            $('#match-' + response.matchID).addClass(response.matchStatusBadge);

            $('#match-' + response.matchID).html(response.matchResultMessage);

            $('#match-row-info-' + response.matchID + ' .match-timer-box input[name=timeStart]').val('');
            $('#match-row-info-' + response.matchID + ' .match-timer-box input[name=matchTimeEnd]').val('');

            $('#match-row-info-' + response.matchID + ' .match-timer-box .match-timer').text('00:00:00').hide();

            $('#match-row-info-' + response.matchID + ' input[name=matchStatus]').val(response.matchStatus);

            $('#messageBox' + response.matchID).html(response.message);

            $('#match-' + response.matchID + ' .player-' + response.player_1_ID + ' .badge').remove();
            $('#match-' + response.matchID + ' .player-' + response.player_2_ID + ' .badge').remove();

            $('#match-' + response.matchID + ' .player-' + response.player_1_ID).append(response.player_1_result);
            $('#match-' + response.matchID + ' .player-' + response.player_2_ID).append(response.player_2_result);

            $('#match-' + response.matchID + ' #slot-1-score h2').html(response.player_1_score);
            $('#match-' + response.matchID + ' #slot-2-score h2').html(response.player_2_score);

            $('#match-' + response.matchID + ' .match-player').each(function () {
                $(this).children('label').children('.btn-view-dispute').remove();
            });
        },
        error: function (request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

function updateMatchStatus() {
    var matchID = $('input[name="matchID"]').val();
    var matchStatus = $('input[name="matchStatus"]').val();
    var player_1_score = $.trim($('#slot-1-score h2').text());
    var player_2_score = $.trim($('#slot-2-score h2').text());
    var player_1_status = $('#slot-1').attr('data-player-status');
    var player_2_status = $('#slot-2').attr('data-player-status');
    var player_1_dec = $('#slot-1').attr('data-player-dec');
    var player_2_dec = $('#slot-2').attr('data-player-dec');
    
    $.ajax({
        url: '/account/getMatchUpdate',
        type: 'POST',
        data: {
            matchID: matchID,
            matchStatus: matchStatus,
            player_1_score: player_1_score,
            player_2_score: player_2_score,
            player_1_dec: player_1_dec,
            player_2_dec: player_2_dec,
            player_1_status: player_1_status,
            player_2_status: player_2_status
        },
        dataType: 'json',
        success: function (response) {
            if (response.updateResult == 1) {
                if(response.matchType == 1) {
                    if(response.matchStatusBadge) {
                        $('.match-status span').attr('class', '');
                        $('.match-status span').attr('class', response.matchStatusBadge);
                        $('.match-status span').html(response.matchResultMessage);
                    }

                    if(response.player_1_decision) {
                        $('#slot-1 label.player-'+response.player_1_ID+' .start-match').remove();
                        $('#slot-1 label.player-'+response.player_1_ID).append(response.player_1_decision);
                    }

                    if(response.player_2_decision) {
                        $('#slot-2 label.player-'+response.player_2_ID+' .start-match').remove();
                        $('#slot-2 label.player-'+response.player_2_ID).append(response.player_2_decision);
                    }

                    $('input[name=matchStatus]').val(response.matchStatus);

                    $('#slot-1').attr('data-player-status', response.player_1_status);
                    $('#slot-2').attr('data-player-status', response.player_2_status);
                    $('#slot-1').attr('data-player-dec', response.player_1_desc);
                    $('#slot-2').attr('data-player-dec', response.player_2_desc);
                    
                    if(response.matchStatus == 2) {
                        if($('#slot-'+response.slot+'-score .setScore-form').length == 0) { 
                            $('#slot-'+response.slot+'-score').append(response.setScoreForm);
                        }
                    }

                    if(response.matchStatus == 3) {
                        $('input[name=timeStart]').val(response.timeStart);
                        $('input[name=matchTimeEnd]').val(response.matchTimeEnd);

                        if($('#slot-1 label.player-'+response.player_1_ID + ' label.badge').length == 0) {
                            $('#slot-1 label.player-'+response.player_1_ID ).append(response.slot1Data);
                        }

                        if($('#slot-2 label.player-'+response.player_2_ID + ' label.badge').length == 0) {
                            $('#slot-2 label.player-'+response.player_2_ID).append(response.slot2Data);
                        }

                        $('#decisionBtn').remove();

                        renderCountdown('false', '');
                    }

                    if(response.matchStatus == 5) {
                        if($('#slot-1 label.player-'+response.player_1_ID + ' label.badge').length == 0) {
                            $('#slot-1 label.player-'+response.player_1_ID ).append(response.slot1Data);
                        }

                        if($('#slot-2 label.player-'+response.player_2_ID + ' label.badge').length == 0) {
                            $('#slot-2 label.player-'+response.player_2_ID).append(response.slot2Data);
                        }

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                }

                if(response.matchType == 2) {
                    $('.btn-action span').attr('class', '');
                    $('.btn-action span').attr('class', response.matchStatusBadge);
                    $('.btn-action span').html(response.matchResultMessage);

                    $('.status-messg span').attr('class', '');
                    $('.status-messg span').attr('class', response.playerStatusBadge);
                    $('.status-messg span').html(response.playerResultMessage);
                }
            }

            if (response.scoreUpdate == 1) {
                $('#slot-1-score h2').text(response.slot_1_score);
                $('#slot-2-score h2').text(response.slot_2_score);

                if(response.matchSubmit == 1) {
                    if ($('#decisionBtn').children().length === 0) {
                        $('#decisionBtn').html(response.decisionBtnData);
                    }
                }
            }
        },
        error: function (request, status, error) {
            console.log(request + ' | ' + status + ' | ' + error);
        }
    });
}

if ($('.match-log').length > 0) {
    setInterval(function() {
        updateMatchStatus();
    }, 3000);
}


if($('.manage-matches').length > 0) {
    function managerMatchUpdate(matchID) {
        var matchStatus = $('#match-row-info-' + matchID + ' input[name="matchStatus"]').val();
        var player_1_score = $.trim($('#match-' + matchID + ' #slot-1-score h2').text());
        var player_2_score = $.trim($('#match-' + matchID + ' #slot-2-score h2').text());
        var player_1_status = $('#match-' + matchID + ' #slot-1').attr('data-player-status');
        var player_2_status = $('#match-' + matchID + ' #slot-2').attr('data-player-status');
        var player_1_dec = $('#match-' + matchID + ' #slot-1').attr('data-player-dec');
        var player_2_dec = $('#match-' + matchID + ' #slot-2').attr('data-player-dec');
        
        $.ajax({
            url: '/account/getManagerMatchUpdate',
            type: 'POST',
            data: {
                matchID: matchID,
                matchStatus: matchStatus,
                player_1_score: player_1_score,
                player_2_score: player_2_score,
                player_1_dec: player_1_dec,
                player_2_dec: player_2_dec,
                player_1_status: player_1_status,
                player_2_status: player_2_status
            },
            dataType: 'json',
            success: function (response) {
                if (response.updateResult == 1) {
                    //Confirm if record is already updated     
                    if(response.matchStatusBadge != '') {
                        //Get current Data After Ajax process
                        if($('#match-row-info-' + matchID + ' .match-status span').attr('class') != response.matchStatusBadge) {
                            $('#match-row-info-' + matchID + ' .match-status span').attr('class', '');
                            $('#match-row-info-' + matchID + ' .match-status span').attr('class', response.matchStatusBadge);
                            $('#match-row-info-' + matchID + ' .match-status span').html(response.matchResultMessage);
                        }
                    }

                    if(response.player_1_decision != '') {
                        $('#match-' + matchID + ' #slot-1 label .start-match').remove();
                    }

                    if(response.player_2_decision != '') {
                        $('#match-' + matchID + ' #slot-2 label .start-match').remove();
                    }

                    if(response.matchStatus == 2) {
                        $('#match-' + matchID + ' .btn-set-winner').each(function() {
                            $(this).remove();
                        });

                        if($('#match-' + response.matchID + ' #slot-1-score .setScore-form').length == 0) {
                            $('#match-' + response.matchID + ' #slot-1-score').append(response.setScoreSlot1);
                        }
            
                        if($('#match-' + response.matchID + ' #slot-2-score .setScore-form').length == 0) {
                            $('#match-' + response.matchID + ' #slot-2-score').append(response.setScoreSlot2);
                        }
                    }

                    if(response.matchStatus == 4 || response.matchStatus == 5) {
                        $('#match-' + matchID + ' #slot-1 .btn-set-winner').remove();
                        $('#match-' + matchID + ' #slot-2 .btn-set-winner').remove();

                        $('#match-row-info-' + matchID + ' input[name=timeStart]').val('');
                        $('#match-row-info-' + matchID + ' input[name=matchTimeEnd]').val('');
                    }

                    if(response.matchStatus == 3) {
                        if($('#match-' + matchID + ' #slot-1 label.badge').length == 0) {
                            $('#match-' + matchID + ' #slot-1 label').append(response.slot1Data);
                        }

                        if($('#match-' + matchID + ' #slot-2 label.badge').length == 0) {
                            $('#match-' + matchID + ' #slot-2 label').append(response.slot2Data);
                        }
                    }

                    if(response.matchStatus == 5) {
                        if($('#match-' + matchID + ' #slot-1 label.badge').length == 0) {
                            $('#match-' + matchID + ' #slot-1 label.badge').remove();
                            $('#match-' + matchID + ' #slot-1 label').append(response.slot1Data);
                        }

                        if($('#match-' + matchID + ' #slot-2 label.badge').length == 0) {
                            $('#match-' + matchID + ' #slot-2 label.badge').remove();
                            $('#match-' + matchID + ' #slot-2 label').append(response.slot2Data);
                        }
                    }

                    if(response.player_1_desc == 1) {
                        $('#match-' + matchID + ' #slot-1 .btn-set-winner').remove();
                    }

                    if(response.player_2_desc == 1) {
                        $('#match-' + matchID + ' #slot-2 .btn-set-winner').remove();
                    }
                    
                    if(response.player_1_decision != '') {
                        $('#match-' + matchID + ' #slot-1 .player-' + response.player_1_ID).append(response.player_1_decision);
                    }

                    if(response.player_2_decision != '') {
                        $('#match-' + matchID + ' #slot-2 .player-' + response.player_2_ID).append(response.player_2_decision);
                    }

                    if(response.matchStartRequest != '') {
                        $('#match-' + matchID + ' .mid-vs').append(response.matchStartRequest);
                    }

                    $('#match-row-info-' + matchID + ' input[name=matchStatus]').val(response.matchStatus);

                    $('#match-' + matchID + ' #slot-1').attr('data-player-status', response.player_1_status);
                    $('#match-' + matchID + ' #slot-2').attr('data-player-status', response.player_2_status);
                    $('#match-' + matchID + ' #slot-1').attr('data-player-dec', response.player_1_desc);
                    $('#match-' + matchID + ' #slot-2').attr('data-player-dec', response.player_2_desc);
                    
                    if(response.matchStatus == 3) {
                        if(response.timeStart != '') {
                            $('#match-row-info-' + matchID + ' input[name=timeStart]').val(response.timeStart);
                            $('#match-row-info-' + matchID + ' input[name=matchTimeEnd]').val(response.matchTimeEnd);
                        }
                    }
                }

                if (response.scoreUpdate == 1) {
                    $('#match-' + matchID + ' #slot-1-score h2').text(response.slot_1_score);
                    $('#match-' + matchID + ' #slot-2-score h2').text(response.slot_2_score);
                }
            },
            error: function (request, status, error) {
                console.log(request + ' | ' + status + ' | ' + error);
            }
        });
    }

    setInterval(function() {
        $('.match-timer-box').each(function() {
            var matchID = $(this).children('input[name=matchRowID]').val();
            managerMatchUpdate(matchID);
        });
    }, 1000);
}

$(document).on('focus', '#search_contacts', function() {
    $(this).parent().parent().parent().addClass('active-search');
});

$(document).on('click', '.close-search-contact', function() {
    $('.chat-sidebar').removeClass('active-search');
    $('.contact-search-results').html('');
});

$(document).on('keyup', '#search_contacts', function() {
    $('.load-search-results').fadeIn();

    if($(this).val() != '') {
        var search = $(this).val(); 
        $.ajax({
            url  : $(this).parent().attr('action'),
            type : 'POST',
            data : {search : search},
            dataType: 'text',
            success: function( response ) {
                $('.load-search-results').fadeOut();
                $('.contact-search-results').html(response);
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
            }
        });
    } else {
        $('.contact-search-results').html('');
        $('.load-search-results').fadeOut();
    }
});

function activatePopup() {
    $('.zoom-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function(item) {
                return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }
        
    });
}

if($('.individual-match-chat').length > 0) {
    $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
}

$(document).on('submit', '.sendMessage', function(e) {
    e.preventDefault();

    var myform = $('.sendMessage')[0];
    var formData = new FormData(myform);

    $.ajax({
        url: $(this).attr('action'),
        type : 'POST',
        data : formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function( response ) {
             var scrollPosition = false;

            if (($('#chat')[0].scrollHeight - $('#chat').scrollTop()).toFixed() == $('#chat').outerHeight()) {
                scrollPosition = true;
            } 

            $('#chat').append(response.message);

            // if(scrollPosition == true) {
                $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
            //     $('.jump-bottom').fadeOut();
            // } else {
            //     $('.jump-bottom').fadeIn();
            // }

            $('input[name=chatCount]').val(response.chatCount);
            $('.sendMessage input[name="messageFiles[]"]').remove();

            activatePopup();

            $('.post-project-comment').html('');
            $('#basic_message').html('');
        },
        error : function(request, status, error) {
            $('#login-load').fadeOut();
        }
    });

    $('textarea[name=message]').val('');
});

$(document).on('keypress', 'textarea[name=message]', function(e) {
    if(e.which == 13) {
        e.preventDefault();

        var myform = $('.sendMessage')[0];
        var formData = new FormData(myform);

        $.ajax({
            url  : $('.sendMessage').attr('action'),
            type : 'POST',
            data : formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function( response ) {
                var scrollPosition = false;

                if (($('#chat')[0].scrollHeight - $('#chat').scrollTop()).toFixed() == $('#chat').outerHeight()) {
                    scrollPosition = true;
                } 

                $('#chat').append(response.message);

                // if(scrollPosition == true) {
                    $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
                //     $('.jump-bottom').fadeOut();
                // } else {
                //     $('.jump-bottom').fadeIn();
                // }

                $('input[name=chatCount]').val(response.chatCount);
                $('.sendMessage input[name="messageFiles[]"]').remove();
                activatePopup();

                $('.post-project-comment').html('');
                $('#basic_message').html('');
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
            }
        });

        $(this).val('');
    }
});

$(document).on('click', '.jump-bottom', function() {
    $('#chat').animate({ 
        scrollTop: $('#chat')[0].scrollHeight 
    }, 1000);
    $('.jump-bottom').fadeOut();
});

$(document).on('click', '.btn-match-chat', function(e) {
    e.preventDefault();

    $('#chat').html('');
    $('#load-chat-wrapper').fadeIn();
    $('.chat-wrapper').addClass('activate-chat');
    $('.close-chat').addClass('jump-in');

    $('html, body').animate({
        scrollTop: $('.overflow-inherit').offset().top - 20
    }, 'slow');

    var playerSlot = $(this).attr('data-player');
    var matchID    = $(this).attr('data-match-id'); 

    $.ajax({
        url  : $(this).attr('href'),
        type : 'POST',
        data : {playerSlot : playerSlot, matchID : matchID},
        dataType: 'json',
        success: function( response ) {
            $('#load-chat-wrapper').fadeOut();
            $('#chat').html(response.message);
            $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
            
            $('input[name=chatCount]').val(response.chatCount);
            $('input[name=thread]').val(response.chatID);
        },
        error : function(request, status, error) {
            $('#login-load').fadeOut();
        }
    });
});

function updatePlayerMatchChat(chatID, chatCount) {
    var chatUrlSet = $('input[name=chatMainUrl]').val();

    $.ajaxSetup({ cache: false });
    
    $.ajax({
        url      : chatUrlSet + '/' + chatID + '/' + chatCount,
        type     : 'GET',
        dataType : 'json',
        success  : function( response ) {
            if(response.status == 1) {
                var scrollPosition = false;

                if (($('#chat')[0].scrollHeight - $('#chat').scrollTop()).toFixed() == $('#chat').outerHeight()) {
                    scrollPosition = true;
                } 

                $('#chat').append(response.message);

                // if(scrollPosition == true) {
                    $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
                //     $('.jump-bottom').fadeOut();
                // } else {
                //     $('.jump-bottom').fadeIn();
                // }

                $('input[name=chatCount]').val(response.chatCount);

                activatePopup();
            }               
        },
        error : function(request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
}

if($('.individual-match-chat').length > 0) {    
    setInterval(function() {
        var chatID    = $('input[name=thread]').val();
        var chatCount = $('input[name=chatCount]').val();

        if(chatID > 0) {
            updatePlayerMatchChat(chatID, chatCount);
        }
    }, 1000);
}

function updatePLayersCount() {
    var playersCount = $('.players-count').attr('data-players');
    var tournamentID = $('input[name=tournamentID]').val();

    $.ajaxSetup({ cache: false });
    
    $.ajax({
        url      : '/account/playersCountUpdate',
        type     : 'POST',
        dataType : 'json',
        data     : {playersCount : playersCount, tournamentID : tournamentID},
        success  : function( response ) {
            if(response.status == 1) {
                $('.players-count').attr('data-players', response.playersCount);
                $('.players-count').html(response.playersCountData);
                $('.players-progress').removeClass(response.playerClassOld);
                $('.players-progress').addClass(response.playerClassNew);
                $('.players-progress').css({'width' : response.playerPercentage});
                $('.team-participants').append(response.playerTeamBox);
            }               
        },
        error : function(request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
}


if($('.players-count').length > 0) {  
    setInterval(function() {
        updatePLayersCount();
    }, 5000);
}

function htmlEncode(input){
    return encodeURI(input);
}

function isHTML(content) {
    var htmlRegex = /<[^>]*>/;
    return htmlRegex.test(content);
}

function htmlDecode(html, decode=true) {
    if (decode) {
        var decoded = he.decode(html);
        if(isHTML(decoded)){
            if(isHTML(html)){
                return htmlEncode(html);
            }else{
                return html;
            }
        }else{
            return decoded;
        }
    }else{
        return html;
    }
}

// Convert text links to hyperlinks in chat
function linkParse(inputText) {
    var replacedText, replacePattern1, replacePattern2, replacePattern3, replacePattern4, replacePattern5;

    //URLs starting with http://, https://, or ftp://
    replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank"><span class="chat-link"><i class="fa fa-link"></i> $1</span></a>');

    //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
    replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank"><span class="chat-link"><i class="fa fa-link"></i> $2</span></a>');

    //Change email addresses to mailto:: links.
    replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
    replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1"><span class="chat-link"><i class="fa fa-link"></i> $1</span></a>');

    //Match @ mentions - @Kimali Fernando-659 /@(\w+( \w+)*)-(\d*)/gim
    replacePattern4 = /@(\W*\w+( \W*\w+)*)-(\d*)/gim
    replacedText = replacedText.replace(replacePattern4, '<span class="mention" data-user="$3">@$1</span>');

    // Match # Hash - #gotabaya /#[a-zA-Z0-9_]/gim
    if ( inputText.indexOf('&#x') === -1 ) {
        replacePattern5 = /(#[^`~!@$%^&*\#()\-+=\\|\/\.,<>?\'\":;{}\[\]* ]+)/gim
        replacedText = (replacedText).replace(replacePattern5, '<span class="hashtag">$1</span>');
    }

    return replacedText;
}

// make youtube links as clickable and popup the video player
function youtube_parser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = url.match(regExp);
    return (match && match[7].length == 11) ? match[7] : false;
}

// check user is typing
function refreshTypingStatus() {
    if ($('#message_content').data("emojioneArea").getText().length == 0 || new Date().getTime() - lastTypedTime.getTime() > SETTINGS.typingDelayMilliSe) {
        is_typing = 0;
    } else {
        is_typing = 1;
    }
}

function createMessage(message_data, chatID, friendID, type = 1, chatFiles = ''){   
    $('#message_content').val(null);
    $('.emojionearea-editor').empty();
    var urlSet = $('.send-message').attr('action');

    $.ajax({
        url: urlSet,
        type: "POST",
        dataType: 'json',
        data: {
            chatID: chatID,
            friendID: friendID,
            message_data: message_data,
            chatFiles : chatFiles,
            type : type
        },
        success: function(response) {
            $('#chat').append(response.message);
            $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;

            $('.user-contact').each(function() {
                if($(this).attr('data-contact-id') == response.contactId) {
                    $(this).remove();
                }
            });

            $('.chatContacts').prepend(response.chatContact);

            $('input[name=chatCount]').val(response.chatCount);

            activatePopup();
        }
    });
}

var emo_dir = 'ltr';

$("#message_content").emojioneArea({
    pickerPosition: "top",
    tonesStyle: "radio",
    inline: false,
    tones: false,
    search: false,
    saveEmojisAs: "shortname",
    hidePickerOnBlur: true,
    attributes:{
        dir: emo_dir,
    },
    events: {
        keyup: function (editor, e) {
            if (e.keyCode === 13 && !e.shiftKey) {          
                //Code Goes Here
            }
          },
        keypress: function (editor, event) {
            if (event.keyCode  == 13) {
               var content = htmlEncode(this.getText());
               if(event.shiftKey){
                   event.stopPropagation();
               } else {
                    event.preventDefault();
                    
                    var chatID  = $('input[name=thread]').val();
                    var friendID  = $('input[name=receiver_id]').val();
                    var chatFiles;

                    if($('input[name="fileID[]"]').length > 0) {
                        chatFiles = [];

                        $('input[name^="fileID"]').each(function() {
                            chatFiles.push(this.value);
                            $(this).remove();
                        });

                        $('.image-uploader').removeClass('active-uploader');
                        $('#basic_message').html('');
                    }
                    
                    createMessage(content, chatID, friendID, 1, chatFiles);
                    
                    event.preventDefault();
               }
            }
        },
        click: function (editor, event) {
            if ($(window).width() < 425) {
               $( ".buttons-showhide" ).trigger( "click" );
            }
        },
        blur: function (editor, event) {
            // refreshTypingStatus();
            if ($(window).width() < 425) {
               $( ".buttons-showhide" ).trigger( "click" );
            }
        },
        ready: function (editor, event) {
            // if ($('#active_user').val() != "") {
            //     var load_chat_user = $('#active_user').val();
            // }else{
            //     var load_chat_user = active_user;
            // }
            // if(view_chat){
            //     var chat_id = view_chat;
            //     if(view_chat_with){
            //         var load_chat_user = view_chat_with;
            //     }
                
            //     chat_search_mode = true;
            // }else{
            //     var chat_id = false;
            // }
            // loadChats(load_chat_user, active_group, active_room, chat_id);
            // if(isMobile==false){
            //     this.setFocus();
            // }
        }
    }
});

$(document).on('click', '.message-images', function() {
    $('.image-uploader').addClass('active-uploader');
});

$(document).on('click', '.close-message-images', function() {
    $('.image-uploader').removeClass('active-uploader');
});

var tenor_api_key   = 'AIzaSyACVaHzpqsAm-_TUJWnobJ_xJGFbgjYOBg';
var tenor_gif_limit = "18";

function get_gifs(tenor_api_key, tenor_gif_limit, q) {
    $('.gif-list').empty();
    
    if (q != "") {
        var api_url = `https://tenor.googleapis.com/v2/search?q=`+q+`&key=` + tenor_api_key + `&client_key=my_test_app&limit=` + tenor_gif_limit;
    } else {
        var api_url = `https://tenor.googleapis.com/v2/featured?key=` + tenor_api_key + `&limit=` + tenor_gif_limit;
    }
    
    $.ajax({
      url: api_url,
      success: function(data) {
          $.each(data.results, function(k, v) {
              var gif_url = v.media_formats['tinygif']['url'];
              var gif_li = `<div class="send-gif col-xs-6 col-md-2 send-gif " data-gif="` + gif_url + `"><img class="lazy gif-preview" src="` + gif_url + `"></div>`;
              $(gif_li).appendTo($('.gif-list'));
          });
      },complete: function(){
            //Codes Goes hERE
      }
    });
}

$(document).on('click', '.message-gif', function(e) {
    $('.gse-row').removeClass('stickers-shown').removeClass('emojis-shown').empty();
    if($('.gse-row.gifs-shown').is(':visible')) {
        $('.gse-row.gifs-shown').removeClass('gifs-shown').hide();
        $('.gif-list').empty();
    }else{
        var results = get_gifs(tenor_api_key, tenor_gif_limit, "");
        $('.gse-row').addClass('gifs-shown').show().html($('.gif-content').html());
    }

});

$(document).on('click', '.gif-close', function(e) {
    $('.gse-row.gifs-shown').removeClass('gifs-shown').hide();
    $('.gif-list').empty();
});

// gif search functions
    $(document).on('click', '.gif-search-btn', function(e) {
        var q = $('.gif-search-input').val();
        get_gifs(tenor_api_key, tenor_gif_limit, q);
    });

    $(document).on('keyup', '.gif-search-input', function(e) {
        var q = $('.gif-search-input').val();
        if (q.length > 2) {
            get_gifs(tenor_api_key, tenor_gif_limit, q);
        }else if(q.length == 0){
            get_gifs(tenor_api_key, tenor_gif_limit, "");
        }
    });

    // gif send functions
    $(document).on('click', '.send-gif', function(e) {
        e.preventDefault();
        $('.gse-row.gifs-shown').removeClass('gifs-shown').hide();
        $('.gif-list').empty();
        var gif_url = $(this).data('gif');
        
        var chatID  = $('input[name=thread]').val();
        var friendID  = $('input[name=receiver_id]').val();

        createMessage(gif_url, chatID, friendID, 3);
    });

// get sticker functions
function get_strickers(){
    $.ajax({
        url: "/account/getStrickers",
        type: "POST",
        dataType: 'json',
        beforeSend: function() {
            // loading(".strickers","show");
        },
        success: function(data) {
            if (Object.keys(data.stickers).length > 0) {
                var sticker_set_count = 1;
                $.each(data.stickers, function( index, obj ) {
                    if(sticker_set_count == 1){
                        var act_class = 'active';
                        var act_class_content = 'active show';
                    }else{
                        var act_class = '';
                        var act_class_content = '';
                    }
                    var tab_html =
                    `<li class="nav-item">
                      <a class="nav-link `+act_class+`" id="pills-tab-`+sticker_set_count+`" data-toggle="pill" href="#sticker-pills-`+sticker_set_count+`" role="tab" >`+index+`</a>
                    </li>`;
                    $('.sticker-nav').append(tab_html);
                    var sticker_list = '';
                    $.each(obj, function( index, sticker ) {
                        var sticker_url = sticker;
                        var sticker_html = `<div class="send-sticker" data-sticker="`+sticker+`"><img src="`+sticker_url+`" /></div>`;
                        sticker_list += (sticker_html);
                    });
                    var tab_content_html =
                    `<div class="tab-pane fade  `+act_class_content+`" id="sticker-pills-`+sticker_set_count+`" role="tabpanel" >
                        `+ sticker_list +`
                    </div>`
                    $('.sticker-tab-content').append(tab_content_html);
                    sticker_set_count++;
                });
            }else{
                $('.sticker-tab-content').append('<p class="text-center">No Stickers Found</p>');
            }
        },complete: function(){
            // loading(".strickers","hide");
        }

    });
}

$(document).on('click', '.message-sticker', function(e) {
    $('.gse-row').removeClass('gifs-shown').removeClass('emojis-shown').empty();
    $('.sticker-nav').empty();
    $('.sticker-tab-content').empty();
    if ($('.gse-row.stickers-shown').is(':visible')) {
        $('.gse-row.stickers-shown').removeClass('stickers-shown').hide();
    } else {
        get_strickers();
        $('.gse-row').addClass('stickers-shown').show().html($('.sticker-content').html());
    }

});

$(document).on('click', '.sticker-close', function(e) {
    $('.gse-row.stickers-shown').removeClass('stickers-shown').hide();
    $('.sticker-nav').empty();
    $('.sticker-tab-content').empty();
});

// stickers send functions
$(document).on('click', '.send-sticker', function(e) {
    $('.gse-row.stickers-shown').removeClass('stickers-shown').hide();
    $('.sticker-nav').empty();
    $('.sticker-tab-content').empty();
    var sticker_url = $(this).data('sticker');

    var chatID  = $('input[name=thread]').val();
    var friendID  = $('input[name=receiver_id]').val();

    createMessage(sticker_url, chatID, friendID, 4);
});

$(document).on('click', '.btn-send', function(e) {
    var content_el = $('#message_content').data("emojioneArea");
    var content = htmlEncode(content_el.getText());
    var chatID  = $('input[name=thread]').val();
    var friendID  = $('input[name=receiver_id]').val();
    var chatFiles;

    if($('input[name="fileID[]"]').length > 0) {
        chatFiles = [];

        $('input[name^="fileID"]').each(function() {
            chatFiles.push(this.value);
            $(this).remove();
        });

        $('.image-uploader').removeClass('active-uploader');
        $('#basic_message').html('');
    }

    e.preventDefault();
 
    createMessage(content, chatID, friendID, 1, chatFiles);
    content_el.editor.focus();

});

activatePopup();

function updateChat(chatID, chatCount) {
    $.ajaxSetup({ cache: false });
    
    $.ajax({
        url      : '/account/updateMessages/' + chatID + '/' + chatCount,
        type     : 'GET',
        dataType : 'json',
        success  : function( response ) {
            if(response.status == 1) {
                var scrollPosition = false;

                if (($('#chat')[0].scrollHeight - $('#chat').scrollTop()).toFixed() == $('#chat').outerHeight()) {
                    scrollPosition = true;
                } 

                $('#chat').append(response.message);

                // if(scrollPosition == true) {
                    $('#chat')[0].scrollTop = $('#chat')[0].scrollHeight;
                //     $('.jump-bottom').fadeOut();
                // } else {
                //     $('.jump-bottom').fadeIn();
                // }

                // $('.chat-sidebar ul li').each(function() {
                //     if($(this).hasClass('chat-active')) {
                //         $(this).children('notify-contact-bubble').remove();
                //     }
                // });

                $('input[name=chatCount]').val(response.chatCount);

                activatePopup();
            }               
        },
        error : function(request, status, error) {
            $('#login-load').fadeOut();
            console.log(request.responseText);
        }
    });
}

function loadMessageNotifications() {
    $.ajaxSetup({ cache: false });

    var currrentCount = $('.user-chat-url').attr('data-count');
    
    $.ajax({
        url      : '/account/loadMessageNotifications/' + currrentCount,
        type     : 'GET',
        dataType : 'json',
        success  : function( response ) {
            if(response.status == 1) {
                if($('.user-chat-url').children('notify-contact-bubble').length == 0) {
                    $('.user-chat-url').append(response.dataNotification);
                } else {
                    $('.bubbleCount').text(response.notification);
                }
            }           
        },
        error : function(request, status, error) {
            console.log(request);
            console.log(status);
            console.log(error);;
        }
    });
}

function updateContacts(chatID) {
    $.ajaxSetup({ cache: false });
    
    $.ajax({
        url      : '/account/updateContacts/' + chatID,
        type     : 'GET',
        dataType : 'json',
        success  : function( response ) {
            if(response.contactIds.length > 0) {
                var chatContactIDset = [];

                $('.user-contact').each(function() {
                    if($.inArray($(this).attr('data-contact-id'), response.contactIds) === 0) {
                        var chatCount = $(this).attr('data-chat-count');

                        if(response.chatCount[$(this).attr('data-contact-id')] > chatCount) {
                            chatContactIDset.push($(this).attr('data-contact-id'));
                            $(this).remove();
                        }
                    }
                });

                if(chatContactIDset.length > 0) {
                    $.each(chatContactIDset, function(index, obj) {
                        $('.chatContacts').prepend(response.chatContacts[obj]);
                    });
                }
            }           
        },
        error : function(request, status, error) {
            console.log(request);
            console.log(status);
            console.log(error);
        }
    });
}

if($('#search_contacts').length > 0) {    
    setInterval(function() {
        var chatID    = $('input[name=thread]').val();
        var chatCount = $('input[name=chatCount]').val();

        if(chatID > 0) {
            updateChat(chatID, chatCount);
        }

        updateContacts(chatID);
    }, 1000);
} else {
    setInterval(function() {
        loadMessageNotifications();
    }, 1000);
}
