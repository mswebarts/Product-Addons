(function ($) {
	// initialize repeater field
	if ($(".mspa-repeater")) {
		$(".mspa-repeater").repeater({
			initEmpty: false,
			show: function () {
				$(this).slideDown();
			},
			hide: function (deleteElement) {
				if (confirm("Are you sure you want to delete this element?")) {
					$(this).slideUp(deleteElement);
				}
			},
			isFirstItemUndeletable: true,
		});
	}

	// initialize the accordion
	$(".mspa-accordion-title").click(function () {
		$(this).next(".mspa-accordion-content").slideToggle();
		$(this).find(".toggle-icon").toggleClass("dashicons-arrow-down-alt2 dashicons-arrow-up-alt2");
	});
})(jQuery);
