(function ($) {
	var data_lobs_id = $("body").attr("data-lobs-id");
	//ZIP Code Validation And Form Process
	var index = 0;
	$.validator.addMethod(
		"pageRequired",
		function (value, element) {
			var $element = $(element);
			function match(index) {
				return $(element)
					.parent()

					.parent("fieldset#page_" + (index + 1)).length;
			}

			if (match(-1) || match(0) || match(1)) {
				return !this.optional(element);
			}

			return "dependency-mismatch";
		},

		$.validator.messages.required
	);
	// $.validator.addMethod(
	// 	"zipcode",
	// 	function (value, element) {
	// 		return (
	// 			this.optional(element) ||
	// 			/(?!00[02-5]|099|213|269|34[358]|353|419|42[89]|51[789]|529|53[36]|552|5[67]8|5[78]9|621|6[348]2|6[46]3|659|69[4-9]|7[034]2|709|715|771|81[789]|8[3469]9|8[4568]8|8[6-9]6|8[68]7|9[02]9|987)\d{5}/.test(
	// 				value
	// 			)
	// 		);
	// 	},
	// 	"Please provide a valid zipcode."
	// );

    $.validator.addMethod(
		"zipcode",
		function (value, element) {
			return (
				this.optional(element) || /^[0-9]{5}(?:-[0-9]{4})?$/.test(value) // Validates standard 5-digit or ZIP+4 format
			);
		},
		""
	);

	$(".zipcode-form").each(function () {
		var v = $(this).validate({
			errorClass: "pageRequired",

			errorPlacement: function (error, element) {
				/* Have made error placement to be on the same Element as that of the value sent by the API.Please refer to the API Responses as well */

				if (element.attr("name") === "zipcode") {
					element.parent().parent().find("p.zip-code-address").html("");
					error.appendTo(element.parent().parent().find("p.zip-code-address"));
				} else {
					error.insertAfter(element); // default error placement.
				}
			},

			validClass: "valid",

			errorElement: "label",

			onkeyup: function (element) {
				this.element(element);
			},

			onfocusout: function (element) {
				this.element(element);
			},

			highlight: function (element, errorClass, validClass) {
				$(element).parents().addClass(errorClass).removeClass(validClass);
			},

			unhighlight: function (element, errorClass, validClass) {
				$(element).parents().removeClass(errorClass).addClass(validClass);
			},

			rules: {
				zipcode: {
					required: true,

					zipcode: true,
				},
			},

			messages: {},

			submitHandler: function (form) {
				//console.log($(form).find("input[name='zipcode']"));

				var zipcodeData = [];

				/* Zipcode Data */

				var zip_id = $(form).find("input[name='zipcode']").attr("zip_id");

				var zip_lat = $(form).find("input[name='zipcode']").attr("zip_lat");

				var zip_lng = $(form).find("input[name='zipcode']").attr("zip_lng");

				var zip_state = $(form).find("input[name='zipcode']").attr("zip_state");

				var zip_code = $(form).find("input[name='zipcode']").attr("zip_code");

				// Old code zipcodeData = [zip_id, zip_lat, zip_lng, zip_state, zip_code];

				zipcodeData = [zip_code];

				/* Zipcode Data End */

				if ($(form).hasClass("sticky-form")) {
					var data_lobs_id =
						"&policies=" + $("#policy,#hero-policy").attr("data-lobs-id");
					var insuranceLine =
						"&insuranceLine=" +
						$("#policy,#hero-policy")
							.attr("data-main-lob-id")
							.replace(/[^A-Z0-9]/gi, "-")
							.toLowerCase();
				} else {
					var data_lobs_id = $("body").attr("data-lobs-id")
						? "&policies=" + $("body").attr("data-lobs-id")
						: "";
					var insuranceLine = $("body").attr("data-main-lob-id")
						? "&insuranceLine=" + $("body").attr("data-main-lob-id")
						: "";
				}

				//if(data_lobs_id != null || data_lobs_id !='' || !$('#invalid-policy').hasClass('active')){
				if (
					(data_lobs_id != null && data_lobs_id != "") ||
					!$("#invalid-policy").hasClass("active")
				) {
					if ($("#invalid-policy").hasClass("active")) {
						$(location).attr(
							"href",
							"https://agents.agencyheight.com/search/q?zipcode=" + zipcodeData
						);
					} else {
						$(location).attr(
							"href",
							"https://agents.agencyheight.com/search/q?zipcode=" +
								zipcodeData +
								data_lobs_id +
								insuranceLine +
                                "&state=" +
                                zip_state
						);
					}
				} else {
					$(location).attr(
						"href",
						"https://agents.agencyheight.com/search/q?zipcode=" + zipcodeData
					);
				}
			},
		});

		/* Zip Code API Call

Added zip ID ,latitued,longitude,state Attributes to the input after user adds valid zip code.

Then the values are sent on an array after the user submits 

*/

		$(document).on("input", "#search-to,#search-to-black", function () {
			// var zipcodeData = [];

			var zipcode_input = $(this);

			var zipcode_value = zipcode_input.val();

			if (zipcode_value.length > 4 && v.form()) {
				$.ajax({
					method: "GET",

					url:
						"https://api.joinhobnob.com/agencyheight/public/api/v1/search/zipcodes?q=" +
						zipcode_value,

					timeout: 0,

					success: function (response) {
						if ($.isEmptyObject(response.data)) {
							$(zipcode_input)
								.parent()
								.parent()
								.find("p.zip-code-address")
								.html(
									"<label id='zipcode-error' class='pageRequired' for='zipcode'>Please enter a valid zipcode.</label>"
								);

							$(zipcode_input)
								.closest(".location-search")
								.addClass("error pageRequired");

							$(zipcode_input)
								.parent()
								.parent()
								.find("button")
								.attr("disabled", true);
							$(zipcode_input).attr("zip_id", "");
							$(zipcode_input).attr("zip_lat", "");
							$(zipcode_input).attr("zip_lng", "");
							$(zipcode_input).attr("zip_state", "");
							$(zipcode_input).attr("zip_code", "");
						} else {

							$(zipcode_input).attr("zip_id", response.data[0].id);

							$(zipcode_input).attr("zip_lat", response.data[0].latitude);

							$(zipcode_input).attr("zip_lng", response.data[0].longitude);

							$(zipcode_input).attr("zip_state", response.data[0].jurisdiction.slug);

							$(zipcode_input).attr("zip_code", response.data[0].code);

							zipcodeData = [response.data[0].code];

							//For Sticky Header Form

							if ($(zipcode_input).parent().parent().hasClass("sticky-form")) {
								var data_lobs_id = $("#policy,#hero-policy").attr(
									"data-lobs-id"
								);

								console.log(data_lobs_id);
							} else {
								var data_lobs_id =
									"&policies=" + $("body").attr("data-lobs-id");
								var insuranceLine =
									"&insuranceLine=" + $("body").attr("data-main-lob-id");
							}

							if (!$(zipcode_input).parent().parent().hasClass("sticky-form")) {
								if (data_lobs_id != null && data_lobs_id != "") {
									$(zipcode_input)
										.parent()
										.parent()
										.find("p.zip-code-address")
										.html(
											"<a class='crm-link' href=https://agents.agencyheight.com/search/q?zipcode=" +
												zipcodeData +
												data_lobs_id +
												insuranceLine +
												">" +
												response.data[0].city +
												"," +
												response.data[0].county +
												"," +
												response.data[0].state +
												"</a>"
										);
								} else {
									$(zipcode_input)
										.parent()
										.parent()
										.find("p.zip-code-address")
										.html(
											"<a class='crm-link' href=https://agents.agencyheight.com/search/q?zipcode=" +
												zipcodeData +
												">" +
												response.data[0].city +
												"," +
												response.data[0].county +
												"," +
												response.data[0].state +
												"</a>"
										);
								}
							}
							$(zipcode_input)
								.parent()
								.parent()
								.find("button")
								.attr("disabled", false);

							$(zipcode_input)
								.closest(".location- search")
								.removeClass("error pageRequired");

							// $(".cross.input-remove").addClass("active");
						}
					},
				});
			} else {
				$(zipcode_input).parent().parent().find("p.zip-code-address").html("");
			}
		});
	});
	$(".zipcode-text-input").keyup(function (event) {
		$(".zipcode-form .zip-code-address").css({ display: "none" });
		$(".zipcode-form").removeClass("active-form");
		$(this).parent().parent().addClass("active-form");
		if ($(this).parent().parent().hasClass("active-form")) {
			$(".active-form .zip-code-address").css({ display: "block" });
		}
	});
	$(".zipcode-text-input").click(function (event) {
		$(".zipcode-form .zip-code-address").css({ display: "none" });
		$(".zipcode-form").removeClass("active-form");
		$(this).parent().parent().addClass("active-form");
		if ($(this).parent().parent().hasClass("active-form")) {
			$(".active-form .zip-code-address").css({ display: "block" });
		}
	});
	//ZIP Code Validation And Form Process End

	// Form JS used for the header sticky form and Hero form
	if ($(".sticky-form").length) {
		var outerHeight = $("section.left-tab-right-image").height();
		$(".header-zipcode-form").css({ display: "none" });
		$(".dropdown").css({ display: "none" });

		//Display Sticky Form JS
		// window.addEventListener("scroll", function () {
		// 	if (window.scrollY > outerHeight) {
		// 		$(".header-zipcode-form").css({ display: "block" });
		// 		$(".header-flex-wrap").css({ display: "none" });
		// 	} else {
		// 		$(".header-zipcode-form").css({ display: "none" });
		// 		$(".header-flex-wrap").css({ display: "flex" });
		// 	}
		// });
		//Custom Dropdown JS
		//The policies on the dropdown are filtered and displayed only when User Inputs
		$("#policy,#hero-policy").keyup(function (e) {
			let keyword_1 = $(e.currentTarget).val();
			if (keyword_1.length >= 1) {
				$(e.currentTarget).parent().find(".dropdown").css({ display: "block" });
				var input, filter, ul, li, a, i;
				input = $(e.currentTarget);
				filter = input.val().toUpperCase();
				div = $(e.currentTarget).parent().find(".dropdown");
				a = div.find("a");
				for (i = 0; i < a.length; i++) {
					txtValue = a[i].textContent || a[i].innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						a[i].style.display = "";
						var condt = true;
					} else {
						a[i].style.display = "none";
					}
					//If No Matches found
					if (condt != true) {
						$("#invalid-policy").css({ display: "block" });
						$("#invalid-policy").addClass("active");
						$(".crm-link").remove();
					} else {
						$(e.currentTarget)
							.parent()
							.find(".dropdown")
							.css({ display: "block" });
						$("#invalid-policy").removeClass("active");
						$("#invalid-policy").css({ display: "none" });
						$(".crm-link").remove();
					}
				}
			} else {
				$(".dropdown").css({ display: "none" });
				$("#policy,#hero-policy").attr("data-lobs-id", "");
				$("#policy,#hero-policy").attr("data-main-lob-id", "");
			}
		});
		$("#policy,#hero-policy").click(function (e) {
			let keyword_1 = $(e.currentTarget).val();
			if (keyword_1.length >= 1) {
				$(e.currentTarget).parent().find(".dropdown").css({ display: "block" });
				var input, filter, ul, li, a, i;
				input = $(e.currentTarget);
				filter = input.val().toUpperCase();
				div = $(e.currentTarget).parent().find(".dropdown");
				a = div.find("a");
				for (i = 0; i < a.length; i++) {
					txtValue = a[i].textContent || a[i].innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						a[i].style.display = "";
						var condt = true;
					} else {
						a[i].style.display = "none";
					}
					//If No Matches found
					if (condt != true) {
						$("#invalid-policy").css({ display: "block" });
						$("#invalid-policy").addClass("active");
						$(".crm-link").remove();
					} else {
						$(e.currentTarget)
							.parent()
							.find(".dropdown")
							.css({ display: "block" });
						$("#invalid-policy").removeClass("active");
						$("#invalid-policy").css({ display: "none" });
						$(".crm-link").remove();
					}
				}
			} else {
				$(e.currentTarget).parent().find(".dropdown").css({ display: "none" });
				$("#policy,#hero-policy").attr("data-lobs-id", "");
				$("#policy,#hero-policy").attr("data-main-lob-id", "");
			}
		});

		$(".lobs-ids").each(function (index) {
			$(this).on("click", function () {
				var lobsID = $(this).attr("id");
				var lobsTitle = $(this).attr("data-lobs-title");
				var lobsMainTitle = $(this).attr("data-main-lob");
				$("#policy,#hero-policy").val(lobsTitle);
				$("#policy,#hero-policy").attr("data-lobs-id", lobsID);
				$("#policy,#hero-policy").attr("data-main-lob-id", lobsMainTitle);
				$("#policy,#hero-policy").find(".dropdown").css({ display: "none" });
			});
		});

		//Hide Dropdown If Click On Other Areas than Listed
		$(document).mouseup(function (event) {
			var keyword1Label = $("#policy,#hero-policy");
			if (
				!keyword1Label.is(event.target) &&
				keyword1Label.has(event.target).length === 0
			) {
				$(".dropdown").css({ display: "none" });
			}
		});
	}
	// Form JS used for the header sticky form and Hero form  End
})(jQuery);
