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
	// 	""
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

	$(".zipcode-email-form").each(function () {
		var v = $(this).validate({
			errorClass: "pageRequired",

			errorPlacement: function (error, element) {
				/* Have made error placement to be on the same Element as that of the value sent by the API.Please refer to the API Responses as well */

				if (element.attr("name") === "zipcode") {
					element.parent().parent().find("p.zip-code-address").html("");
					error.remove();
				} else if (element.attr("name") === "agent-email") {
					error.remove();
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
				email: {
					required: false, // Email field no longer required
					email: true,
				},
			},

			messages: {},

			submitHandler: function (form) {
				$(".error-field").hide();
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
					var data_lobs_id = $("#policy,#hero-policy").attr("data-lobs-id");
					var insuranceLine = $("#policy,#hero-policy")
						.attr("data-main-lob-id")
						.replace(/[^A-Z0-9]/gi, "-")
						.toLowerCase();
				} else {
					var data_lobs_id = $("body").attr("data-lobs-id")
						? $("body").attr("data-lobs-id")
						: "homeowners";
					var insuranceLine = "";
				}
				var registerEmail = $(form).find("input[name='agent-email']").val();
				//if(data_lobs_id != null || data_lobs_id !='' || !$('#invalid-policy').hasClass('active')){
				if (
					(data_lobs_id != null && data_lobs_id != "") ||
					!$("#invalid-policy").hasClass("active")
				) {
					if ($("#invalid-policy").hasClass("active")) {
						$(location).attr(
							"href",
							"https://agents.agencyheight.com/search/q?zipcode=" +
								zipcodeData +
								"&email=" +
								registerEmail
						);
					} else {
						$(location).attr(
							"href",
							"https://agents.agencyheight.com/search/q?zipcode=" +
								zipcodeData +
								"&policies=" +
								data_lobs_id +
								"&insuranceLine=" +
								insuranceLine +
								"&email=" +
								registerEmail +
								"&state=" +
								zip_state
						);
					}
				} else {
					$(location).attr(
						"href",
						"https://agents.agencyheight.com/search/q?zipcode=" +
							zipcodeData +
							"&email=" +
							registerEmail
					);
				}
				console.log(registerEmail);
				console.log(zipcodeData[0]);

				// Ensure zipcodeData is a string, not an array, if that's what's expected by the API
				var zipCode = Array.isArray(zipcodeData) ? zipcodeData[0] : zipcodeData;
				var policies_data =
					$("body").attr("data-lobs-id")?.trim() || "homeowners";
				var data_policies = policies_data.split(",").filter((item) => item);

				const dataToSend = {
					zipCode: zipCode,
					email: registerEmail,
					policies: data_policies,
				};
				$.ajax({
					type: "POST",
					url: "https://api.joinhobnob.com/agencyheight/public/api/v1/iqls",
					processData: false,
					contentType: "application/json",
					data: JSON.stringify(dataToSend), // Send the complete data object
					success: function (data) {
						console.log(data);
					},
					error: function (xhr, status, error) {
						console.log("Error status:", status);
						console.log("Error:", error);
						console.log("Response text:", xhr.responseText); // This may provide details about the validation issue
					},
					complete: function (data) {},
				});
			},
		});

		/* Zip Code API Call

Added zip ID ,latitued,longitude,state Attributes to the input after user adds valid zip code.

Then the values are sent on an array after the user submits 

*/

		/* Zip Code API Call - Updated Version */

		$(document).on("input", "#search-to,#search-to-black", function () {
			// Define the zipcode input field
			var zipcode_input = $(this);
			var zipcode_value = zipcode_input.val();

			// Check if the ZIP code length is greater than 4 and the ZIP code is valid
			if (zipcode_value.length > 4) {
				// Make the API call only if the ZIP code length is valid
				$.ajax({
					method: "GET",
					url:
						"https://api.joinhobnob.com/agencyheight/public/api/v1/search/zipcodes?q=" +
						zipcode_value,
					timeout: 0,
					success: function (response) {
						// Check if the response data is empty
						if ($.isEmptyObject(response.data)) {
							// Show error message if the ZIP code is invalid
							// $(zipcode_input)
							// 	.parent()
							// 	.parent()
							// 	.find("p.zip-code-address")
							// 	.html(
							// 		"<label id='zipcode-error' class='pageRequired' for='zipcode'>Please enter a valid zipcode.</label>"
							// 	);

							$(zipcode_input)
								.closest(".location-search")
								.addClass("error pageRequired");

							$(zipcode_input)
								.parent()
								.parent()
								.find("button")
								.attr("disabled", true);

							// Clear the zip code attributes
							$(zipcode_input).attr("zip_id", "");
							$(zipcode_input).attr("zip_lat", "");
							$(zipcode_input).attr("zip_lng", "");
							$(zipcode_input).attr("zip_state", "");
							$(zipcode_input).attr("zip_code", "");
						} else {
							// If the ZIP code is valid, populate the data attributes
							var zipData = response.data[0];

							$(zipcode_input).attr("zip_id", zipData.id);
							$(zipcode_input).attr("zip_lat", zipData.latitude);
							$(zipcode_input).attr("zip_lng", zipData.longitude);
							$(zipcode_input).attr("zip_state", zipData.jurisdiction.slug);
							$(zipcode_input).attr("zip_code", zipData.code);

							// Populate the ZIP code data in an array (if necessary for further use)
							var zipcodeData = [zipData.code];

							// // Example of populating a link with the returned data (you can adjust this as needed)
							// $(zipcode_input)
							// 	.parent()
							// 	.parent()
							// 	.find("p.zip-code-address")
							// 	.html(
							// 		"<a class='crm-link' href='https://agents.agencyheight.com/search/q?zipcode=" +
							// 			zipcodeData +
							// 			"'>" +
							// 			zipData.city +
							// 			", " +
							// 			zipData.county +
							// 			", " +
							// 			zipData.state +
							// 			"</a>"
							// 	);

							// Enable the button after the ZIP code is valid
							$(zipcode_input)
								.parent()
								.parent()
								.find("button")
								.attr("disabled", false);
						}
					},
					error: function (xhr, status, error) {
						// Handle any errors from the API call
						console.error("API Call Error:", error);
					},
				});
			} else {
				// If the ZIP code is too short, reset the input and disable the button
				$(zipcode_input).parent().parent().find("p.zip-code-address").html("");
				$(zipcode_input)
					.closest(".location-search")
					.removeClass("error pageRequired");
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
			}
		});
	});
	// $(".zipcode-text-input").keyup(function (event) {
	// 	$(".zipcode-email-form .zip-code-address").css({ display: "none" });
	// 	$(".zipcode-email-form").removeClass("active-form");
	// 	$(this).parent().parent().addClass("active-form");
	// 	if ($(this).parent().parent().hasClass("active-form")) {
	// 		$(".active-form .zip-code-address").css({ display: "block" });
	// 	}
	// });
	// $(".zipcode-text-input").click(function (event) {
	// 	$(".zipcode-email-form .zip-code-address").css({ display: "none" });
	// 	$(".zipcode-email-form").removeClass("active-form");
	// 	$(this).parent().parent().addClass("active-form");
	// 	if ($(this).parent().parent().hasClass("active-form")) {
	// 		$(".active-form .zip-code-address").css({ display: "block" });
	// 	}
	// });
	// //ZIP Code Validation And Form Process End

	// //Agent Register for Blogs and Pages
	// $(".agent-email-input").keyup(function (event) {
	// 	$(".agent-email-subscribe #agent-email-error").css({ display: "none" });
	// 	$(".agent-email-subscribe").removeClass("active-form");
	// 	$(this).parent().parent().addClass("active-form");
	// 	if ($(this).parent().parent().hasClass("active-form")) {
	// 		$(".active-form #agent-email-error").css({ display: "block" });
	// 	}
	// 	if ($(this).is(":valid")) {
	// 		$(this).parent().siblings().attr("disabled", false);
	// 	} else {
	// 		$(this).parent().siblings().attr("disabled", true);
	// 	}
	// });
	// $(".agent-email-input").click(function (event) {
	// 	$(".agent-email-subscribe #agent-email-error").css({ display: "none" });
	// 	$(".agent-email-subscribe").removeClass("active-form");
	// 	$(this).parent().parent().addClass("active-form");
	// 	if ($(this).parent().parent().hasClass("active-form")) {
	// 		$(".active-form #agent-email-error").css({ display: "block" });
	// 	}
	// });

	$(window).on("load resize orientationchange", function () {
		if ($(window).width() <= 600) {
			$(".zipcode-email-form")
				.parent()
				.not(".right-sidebar .zipcode-email")
				.removeClass("location-search");
			$(".zipcode-email-form")
				.parent()
				.not(".right-sidebar .zipcode-email")
				.addClass("location-search-mobile");
		} else {
			$(".zipcode-email-form")
				.parent()
				.not(".right-sidebar .zipcode-email")
				.addClass("location-search");
			$(".zipcode-email-form")
				.parent()
				.not(".right-sidebar .zipcode-email")
				.removeClass("location-search-mobile");
		}
	});
})(jQuery);
