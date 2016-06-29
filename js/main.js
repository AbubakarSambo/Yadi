jQuery(document)
		.ready(
				function($) {

					// customer sign in
					
					$('#foo').slideme({
						arrows: true,
						pagination: "numbers",
						nativeTouchScroll: true,
						resizable: {
						width: 320,
						height: 250,
						}
						});

					var tabItems = $('.cd-tabs-navigation a'), tabContentWrapper = $('.cd-tabs-content');

					tabItems
							.on(
									'click',
									function(event) {
										event.preventDefault();
										var selectedItem = $(this);
										if (!selectedItem.hasClass('selected')) {
											var selectedTab = selectedItem
													.data('content'), selectedContent = tabContentWrapper
													.find('li[data-content="'
															+ selectedTab
															+ '"]'), slectedContentHeight = selectedContent
													.innerHeight();

											tabItems.removeClass('selected');
											selectedItem.addClass('selected');
											selectedContent
													.addClass('selected')
													.siblings('li')
													.removeClass('selected');
											// animate tabContentWrapper height
											// when content changes
											tabContentWrapper.animate({
												'height' : slectedContentHeight
											}, 200);
										}
									});

					// hide the .cd-tabs::after element when tabbed navigation
					// has scrolled to the end (mobile version)
					checkScrolling($('.cd-tabs nav'));
					$(window).on('resize', function() {
						checkScrolling($('.cd-tabs nav'));
						tabContentWrapper.css('height', 'auto');
					});
					$('.cd-tabs nav').on('scroll', function() {
						checkScrolling($(this));
					});

					function checkScrolling(tabs) {
						var totalTabWidth = parseInt(tabs.children(
								'.cd-tabs-navigation').width()), tabsViewport = parseInt(tabs
								.width());
						if (tabs.scrollLeft() >= totalTabWidth - tabsViewport) {
							tabs.parent('.cd-tabs').addClass('is-ended');
						} else {
							tabs.parent('.cd-tabs').removeClass('is-ended');
						}
					}

					$("#loginFunc")
							.click(
									function(event) {
										event.preventDefault();
										
										var email = document
												.getElementById('email').value;
										var passcode = document
												.getElementById("pword").value;
										var user = 'customer';
										
										var vars = '&email=' +email+ '&passcode=' +passcode+'&user='+user;

										if (checkEmail()) {
													$.ajax({
														type : "GET",
														url : "php/customerFunction.php?action=signIn"+vars,
														success : function(ans) {
															if(ans >0){
																// email/passwrd match redirect page
																alert(ans);
															}
															else{
																alert("check your username and password");
															}
														}
													});
										}

									});

					function checkEmail() {
						var ans = true;
						var email = document.getElementById('email');
						var pword = document.getElementById("pword").value;
						var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
						var empty = verify();

						if (empty) {
							alert('Please fill all fields');
						}
						if ((!filter.test(email.value))) {
							alert('Please provide a valid email address');

							email.focus();
							ans = false;
						}

						return ans;
					}

					function verify(email, pword) {
						var email = document.getElementById("email").value;
						var pword = document.getElementById("pword").value;

						if (pword == '') {
							return true;
						} else
							return false;

					}

				});