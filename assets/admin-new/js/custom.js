"use strict";
(function () {

	// ______________LOADER
	$("#global-loader").fadeOut("slow");


	// ______________Full screen
	$(document).on("click", ".fullscreen-button", function toggleFullScreen() {
		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
			if (document.documentElement.requestFullScreen) {
				document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
				document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
			} else if (document.documentElement.msRequestFullscreen) {
				document.documentElement.msRequestFullscreen();
			}
		} else {
			$('html').removeClass('fullscreen-button');
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
	})

	// ______________Cover Image
	$(".cover-image").each(function () {
		var attr = $(this).attr('data-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});

	// ______________Toast
	var toastElList = [].slice.call(document.querySelectorAll('.toast'))
	var toastList = toastElList.map(function (toastEl) {
		return new bootstrap.Toast(toastEl)
	})


	// ______________ BACK TO TOP BUTTON
	$(window).on("scroll", function (e) {
		if ($(this).scrollTop() > 130) {
			$('#back-to-top').removeClass('animate-reverse');
			$('#back-to-top').addClass('animate');
			$('#back-to-top').fadeIn('slow');
		} else {
			$('#back-to-top').removeClass('animate');
			$('#back-to-top').addClass('animate-reverse');
			$('#back-to-top').fadeOut('slow');
		}
	});

	// ______________ PROGRESS BAR ON SCROLL
	window.addEventListener('scroll', () => {
		var widnowScroll = document.body.scrollTop || document.documentElement.scrollTop,
			height = document.documentElement.scrollHeight - document.documentElement.clientHeight,
			scrollAmount = (widnowScroll / height) * 100;
		document.querySelector(".progress-top-bar").style.width = scrollAmount + "%";
	})

	/* Headerfixed */
	$(window).on("scroll", function (e) {
		if ($(window).scrollTop() >= 66) {
			$('main-header').addClass('fixed-header');
		}
		else {
			$('.main-header').removeClass('fixed-header');
		}
	});

	// ______________Search
	$('body, .main-header form[role="search"] button[type="reset"]').on('click keyup', function (event) {
		if (event.which == 27 && $('.main-header form[role="search"]').hasClass('active') ||
			$(event.currentTarget).attr('type') == 'reset') {
			closeSearch();
		}
	});
	function closeSearch() {
		var $form = $(' form[role="search"].active')
		$form.find('input').val('');
		$form.removeClass('active');
		$('body').removeClass('search-open');
	}
	// Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
	$(document).on('click', ' form[role="search"]:not(.active) button[type="submit"]', function (event) {
		event.preventDefault();
		var $form = $(this).closest('form'),
			$input = $form.find('input');
		$form.addClass('active');
		$input.focus();
		$('body').addClass('search-open');
	});
	// if your form is ajax remember to call `closeSearch()` to close the search container
	$(document).on('click', ' form[role="search"].active button[type="submit"]', function (event) {
		event.preventDefault();
		var $form = $(this).closest('form'),
			$input = $form.find('input');
		$('#showSearchTerm').text($input.val());
		closeSearch()
		$('body').addClass('search-open');
	});

	// if your form is ajax remember to call `closeSearch()` to close the search container
	$(document).on('click', ' form[role="search"].active button[type="reset"]', function (event) {
		event.preventDefault();
		$('body').removeClass('search-open');
		var $form = $(this).closest('form'),
			$input = $form.find('input');
		$('#showSearchTerm').text($input.val());
		closeSearch()
	});

	//  item notes
	$('.thumb').click(function () {
		if (!$(this).hasClass('active')) {
			$(".thumb.active").removeClass("active");
			$(this).addClass("active");
		}
	});
	$('.thumb1').click(function () {
		if (!$(this).hasClass('active')) {
			$(".thumb1.active").removeClass("active");
			$(this).addClass("active");
		}
	});
	$('.thumb2').click(function () {
		if (!$(this).hasClass('active')) {
			$(".thumb2.active").removeClass("active");
			$(this).addClass("active");
		}
	});

	// ______________ Function for remove card in Whislist
	const DIV_CARD1 = '.Wishlist-card';

	$(document).on('click', '[data-bs-toggle="card-remove"]', function (e) {
		console.log('ok');
		let $card2 = $(this).closest(DIV_CARD1);
		$card2.remove();
		e.preventDefault();
		return false;
	});
	// ______________ Function for card
	const DIV_CARD = 'div.card';

	// ______________ Function for remove card
	$(document).on('click', '[data-bs-toggle="card-remove"]', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});
	// ______________ Functions for collapsed card
	$(document).on('click', '[data-bs-toggle="card-collapse"]', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	// ______________ Card full screen
	$(document).on('click', '[data-bs-toggle="card-fullscreen"]', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});
	// open multiple links on click
	$('a#openAllBtn').click(function (e) {
		window.open('calendar.html');
		window.open('contacts.html');
		window.open('file-manager.html');
		window.open('mail-inbox.html');
		window.open('gallery.html');
		window.open('blog.html');
		window.open('shop.html');
		window.open('form-elements.html');
		e.preventDefault();
		return false;
	});
	/* ----------------------------------- */

	// this will hide dropdown menu from open in mobile
	$('.dropdown-menu .main-header-arrow').on('click', function (e) {
		e.preventDefault();
		$(this).closest('.dropdown').removeClass('show');
	});

	// navbar backdrop for mobile only
	$('body').append('<div class="main-navbar-backdrop"></div>');
	$('.main-navbar-backdrop').on('click touchstart', function () {
		$('body').removeClass('main-navbar-show');
	});

	// Close dropdown menu of header menu
	$(document).on('click touchstart', function (e) {
		e.stopPropagation();
		// closing of dropdown menu in header when clicking outside of it
		var dropTarg = $(e.target).closest('.main-header .dropdown').length;
		if (!dropTarg) {
			$('.main-header .dropdown').removeClass('show');
		}
		// closing nav sub menu of header when clicking outside of it
		if (window.matchMedia('(min-width: 992px)').matches) {
			// Navbar
			var navTarg = $(e.target).closest('.main-navbar .nav-item').length;
			if (!navTarg) {
				$('.main-navbar .show').removeClass('show');
			}
			// Header Menu
			var menuTarg = $(e.target).closest('.main-header-menu .nav-item').length;
			if (!menuTarg) {
				$('.main-header-menu .show').removeClass('show');
			}
			if ($(e.target).hasClass('main-menu-sub-mega')) {
				$('.main-header-menu .show').removeClass('show');
			}
		} else {
			//
			if (!$(e.target).closest('#mainMenuShow').length) {
				var hm = $(e.target).closest('.main-header-menu').length;
				if (!hm) {
					$('body').removeClass('main-header-menu-show');
				}
			}
		}
	});
	$('#mainMenuShow').on('click', function (e) {
		e.preventDefault();
		$('body').toggleClass('main-header-menu-show');
	})
	$('.main-header-menu .with-sub').on('click', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass('show');
		$(this).parent().siblings().removeClass('show');
	})
	$('.main-header-menu-header .close').on('click', function (e) {
		e.preventDefault();
		$('body').removeClass('main-header-menu-show');
	})

	$(".card-header-right .card-option .fe fe-chevron-left").on("click", function () {
		var a = $(this);
		if (a.hasClass("icofont-simple-right")) {
			a.parents(".card-option").animate({
				width: "35px",
			})
		} else {
			a.parents(".card-option").animate({
				width: "180px",
			})
		}
		$(this).toggleClass("fe fe-chevron-right").fadeIn("slow")
	});


	// ___________TOOLTIP	
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	// __________POPOVER
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})

	// ______________ SWITCHER-toggle ______________//
	$('.layout-setting').on("click", function (e) {
		let html = document.querySelector('html');
		if (html.getAttribute('data-theme-color') === "dark") {
			html.setAttribute('data-theme-color', 'light');
			html.setAttribute('data-header-color', 'light');
			html.setAttribute('data-menu-color', 'light');
			$('#switchbtn-lightmenu').prop('checked', true);
			$('#switchbtn-lightheader').prop('checked', true);
			checkOptions();
			localStorage.removeItem("zembgColor");
			localStorage.removeItem("zembgwhite");
			localStorage.removeItem("zemheaderbg");
			localStorage.removeItem("zemmenubg");
			let mainHeader = document.querySelector('.main-header');
			mainHeader.style = "";
			let appSidebar = document.querySelector('.app-sidebar');
			appSidebar.style = "";
			document.querySelector('html').style = '';
			names();

		} else {
			html.setAttribute('data-theme-color', 'dark');
			html.setAttribute('data-header-color', 'dark');
			html.setAttribute('data-menu-color', 'dark');
			$('#switchbtn-darkmenu').prop('checked', true);
			$('#switchbtn-darkheader').prop('checked', true);
			checkOptions();
			localStorage.removeItem("zembgColor");
			localStorage.removeItem("zembgwhite");
			localStorage.removeItem("zemheaderbg");
			localStorage.removeItem("zemmenubg");
			let mainHeader = document.querySelector('.main-header');
			mainHeader.style = "";
			let appSidebar = document.querySelector('.app-sidebar');
			appSidebar.style = "";
			document.querySelector('html').style = '';
			names();
		}
	});


})();

