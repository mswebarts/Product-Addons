(function ($) {
	// do things on addon checkbox change
	$(".addon-checkbox").change(function () {
		var addonTotal = 0;

		// get the total of all selected addons
		$(".addon-checkbox:checked").each(function () {
			addonTotal += parseFloat($(this).data("price"));
		});
		var baseProductPrice = parseFloat($(".mspa-product-addons").data("base-price"));
		var newPrice = baseProductPrice + addonTotal;

		// update the price on the page
		var productElement = $(".mspa-product-addons").closest(".product");
		var priceElement;
		if (productElement.hasClass("sale")) {
			priceElement = productElement.find(".price ins .woocommerce-Price-amount.amount").first();
		} else {
			priceElement = productElement.find(".price .woocommerce-Price-amount.amount").first();
		}
		var priceText = priceElement.text();
		var currencySymbol = priceText.replace(/[0-9.,]/g, "");
		var oldPrice = priceText.replace(/[^0-9.,]/g, "");
		var newPriceText = priceText.replace(oldPrice, newPrice.toFixed(2));
		priceElement.text(newPriceText);

		// update the hidden input with the selected addons
		var selected_addons = [];
		$(".addon-checkbox:checked").each(function () {
			selected_addons.push({
				name: $(this).attr("name"),
				price: $(this).data("price"),
				section: $(this).data("section"),
			});
		});

		var baseProductPrice = parseFloat($(".mspa-product-addons").data("base-price"));
		var newPrice = baseProductPrice + addonTotal;

		// update the price using ajax
		$.ajax({
			url: mspa_script_vars.ajaxurl,
			type: "POST",
			data: {
				action: "mspa_update_product_price",
				selected_addons: JSON.stringify(selected_addons),
				product_id: mspa_script_vars.product_id,
			},
			success: function (response) {
				// update the price on the page
				var productElement = $(".mspa-product-addons").closest(".product");
				var priceElement;
				if (productElement.hasClass("sale")) {
					priceElement = productElement.find(".price ins .woocommerce-Price-amount.amount").first();
				} else {
					priceElement = productElement.find(".price .woocommerce-Price-amount.amount").first();
				}
				var priceText = priceElement.text();
				var currencySymbol = priceText.replace(/[0-9.,]/g, "");
				var oldPrice = priceText.replace(/[^0-9.,]/g, "");
				var newPriceText = priceText.replace(oldPrice, newPrice.toFixed(2));
				priceElement.text(newPriceText);

				// update the hidden input with the selected addons
				$("#selected_addons").val(JSON.stringify(selected_addons));
			},
		});
	});

	// make sure at least one addon is selected
	$("form.cart").on("submit", function (e) {
		var isValid = true;

		mspaSections.forEach(function (section) {
			if ($(".section-" + section.id + ' input[type="checkbox"]:checked').length === 0) {
				alert("Please select at least one item from the " + section.name + " section.");
				isValid = false;
				return false; // Stop the loop
			}
		});

		if (!isValid) {
			e.preventDefault(); // Prevent form submission
		}
	});
})(jQuery);
