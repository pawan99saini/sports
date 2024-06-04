AOS.init({
    duration: 1200,
    disable: 'mobile'
  });
  
  $(window).on('load', function() {
      setTimeout(function() {
          $('.page-loader').slideUp(1500);
          $('.page-loader').fadeOut('slow');
      }, 3000);
      $('#notice').modal('show');
  });
  
  $(window).scroll(function(){ 
      if($(window).scrollTop() >= 200) {
          $("header").addClass("fixed-header");        
      } else {
          $("header").removeClass("fixed-header");
      }
  });
  
  // $("html").easeScroll();
  
  $(function () {
      $(".select2").select2();
  });
  
  $(document).on('click', '.mobile-menu, .close-menu-btn', function(e) {
      e.preventDefault();
  
      if($('.dso-mobile-menu').hasClass('active-mobile')) {
          $('.dso-mobile-menu').removeClass('active-mobile');
          $('.close-menu-btn').removeClass('jump-in');
      } else {
          $('.dso-mobile-menu').addClass('active-mobile');
          $('.close-menu-btn').addClass('jump-in');
      }
  });
  
  $(document).on('click', '.hamburger-menu-btn', function(e) {
      e.preventDefault();
  
      if($('.burger-menu').hasClass('active-in')) {
          $('.burger-menu').removeClass('active-in');
          $('.close-menu').removeClass('jump-in');
      } else {
          $('.burger-menu').addClass('active-in');
          $('.close-menu').addClass('jump-in');
      }
  });
  
  $(document).on('click', '.close-menu', function(e) {
      e.preventDefault();
  
      if($('.burger-menu').hasClass('active-in')) {
          $('.burger-menu').removeClass('active-in');
          $('.close-menu').removeClass('jump-in');
      } else {
          $('.burger-menu').addClass('active-in');
          $('.close-menu').addClass('jump-in');
      }
  });
  
  $(document).on('click', '.dso-nav-tabs', function(e) {
      e.preventDefault();
      var target = $(this).attr('href');
  
      $('.dso-nav-tabs').each(function() {
          $(this).removeClass('dso-nav-current');
      });
  
      $('.dso-tab-wrapper').each(function() {
          $(this).removeClass('active-nav-tab');
      });
  
      $(this).addClass('dso-nav-current');
      $(target).addClass('active-nav-tab');
  });
  
  $(document).on('click', '.target-tab', function(e) {
      e.preventDefault();
  
      var target = $(this).attr('data-target');
  
      $('.dso-nav-tabs').each(function() {
          $(this).removeClass('dso-nav-current');
      });
  
      $('.dso-tab-wrapper').each(function() {
          $(this).removeClass('active-nav-tab');
      });
  
      $("a[href='"+target+"']").addClass('dso-nav-current');
      $(target).addClass('active-nav-tab');
  
      $('html, body').animate({
          scrollTop: $(target).offset().top - 20
      }, 'slow');
  });
  
  $(document).on('submit', '.signup-home', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
  
              $('#msg-login').html( response.message );
              
              if( response.status == 1 ) {
                  $('.signup-home').hide();
                  $('.signup-password').fadeIn();   
                  $('input[name=userID]').val(response.userID);
                  setTimeout(function() {
                      $('#msg-login').fadeOut();
                  }, 1500);                    
              } 
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  $(document).on('keyup', 'input[name=password], input[name=confirmPassword]', function() {
      var dataClass       = 'cl_process';
      var password        = $('input[name=password]').val();
      var confirmPassword = $('input[name=confirmPassword]').val();
  
      if(typeof confirmPassword !== "undefined" && confirmPassword.length > 1) {
          if(password == confirmPassword) {
              $('.confirm_cl_password').removeClass('error');
              $('.confirm_cl_password').addClass('valid');
              $('.confirm_cl_password').next('span').remove();
              if($('.confirm_cl_password.valid').length > 0) {
                  $('.'+dataClass).prop('disabled', false);
              }
          } else {
              $('.confirm_cl_password').removeClass('valid');
              $('.confirm_cl_password').addClass('error');
  
              if($('.confirm_cl_password').next('span').length == 0) {
                  $('.confirm_cl_password').after('<span class="errClass">Password did not matched</span>');
              }
  
              $('.'+dataClass).prop('disabled', true);
          }
      } else {
          $('.confirm_cl_password').next('span').remove();
      }
  });
  
  $(document).on('submit', '.signup-password', function() {
      $('#password-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#password-load').fadeOut();
              
              $('.signup-password').hide();   
  
              $('#msg-password').html( response.message );
              
              setTimeout(function() {
                  $('#msg-password').fadeOut();
                  $('.signup-home').fadeIn();   
                  window.location.href = response.url;
              }, 1500);
  
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
      var typingTimer;               
      var doneTypingInterval = 1000;  
  
  //on keyup, start the countdown
  $(document).on('keyup', 'input[name=username]',function(e) {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });
  
  //on keydown, clear the countdown 
  $(document).on('keydown', 'input[name=username]',function(e) {
      clearTimeout(typingTimer);
  });
  
  //user is "finished typing," do something
  function doneTyping () {
      var username = $('input[name=username]').val();
      var hasSpace = /\s/g.test(username);
      if(hasSpace == true) {
          $('.username-valid').addClass('error');
          $('.username-valid').removeClass('valid');
          
          if($('.username-valid').next('span').length == 0) {
              $('.username-valid').after('<span class="errClass">Username should not contain any spaces</span>');
          }
  
          $('.register-btn').prop('disabled', true);
      } else {
          $('.username-valid').removeClass('error');
          $('.username-valid').addClass('valid');
          $('.username-valid').next('span').remove();
  
          $.ajax({
              type     : 'POST',
              url      : site_url + 'home/checkUsername', 
              dataType : 'json',
              data     : {
                  'username' : username
              },
              success: function (data) {
                  if(data.status == 1) {
                      $('input[name=username]').removeClass('has-error');
                      $('input[name=username]').next().remove();
                      $('.register-btn').prop('disabled', false);
                  } else {
                      $('input[name=username]').addClass('has-error');
                      $('input[name=username]').after(data.message);
                      $('.register-btn').prop('disabled', true);
                  }
              },error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
              }
          });
      }
  }
  
  
  $(document).on('submit', '.login-home', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
              $('#msg-login').html( response.message );
  
              if( response.status == 1 ) {
                  setTimeout(function() {
                      window.location.href = response.url;
                  }, 1500);                    
              } 
          },
          error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  $(document).on('submit', '.reset-password', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'text',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
              $('#msg-login').html( response );
          },
          error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  $(document).on('submit', ".recover-password", (function(e) {
      $('#login-load').fadeIn();
      var form     = this;
      var formData = new FormData(this);
  
      $.ajax({
          url         : $(this).attr('action'),
          type        : "POST",
          data        : formData,
          dataType    : 'json',
          processData: false,
          contentType: false,
          success     : function(data) {
              $('#login-load').fadeOut();
              $('#msg-login').fadeIn(1000);
              $("#msg-login").html("<div class='message'>"+data.message+"</div>");
              
              setTimeout(function() {
                  $('#msg-login').fadeOut(1000);
              }, 5000);
              form.reset();
          },
          complete: function() {
              $('.loader').fadeOut(1000);
          }
      });
  }));
  
  $(document).on('keydown', 'input[name=email], input[name=password]', function() {
      var value = $.trim($(this).val());
  
      $(this).val(value);
  });
  
  
  
  $('.categories-slider').slick({
      dots: true,
      infinite: true,
      autoplay: true,
      speed: 800,
      slidesToShow: 4,
      slidesToScroll: 1,
      prevArrow: '<button class="slide-arrow prev-arrow"><img src="/assets/frontend/images/left-arrow.png" /></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><img src="/assets/frontend/images/right-arrow.png" /></button>',
      responsive: [
          {
              breakpoint: 1024,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
              }
          }, {
              breakpoint: 600,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
              }
          }
      ]
  });
  
  $('.game-slide').slick({
      dots: false,
      infinite: true,
      autoplay: true,
      speed: 2000,
      slidesToShow: 1,
      slidesToScroll: 1,
      prevArrow: '<button class="slide-arrow prev-arrow"><img src="/assets/frontend/images/left-arrow.png" /></button>',
      nextArrow: '<button class="slide-arrow next-arrow"><img src="/assets/frontend/images/right-arrow.png" /></button>',
      responsive: [
          {
              breakpoint: 1024,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
              }
          }, {
              breakpoint: 600,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1,
              }
          }
      ]
  });
  
  function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
  }
  
  
  
  
  $(document).on('click', '.btn-menu-nav', function() {
      $('.mobile-nav').toggleClass('open-nav');
  });
  
  function mobileOnlySlider() {
      $('.players').slick({
          dots: true,
          infinite: true,
          autoplay: true,
          speed: 800,
          slidesToShow: 1,
          slidesToScroll: 1,
          prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa fa-angle-left"></i></button>',
          nextArrow: '<button class="slide-arrow next-arrow"><i class="fa fa-angle-right"></i></button>',
      });
  }
  
  $(window).resize(function(e){
      if(window.innerWidth < 768) {
          if(!$('.players').hasClass('slick-initialized')){
              mobileOnlySlider();
          }
  
      }else{
          if($('.players').hasClass('slick-initialized')){
              $('.players').slick('unslick');
          }
      }
  });
  
  
  
  $(window).on('load', function() {
      $('#brackets').removeClass('active-nav-tab');
  
      $('#overview').addClass('active-nav-tab');
  
      setTimeout(function() {
          $('.load-tournament').fadeOut();
          $('.load-tournament #login-load').fadeOut();
      }, 4000);
  });
  
  $(document).on('submit', '.apply-valorant', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
      var form = $(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'text',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
              form[0].reset();
              $('#msg-login').html( response );
              $('html, body').animate({
                  scrollTop: $('.top-banner').offset().top - 20
              }, 'slow');
              $('.apply-valorant')[0].reset();
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  $(document).on('click', '.btn-apply', function(e) {
      e.preventDefault();
      
      var id = $(this).attr('data-id');
  
      $('.post-wrapper').hide();
      $('.job-application').fadeIn();
  
      $('input[name=job_id]').val(id);
  });
  
  $(document).on('submit', '.apply-job', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'text',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
  
              $('#msg-login').html( response );
  
              $('.apply-job')[0].reset();
  
              $('.job-application').hide();
              $('.post-wrapper').fadeIn();

              $('html, body').animate({
                  scrollTop: $('.post-wrapper').offset().top - 20
              }, 'slow');
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  $(document).on('click', '.loadMoreGames', function(e) {
      e.preventDefault();
      $('.loadMoreGames').addClass('load-btn');
  
      var offset = $(this).attr('data-offset');
  
      $.ajax({
          url: $(this).attr('href'),
          type : 'POST',
          data : {offset : offset},
          dataType: 'json',
          success: function( response ) {
              $('.loadMoreGames').removeClass('load-btn');
  
              if(response.status == 1) {
                  $('.games-categories').find(' > li:nth-last-child(2)').before( response.data_games );
  
                  if(response.nextPage == true) {
                      $('.loadMoreGames').attr('data-offset', response.offset);
                  } else {
                      $('.loadMoreGames').fadeOut();   
                  }
              } else {
                  $('.loadMoreGames').fadeOut();   
              }
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
          }
      });
  });
  
  $(document).on('submit', '.process-suppport', function() {
      $('#login-load').fadeIn();
  
      var formData = new FormData(this);
  
      $.ajax({
          url: $(this).attr('action'),
          type : 'POST',
          data : formData,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function( response ) {
              $('#login-load').fadeOut();
  
              $('#msg-login').html( response.message );
    
              $('html, body').animate({
                  scrollTop: $('.search-wrap').offset().top - 20
              }, 'slow');
  
              $('.process-suppport')[0].reset();
  
              setTimeout(function() {
                  window.location.href = response.redirect_url
              }, 5000);
  
          }, error : function(request, status, error) {
              $('#login-load').fadeOut();
              console.log(request.responseText);
          }
      });
  });
  
  
  $( function() {
      $(document).on('click', '.empty-search-field', function(e) {
          e.preventDefault();
          $(this).parent().find('input[name=search]').val('');
          $('.search-results').html('');
          $('.search-button button').fadeIn();
          $(this).hide();
          $(this).parent().removeClass('hide-label');
      });
  
      $(document).on('keyup', '#search_user', function() {
          $('.load-search-results').fadeIn();
  
          if($(this).val() != '') {
              var formData = $(this).parent().parent().serialize();
              console.log($(this).parent().attr('action'));
              $.ajax({
                  url  : $(this).parent().parent().attr('action'),
                  type : 'POST',
                  data : formData,
                  dataType: 'text',
                  success: function( response ) {
                      console.log(response);
                      $('.load-search-results').fadeOut();
                      $('.search-results').html(response);
                      $('.search-button button').hide();
                      $('.empty-search-field').fadeIn();
                  },
                  error : function(request, status, error) {
                      $('#login-load').fadeOut();
                  }
              });
          } else {
              $('.search-results').html('');
              $('.load-search-results').fadeOut();
          }
      });
  
    if($('#basic').length > 0) {
        if ( typeof threadID !== 'undefined') {
            var chatID = threadID;   
        } else {
            var chatID = $('input[name=thread]').val();
        }

        var baseUrl = site_url + 'account/processFile';
        
        if ( typeof chatFileUrl !== 'undefined') {
            baseUrl = chatFileUrl;
        }
        
        $('#basic').simpleUpload({
              url: baseUrl,
              method: 'post',
              params: { chatID: chatID },
              ajax: {
                  headers: { 'X-Test': 'test' },
                  statusCode: {
                      200: function(response) {
                          $('.chat-text-wrap form').append(response);


                      }
                  }
              },
              dropZone: '#basic_drop_zone',
              progress: '#basic_progress'
          }).on('upload:done', function(e, file, i) {
              //            var html  = '<div class="chat-upload-file">';
              // html += '<img src="' + response.fileurl + '/' + response.filename + '" />';
              // html += '<a href="javascript:void(0);" class="remove-upload-file" data-file="' + response.filename + '"><i class="ion-close"></i></a>';
              // html += '</div>';

              // $('#basic_message').prepend(html);

              $('#basic_message').prepend('<p class="file-uploaded"><i class="fa fa-check-circle"></i> ' + file.name + '</p>');
              
          }).on('upload:fail', function(e, file, i) {
              console.log('fail ' + i);
              console.log(file);
              $('#basic_message').prepend('<p>fail: ' + file.name + '</p>');
          });
      }
  
      $('video').bind('play', function (e) {
          var video = $(this).get(0);
          console.log(video);
          $('video').removeClass('active-player');
          $(this).addClass('active-player');
  
          $('video').each(function() {
              console.log($(this).attr('src'));
              if($(this).is('.active-player')) {
                  this.play();
              } else {
                  this.pause();
              }
          });
      });
  
      $(document).on('focusin', '.dso-animated-field-label .form-control', function() {
          $(this).parent().addClass('dso-field-animate');
      });
  
      $(document).on('focusout', '.dso-animated-field-label .form-control', function() {
          $(this).parent().removeClass('dso-field-animate'); 
          if($(this).val() == '') {
              $(this).parent().removeClass('hide-label');
          } else {
              $(this).parent().addClass('hide-label');
          }
      });
          
      $(document).on('click', '.dso-animated-field-label label', function() {  
          $(this).parent().addClass('dso-field-animate');
      });
  
  
      function checkAnimatedLabels() {
          $('.dso-animated-field-label .form-control').each(function() {
              if($(this, ':input:not([type=hidden])').val() == '') {
                  $(this).parent().removeClass('hide-label');
              } else {
                  $(this).parent().addClass('hide-label');
              }
          });
      }
  
      
      $(document).ready(function() {
          checkAnimatedLabels();
      });
  
      $(document).on('click', '.get-tournaments', function(e) {
          e.preventDefault();
          $('#tournament-load').fadeIn();
  
          $('.get-tournaments').each(function() {
              if($(this).hasClass('dso-ebtn-solid')) {
                  $(this).removeClass('dso-ebtn-solid');
                  $(this).addClass('dso-ebtn-outline');
              }
          });
  
          $(this).addClass('dso-ebtn-solid');
  
          var category = $(this).attr('data-category');
          var game = $(this).attr('data-game');
  
          $.ajax({
              url: $(this).attr('href'),
              type : 'POST',
              data : {category : category, game : game},
              dataType: 'text',
              success: function( response ) {
                  $('#tournament-load').fadeOut();
  
                  $('.dso-tournaments').html(response);
              }, error : function(request, status, error) {
                  $('#login-load').fadeOut();
                  console.log(request.responseText);
              }
          });
      });
    
    // var player = new YT.Player('player');
    //so on jquery event or whatever call the play or stop on the video.
    //to play player.playVideo();
    //to stop player.stopVideo();
    
    $(document).on('click', '.play-home-video', function (e) {
        e.preventDefault();
        $('#video-player').modal('show');
        $('.load-video').fadeIn();
    
        $('.load-video').hide();
        $('.video-title').html('Welcome to DSO Esports.');
        // player.playVideo();
        var videoURL = $('#player').prop('src');
        videoURL += "&autoplay=1";
        $('#player').prop('src',videoURL);
    });

    $(document).on('click', '.close-home-video', function (e) {
        e.preventDefault();
        $('#video-player').modal('hide');

        var videoURL = $('#player').prop('src');
        videoURL = videoURL.replace("&autoplay=1", "");
        $('#player').prop('src','');
        $('#player').prop('src',videoURL);
    });

    // Load more button click event
    if($('#loadMorePlayers').length > 0) {
        $('#loadMorePlayers').on('click', function(e) {
            e.preventDefault();

            var offset = parseInt($(this).attr('data-offset'));
            var creq   = $(this);

            $('#loadPlayersLoader').fadeIn();

            $.ajax({
                url: $(this).attr('href'),
                type: 'POST',
                data : {offset: offset},
                dataType: 'text',
                success: function(data) {
                    $('#players').append(data);

                    offset += 10;

                    creq.attr('data-offset', offset);

                    if (data.trim() === '') {
                        $('#loadMorePlayers').hide();
                    }

                    $('#loadPlayersLoader').fadeOut();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    }

      /*$(window).scroll(function() {
          if($(window).scrollTop() + $(window).height() >= ($(document).height() - 428)) {
              var offset = $("input[name=]").val();
              var totrec = $("#totrec").val();
              
              if($("#loading:visible").length == 0) {    
                  loadmore(filts, offset, totrec);
              }
          }
      });
      
      function loadmore(filts, ofset, totrec) {
          var offset = parseInt(ofset) + 9;
  
          $("#offset").val(offset);
          $("#loading").show();
          
          var apiurl = "<?php echo base_url() . $isindex . "home/loadmore" ; ?>";
          
          $.ajax({
              url: apiurl,
              method: "POST",
              data: {
                  filts:filts,
                  offset:offset
              },
              success: function (result) {
                  $("#products").append(result);
                  $("#loading").hide();
              }
          });
      }*/
  });