document.cookie = "SameSite"

$(function () {
    $(document).on('click', '.edit-category', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('status');
        var image  = $(this).attr('image');
        var desc   = $(this).attr('desc');
        var title  = $(this).attr('title');

        $('input[name=title]').val(title);
        $('input[name=description]').val(desc);
        $('input[name=icon_filename]').val(image);
        $('input[name=status]').val(status);
        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-category">Cancel</button>' );
        $('.cat-submit').text( 'Update Category' );
    });

    $(document).on('click', '.edit-team', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('status');
        var image  = $(this).attr('image');
        var title  = $(this).attr('title');

        $('input[name=title]').val(title);
        $('input[name=icon_filename]').val(image);
        $('input[name=status]').val(status);
        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-team">Cancel</button>' );
        $('.cat-submit').text( 'Update Team' );
    });

    $(document).on('click', '.edit-article-category', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('status');
        var image  = $(this).attr('image');
        var desc   = $(this).attr('desc');
        var title  = $(this).attr('title');

        $('input[name=title]').val(title);
        $('input[name=description]').val(desc);
        $('input[name=icon_filename]').val(image);
        $('input[name=status]').val(status);
        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-category">Cancel</button>' );
        $('.cat-submit').text( 'Update Category' );
    });

    $(document).on('click', '.edit-department', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var title  = $('.row-' + id).text();

        $('input[name=title]').val(title);
        $('select[name=status]').val(status);

        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-department">Cancel</button>' );
        $('.cat-submit').text( 'Update Department' );
    });

    $(document).on('click', '.edit-designation', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var title  = $('.row-' + id).text();

        $('input[name=title]').val(title);
        $('input[name=status]').val(status);

        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-designation">Cancel</button>' );
        $('.cat-submit').text( 'Update Designation' );
    });

    $(document).on('click', '.edit-combo', function() {
        var id     = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        var type   = $(this).attr('type');
        var title  = $('.row-' + id).text();
        var price  = $('.price-' + id).text();
        var category  = $('.category-' + id).attr('data-cid');

        $('input[name=item_name]').val(title);
        $('input[name=item_price]').val(price);
        $('select[name=category]').val(category);
        $('select[name=type]').val(type);
        $('select[name=status]').val(status);
        $('input[name=id]').val(id);

        $('.btn-reset').html( '<button type="reset" class="btn btn-inverse cancel-combo">Cancel</button>' );
        $('.cat-submit').text( 'Update Package' );
    });

    $(document).on('keyup', 'input[name=package_title]', function() {
        var title = $(this).val();

        $('.pkg-box h3').text(title);
    });

    $(document).on('keyup', 'input[name=old_price]', function() {
        var old_price = Number($(this).val());

        $('.pkg-box .old-price').text('$' + old_price.toFixed(2));
    });

    $(document).on('keyup', 'input[name=new_price]', function() {
        var new_price = Number($(this).val());

        $('.pkg-box .cur-price').text('$' + new_price.toFixed(2));
    });

    $(document).on('keyup', '.typeahead.form-control', function() {
        $('.pkg-wrap ul').html('');
        $('.typeahead.form-control').each(function() {
            var desc_list = $(this).val();

            $('.pkg-wrap ul').append( '<li>' + desc_list + '</li>' );
        });
    });

    $(document).on('click', '.cancel-category', function() {
        $('.btn-reset').html( '');
        $('.cat-submit').text( 'Create Category' );
        $('form')[0].reset();
    });
    
    $(document).on('click', '.cancel-team', function() {
        $('.btn-reset').html( '');
        $('.cat-submit').text( 'Create Team' );
        $('form')[0].reset();
    });

    $(document).on('click', '.cancel-department', function() {
        $('.btn-reset').html( '');
        $('.cat-submit').text( 'Create Department' );
        $('form')[0].reset();
    });

    $(document).on('click', '.cancel-combo', function() {
        $('.btn-reset').html( '');
        $('.cat-submit').text( 'Create Combo' );
        $('form')[0].reset();
    }); 

    $(document).on('click', '.cancel-designation', function() {
        $('.btn-reset').html( '');
        $('.cat-submit').text( 'Create Designation' );
        $('form')[0].reset();
    }); 

    $(document).on('click', '.add-desc', function() {
        var html = '<div class="input-row mg-b-20"><input type="text" name="placement[]" class="form-control" placeholder="Placement" value="" autocomplete="off" />';
        html += '<input type="text" name="prize[]" class="form-control" placeholder="Prize" value="" autocomplete="off" />';
        html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>';
        html += '</div>';
        
        $('.pkg-desc-row').append( html );

        typeheadDesc();
    });

    $(document).on('click', '.add-stats', function() {
        var html = '<div class="input-row mg-b-20"><input type="text" name="stat_title[]" class="form-control" placeholder="Heading" value="" autocomplete="off" />';
        html += '<input type="text" name="stat_value[]" class="form-control" placeholder="Value" value="" autocomplete="off" />';
        html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>';
        html += '</div>';
        
        $('.stats-row').append( html );
    });
    
    $(document).on('click', '.add-custom-fields', function() {
        var html = '<div class="input-row mg-b-20"><input type="text" name="meta_key[]" class="form-control" placeholder="Title" value="" autocomplete="off" />';
        html += '<input type="text" name="meta_value[]" class="form-control" placeholder="Description" value="" autocomplete="off" />';
        html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>';
        html += '</div>';
        
        $('.stats-row').append( html );
    });

    $(document).on('click', '.add-vadd', function() {
        var html = '<div class="input-row mg-b-20"><input type="text" name="pkg_vadd[]" class="form-control" value="" />';
        html += '<a class="delete-row close-tag"><i class="fa fa-times-rectangle-o"></i></a>';
        html += '</div>';
        
        $('.pkg-vadd-row').append( html );
    });


    $(document).on('click', '.delete-row', function() {
        $(this).parent().remove();
    });

    function multiSelectInit(target) {
        $(target).multiSelect();
    }

    $(document).on('change', 'select[name=user_type]', function() {
        var user_type = $('option:selected', this).val();

        if(user_type == 2) {
            $('.spectator').fadeIn();
        } else {
            $('.spectator').hide();
        }

        if(user_type == 1 || user_type == 4 || user_type == 5) {
            $('.attendance-details').fadeOut();
        } else {
            $('.attendance-details').fadeIn();
        }
    });

    $(document).on('change', 'select[name=category]', function() {
        var categoryID = $('option:selected', this).val();

        $('#load-box').fadeIn();

        $.ajax({
            url      : site_url + 'admin/getPackages',
            type     : 'POST',
            data     : {categoryID : categoryID},
            dataType : 'text',
            success  : function( response ) {
                $('#load-box').fadeOut();
                
                $('.packages_selection').html( response );
                multiSelectInit('#packages-select');
            }
        });
    });

    $(document).ready(function() {
        if($('input[name=id]').val() != '') {
            $('.emp-submit').prop('disabled', false);
            $('input[name=password]').prop('required', false);
            $('input[name=confirm_password]').prop('required', false);
        }
    });

    $(document).on('keyup', 'input[name=password], input[name=confirm_password]', function() {
        var curCheck = $(this).attr('name');

        if(curCheck == 'confirm_password') {
            var password        = $('input[name=password]').val();
            var confirmPassword = $('input[name=confirm_password]').val();

            if(password == confirmPassword) {
                $('.emp-submit').prop('disabled', false);
                $('.error_pass').text('');
                $('.cpass').css({
                    'background-color' : 'transparent',
                    'border' : 'none',
                    'border-bottom' : '2px solid #ececec'
                });
            } else {
                $('.cpass').css({
                    'background-color' : '#ffcece',
                    'border' : '1px solid #d40000'
                });
                $('.emp-submit').prop('disabled', true);
                $('.error_pass').text('Password Did not matched');
            }
        }
    });    

    $(document).on('click', '.uael-rbs-switch', function() {
        var status;
        var id = $(this).val();

        if($(this).prop('checked') == true) {
            status = 1;
        } else {
            status = 0;
        }

        $.ajax({
            url      : site_url + 'admin/updateTournamentStatus',
            type     : 'POST',
            data     : {id : id, status : status},
            dataType : 'text',
        });   
    });

    $(document).on('submit', '.get-applications', function() {
        $('#spec-load').fadeIn();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type : 'POST',
            data : formData,
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function( response ) {
                $('#spec-load').fadeOut();
                
                $('.app-data').html( response );
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });

    $(document).on('click', '.view-application', function(e) {
        e.preventDefault();
        $('#spec-load').fadeIn();

        $.ajax({
            url: $(this).attr('href'),
            type : 'POST',
            data : {},
            dataType: 'text',
            success: function( response ) {
                $('#spec-load').fadeOut();
                
                $('.app-data').html( response );
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });

    $(document).on('submit', '.updateSpectator', function() {
        $('#spec-load').fadeIn();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type : 'POST',
            data : formData,
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function( response ) {
                $('#spec-load').fadeOut();
                
                $('.app-data').html( response );
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });

    $(document).on('click', '.back-applications', function(e) {
        e.preventDefault();
        var tournamentID = $('input[name=tournamentID]').val();
        $('#spec-load').fadeIn();

        $.ajax({
            url: $(this).attr('href'),
            type : 'POST',
            data : {tournamentID : tournamentID},
            dataType: 'text',
            success: function( response ) {
                $('#spec-load').fadeOut();
                
                $('.app-data').html( response );
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });

    $(document).on('change', '.setWinner', function() {
        $('#spec-load').fadeIn()

        var playerID = $('option:selected', this).val();
        var rowID    = $('option:selected', this).attr('data-id');
        var round    = $('option:selected', this).attr('data-round');
        
        $.ajax({
            url: site_url + 'member/setWinner',
            type : 'POST',
            data : {playerID : playerID, rowID : rowID, round : round},
            dataType: 'text',
            success: function( response ) {
                $('#spec-load').fadeOut();
         
                $('.row-match-'+rowID).html(response);
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });
    
    $(document).on('change', 'select[name=select_tournament]', function() {
        var tournamentID = $('option:selected', this).val();
        var get_action   = $('.tr-form').attr('action');

        $('input[name=tournament_id]').val(tournamentID);

        window.location.href = get_action + '/' + tournamentID;
    });

    $(document).on('keyup', 'input[name=max_players]', function() {
        var playersCount = Number($(this).val());
        var bracket_req  = $('input[name=bracket_req]:checked').val();
        var leftPlayers  = playersCount;
        var valid = false;
        console.log(bracket_req);
        if(bracket_req > 0) {
            if(playersCount > 2) {
                for(let i = 1; i <= Math.log2(playersCount / 2, 2); i ++) {
                    leftPlayers =  leftPlayers / 2;
                    if(leftPlayers % 1 !== 0){
                        valid = true;
                        // return false
                    }
                } 

                if(valid == false) {
                    $('.emp-submit').prop('disabled', false);
                    $(this).removeClass('error-field');
                    $('.err-text').remove();
                } else {
                    if($('.err-text').length == 0) {
                        $(this).addClass('error-field');
                        $(this).after('<span class="err-text">With entered players value the bracket cannot be created please adjust the number of players</span>');
                    }

                    $('.emp-submit').prop('disabled', true);
                }
            } else {
                $(this).addClass('error-field');
                $('.emp-submit').prop('disabled', true);
            }
        } else {
            $(this).removeClass('error-field');
            $('.emp-submit').prop('disabled', false);
        }
    });

    $(document).on('keyup', 'input[name=req_credits]', function() {
        var creditsCount = Number($(this).val());

        if(creditsCount > 300) {
            if($(this).siblings('.err-text').length == 0) {
                $(this).addClass('error-field');
                $(this).after('<span class="err-text">Required credits cannot be less then 1 or greater then 300.</span>');
            }

            $('.emp-submit').prop('disabled', true);
        } else {
            $(this).siblings('.err-text').remove();
            $(this).removeClass('error-field');
            $('.emp-submit').prop('disabled', false);
        }
    });

    $(document).on('click', 'input[name=email_type]', function() {
        var email_type = $(this).val();

        $('.email_type').hide();
        $('.' + email_type).fadeIn();
    });

    $(document).on('click', '.add-field', function() {
        var html  = '<div class="field-row">';
            html += '<input type="text" name="email_user[]" class="form-control" />';
            html += '<a class="remove-field"><i class="icon-close"></i></a>';
            html += '</div>';

        $('.field-wrapper').append(html);
    });

    $(document).on('click', '.remove-field', function() {
        $(this).parent().remove();
    });
    
    $(document).on('click', '.clock-out', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var setTime = $(this).attr('data-type');
        var targetLoc = $(this).parent().children('.timed-box');
        $(this).fadeOut();

        $('#clock-out-load').fadeIn();

        $.ajax({
            url      : url,
            type     : 'POST',
            dataType : 'json',
            success  : function( response ) {
                $('#clock-out-load').fadeOut();

                if(response.status == 1) {
                    targetLoc.fadeIn().html( response.dataHtml );
                    
                    if(setTime == 'time-in') {
                        $('.time-out').fadeIn();
                        $('.time-out').parent().children('.timed-box').hide();
                    } else {
                        $('.time-in').fadeIn();
                        $('.time-in').parent().children('.timed-box').hide();
                    }
                } else {
                    $('.clock-message-box').fadeIn().html( response.dataMessage);

                    setTimeout(function() {
                        $('.clock-message-box').fadeOut().html('');
                    }, 6000);
                }
            }
        });   
    });

    $(document).on('click', '.get-status', function(e) {
        e.preventDefault();
        var current_date = $(this).attr('data-date');
        var user_id      = $('input[name="user_id"]').val();

        $('#report-load').fadeIn();

        $.ajax({
            url      : site_url + 'member/getReport',
            type     : 'POST',
            data     : {current_date : current_date, user_id : user_id},
            dataType : 'json',
            success  : function( response ) {
                $('#report-load').fadeOut();
                $('.report_date').text(response.current_date);
                $('.clock_in').text(response.clock_in);
                $('.clock_out').text(response.clock_out);
            }
        });   
    });

    $(document).on('click', 'input[name=leave_method]', function() {
        if($(this).is(':checked')) {
            $('.leaves_date_req').fadeIn();
        } else {
            $('.leaves_date_req').fadeOut();
        }
    });

    $(document).on('click', 'input[name=date_type]', function() {
        var target = $(this, ':checked').val();

        $('.date-method').hide();
        $('.'+target).fadeIn();
    });

    $(document).on('click', '.add-dates', function() {
        var curCount = Number($('input[name=date_count]').val());
        var newRow   = curCount + 1;

        var htmlData  = '<div class="dates_row dates-inner row-'+newRow+'">';
            htmlData += '<input type="date" name="leaves_date[]" class="form-control" />';
            htmlData += '<a class="removeDate" data-row="'+newRow+'">';
            htmlData += '<i class="mdi mdi-close"></i>';
            htmlData += '</a>';
            htmlData += '</div>';
            
        $('.multi-date-box').append(htmlData);    
        $('input[name=date_count]').val(newRow);
    }); 

    $(document).on('change', 'select[name=emp_data_id]', function(e) {
        e.preventDefault();
        var emp_id = $(this).val();
        var start_date = $('input[name=start_date]').val();
        $('input[name="user_id"]').val(emp_id);

        $('#report-load').fadeIn();

        $.ajax({
            url      : site_url + 'admin/attendance_report',
            type     : 'POST',
            data     : {emp_id : emp_id, start_date : start_date},
            dataType : 'json',
            success  : function( response ) {
                $('#report-load').fadeOut();
                $('.timeArea').html(response.calendarData);
                $('.reportData').html(response.reportData);
                // $('.clock_in').text(response.time_in);
                // $('.clock_out').text(response.time_out);
                // $('.late_counts').text(response.late_counts);
                // $('.days_worked').text(response.days_worked);
            }
        });   
    });

    $(document).on('click', '.getDate', function(e) {
        e.preventDefault();
        var end_date   = $('input[name=end_date]').val();
        var start_date = $('input[name=start_date]').val();
        var userID     = $('select[name=emp_data_id] option:selected').val();
        var dataStep   = $(this).attr('data-get');
 
        $('#report-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {start_date : start_date, end_date : end_date, dataStep : dataStep, user_id : userID},
            dataType : 'json',
            success  : function( response ) {
                $('#report-load').fadeOut();
                $('.date-box').html(response.week_date);
                $('.date-header ul').html(response.week_calendar);
                $('input[name=start_date]').val(response.start_date);
                $('input[name=end_date]').val(response.end_date);

                if(response.week_attendance) {
                    $('.timeArea').html(response.week_attendance);
                    $('.reportData').html(response.week_report);
                }
            }
        });   
    });

    $(document).on('click', '.pay-balance', function(e) {
        e.preventDefault();
        var userID = $(this).attr('data-user');
        
        $('#payment-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {userID : userID},
            dataType : 'text',
            success  : function( response ) {
                $('#payment-load').fadeOut();
                $('.earnings').html(response);

                $('.pay-balance').hide();
            }
        });   
    });

    $(document).on('click', '.view-application', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#report-load').fadeIn();

        $.ajax({
            url      : site_url + 'admin/application_details',
            type     : 'POST',
            data     : {id : id},
            dataType : 'text',
            success  : function( response ) {
                $('#report-load').fadeOut();

                $('.application-details').html(response);
            }
        });   
    });

    $(document).on('change', 'select[name=set_round]', function(e) {
        e.preventDefault();
        var set_round = $(this).val();
        
        $('input[name=round]').val(set_round);
    });

    $(document).on('change', '.player-select', function(e) {
        e.preventDefault();
        $('#match-load').fadeIn();
        
        var player_1     = $(this, 'option:selected').val();
        var player_2     = 0;
        var tournamentID = $('input[name=tournamentID]').val();
        var round        = $('input[name=round]').val();
        var value_player = $(this).attr('name');
        var row          = $(this).parent().parent().parent().children();

        $('select[name=player_1]').prop('disabled', false);
        
        if(value_player == 'player_2') {
            player_2 = player_1;
            player_1 = $('select[name=player_1]').val();
            $(this).parent().remove();
        } else {
            $(this).prop('disabled', true);
        }

        $.ajax({
            url      : $('.create-manual-match').attr('action'),
            type     : 'POST',
            data     : {player_1 : player_1, player_2 : player_2, value_player : value_player, tournamentID : tournamentID, round : round},
            dataType : 'json',
            success  : function( response ) {
                $('#match-load').fadeOut();
                
                if(response.matchResult == 1) {
                    if($('.players-match-table tbody tr td').attr('class') == 'dataTables_empty') {
                        $('.players-match-table tbody').html(response.matchData);
                    } else {
                        if($('.players-match-table tbody .row-match-'+response.matchID).length > 0) {
                            $('.row-match-'+response.matchID).remove();
                        }

                        $('.players-match-table tbody').append(response.matchData);
                    }

                    $('select[name=player_1]').html(response.players);
                } else {
                    row.each(function() {
                        console.log($(this).attr('class'));
                        if($(this).attr('class') == 'col-6 player-2') {
                           $(this).html(response.players); 
                        } 
                    });
                }
            }
        }); 
    });

    $(document).on('click', 'input[name=salary_cycle]', function() {
        var status = $(this, ':checked').val();

        if(status == 'Project Based') {
            $('.salary').hide();
        } else {
            $('.salary').fadeIn();
        }
    })

    $(document).ready(function() {
        var width = 0;
        $('.kanban-block-wrapper').each(function() {
            width += $(this).outerWidth() + 15;
        });

        $('.kanban-inner-wrapper').css({'width' : width});
    });

    $(document).on('click', '.horizon-next', function() {
        var width = 0;
        $('.kanban-inner-wrapper .kanban-block-wrapper').each(function() {
            width += $(this).outerWidth() + 15;
        });

        $('.kanban-body').animate({
            scrollLeft: "+=295px"
        }, "slow");
        
        if($('.kanban-body').scrollLeft() + 295 == 295) {
            $('.horizon-prev').fadeIn(500);
        } 
        
        if($('.kanban-body').scrollLeft() >= 560) {
            $(this).fadeOut(500);
        } 
    });
    
    $(document).on('click', '.horizon-prev', function() {
        $('.kanban-body').animate({
            scrollLeft: "-=280px"
        }, "slow");
 
        if($('.kanban-body').scrollLeft() < 280) {
            $('.horizon-prev').fadeOut(500);
        } 
        console.log($('.kanban-body').scrollLeft());
        if($('.kanban-body').scrollLeft() <= 793) {
            $('.horizon-next').fadeIn(500);
        } 
    });

    if($('#block1').length > 0) {
        $(function() {
            $( "#block1, #block2, #block3, #block4, #block5, #block6" ).sortable({
                connectWith: ".kb-stager",
                opacity: 0.4,
                receive: function(event, ui) {
                    var newStage   = ui.item.parent().attr('data-stage');
                    var newStageID = ui.item.parent().attr('id');
                    var cardID     = ui.item.attr('data-pid');
                    var currentStage = ui.item.attr('data-exe-stage');
                    ui.item.attr('data-exe-stage', newStage);
                    
                    $.ajax({
                        url      : site_url + 'member/updateProjectStage',
                        type     : 'POST',
                        data     : {newStage : newStage, currentStage : currentStage, projectID : cardID},
                        dataType : 'JSON',
                        success  : function( response ) {

                            $('#'+newStageID).find('#kb-'+cardID).find('.kb-progress-box .per').text(response.percentage);

                            $('#'+newStageID).find('#kb-'+cardID).find('.kb-inner-bar').css({
                                'width' : response.percentage+'%',
                            });
                        }
                    });
                }
            }).disableSelection();
        });
    }

    $(document).on('click', '.kanban-details', function(e) {
        var target_url = $(this).attr('url');

        window.location.href = target_url;
    });

    if($('#basic').length > 0) {
        $('#basic').simpleUpload({
            url: site_url + 'member/processProjectFile',
            method: 'post',
            params: { projectID: projectID },
            ajax: {
                headers: { 'X-Test': 'test' },
                statusCode: {
                    200: function(response) {
                        $('.post-project-comment').append(response);
                    }
                }
            },
            dropZone: '#basic_drop_zone',
            progress: 'a#basic_progress'
        }).on('upload:done', function(e, file, i) {
            $('#basic_message').prepend('<p class="file-uploaded"><i class="fa fa-check-circle"></i> ' + file.name + '</p>');
        }).on('upload:fail', function(e, file, i) {
            console.log('fail ' + i);
            console.log(file);
            $('#basic_message').prepend('<p>fail: ' + file.name + '</p>');
        });
    }

    $(document).ready(function() {
        if($('.commenting-bar').length > 0) {
            $('.commenting-bar')[0].scrollTop = $('.commenting-bar')[0].scrollHeight;
        }
    });

    $(document).on('submit', '.post-project-comment', function(e) {
        $('#comment-load').fadeIn();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type : 'POST',
            data : formData,
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function( response ) {
                $('#comment-load').fadeOut();
                $('.post-project-comment')[0].reset();
                $('#basic_message').html('');
                $('.filename').each(function() {
                    $(this).remove();
                });
                $('.commenting-bar').append( response );
                $('.commenting-bar')[0].scrollTop = $('.commenting-bar')[0].scrollHeight;
            },
            error : function(request, status, error) {
                $('#login-load').fadeOut();
                console.log(request.responseText);
            }
        });
    });

    $(document).on('click', '.get-report', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $('#report-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {id : id},
            dataType : 'json',
            success  : function( response ) {
                $('#report-load').fadeOut();

                $('.report-details').fadeIn();
                $('.title').html(response.title);
                $('.thumbnail a').attr('href', response.url);
                $('.thumbnail a img').attr('src', response.url);
                $('.description').html(response.description);
                $('textarea[name=description]').text(response.comment);
                $('select[name=status]').val(response.status);
                $('input[name=id]').val(response.id);
            }
        });   
    });

    $(document).on('click', '.set-new-score', function() {
        $(this).parent().hide();
        $(this).parent().next().addClass('active-score');
    });

    $(document).on('click', '.cancel-score', function() {
        $(this).parent().prev().fadeIn();
        $(this).parent().removeClass('active-score');
    });

    $(document).on('click', '.update-score', function(e) {
        e.preventDefault();
        var batchID = $(this).attr('data-batchID');
        var score   = $(this).prev().val();
        var act_target = $(this);

        $('#row-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {batchID : batchID, score, score},
            dataType : 'text',
            success  : function( response ) {
                $('#row-load').fadeOut();
                act_target.prev().val(response);
                act_target.parent().prev().children('span').text(response);
                act_target.parent().prev().fadeIn();
                act_target.parent().removeClass('active-score');
            }
        });   
    });

    $(document).on('click', '.eliminate-player', function(e) {
        e.preventDefault();
        var batchID = $(this).attr('data-id');
        var act_target = $(this);

        $('#row-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {batchID : batchID},
            dataType : 'text',
            success  : function( response ) {
                $('#row-load').fadeOut();
                act_target.prev().html(response);
                act_target.remove();
            }
        });   
    });

    $(document).on('click', '.edit-time', function(e) {
        e.preventDefault();
        $(this).hide();

        var userID = $(this).attr('data-id');
        var userDate = $(this).attr('data-date');
        var act_target = $(this);

        act_target.parent().find('#time-load').fadeIn();

        $.ajax({
            url      : $(this).attr('href'),
            type     : 'POST',
            data     : {userID : userID, userDate : userDate},
            dataType : 'text',
            success  : function( response ) {
                act_target.parent().find('#time-load').fadeOut();
                act_target.parent().find('.time-box-set').hide();
                act_target.parent().find('.time-calc').hide();
                act_target.parent().find('.timesheet-edit').html(response);
                var totalTime = $.trim($('.totalTime').text());
                $('input[name=weekTime]').val(totalTime);
            }
        });   
    });

    $(document).on('submit', '.setTime', function(e) {
        $('#time-load').fadeIn();

        var formData = new FormData(this);
        var form = $(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type : 'POST',
            data : formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function( response ) {
                $('#time-load').fadeOut();
                
                form.parent().parent().parent().find('.time-box-set').fadeIn().html(response.timeData);
                form.parent().parent().parent().find('.timesheet-edit').hide().html('');
                form.parent().parent().parent().find('.time-calc').fadeIn().html(response.total_time);
                form.parent().parent().parent().find('.edit-time').fadeIn();

                $('.totalTime').html(response.totalWeekTime);
                $('.earnings').html(response.totalSalary);
            }
        });
    });

    $(document).on('click', '.get-valorant-phone', function(e) {
        e.preventDefault();

        var verifyPassword = $('input[name=passwordVerify]').val();
        var id = $(this).attr('data-id');
        var curRow = $(this);
        
        if(verifyPassword == 'false') {
            $('input[name=rowID]').val(id);
            $('#confirmPassword').modal('show');
        } else {
            $(this).hide();
            $('#data-load-'+id).fadeIn();
            
            $.ajax({
                url: $(this).attr('href'),
                type : 'POST',
                data : {id : id},
                dataType: 'text',
                success: function( response ) {
                    curRow.parent().html(response);
                }
            });
        }
    });    

    $(document).on('submit', '.password-confirm', function(e) {
        $('#data-load').fadeIn();

        var formData = new FormData(this);
        var form = $(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type : 'POST',
            data : formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function( response ) {
                $('#data-load').fadeOut();

                if(response.status == 1) {
                    $('#confirmPassword').modal('hide');
                    $('.phoneNumb-'+response.rowID).html(response.phone);
                    $('input[name=passwordVerify]').val('true');
                } else {
                    $('.user-message').fadeIn().html(response.message);

                    setTimeout(function() {
                        $('.user-message').fadeOut().html('');
                    }, 6000);
                }
            }
        });
    });    

    $('#valorantApplication').DataTable({
        "order": ['des']
    });    

    $(document).on('change', 'select[name=field_type]', function() {
        var field_type = $('option:selected', this).val();

        if(field_type != '') {
        	$('.field_data_form').fadeIn();

        	$('.field-info').hide();
        	$('.options').hide();

        	$('.'+field_type).fadeIn();
        } else {
        	$('.field_data_form').fadeOut();
        }
    });

     $(document).on('click', 'input[name=match_type]', function() {
        var id = $(this).val();

        if(id == 1) {
            $('.team-members').fadeIn();
        } else {
            $('.team-members').fadeOut();
        }
    });

    $(document).on('click', '.edit-fields', function() {
        var fieldID = $(this).attr('data-id');
        var fieldType = $(this).parent().parent().children('.field-type').text();
        var fieldLabel = $(this).parent().parent().children('.field-label').text();
        var fieldPlacehodler = $(this).parent().parent().children('.field-placeholder').text();
        var fieldValues = $(this).parent().parent().children('.field-values').text();

        if(fieldValues != 'N/A') {
        	fieldValues = fieldValues.replaceAll('|', '\n');
        }

        $('select[name=field_type]').val(fieldType);
        $('input[name=id]').val(fieldID);
        $('input[name=field_name]').val(fieldLabel);
        $('input[name=placeholder]').val(fieldPlacehodler);
        $('textarea[name=field_values]').text(fieldValues);

        $('.field_data_form').fadeIn();

        $('.field-info').hide();
    	$('.options').hide();

    	$('.'+fieldType).fadeIn();
    });
});