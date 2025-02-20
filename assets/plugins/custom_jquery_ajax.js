$.cajax = function(options) {
  var defaults = {
    beforeSend: function() {
      Swal.fire({
        title: 'Please Wait !',
        html: 'Loading ...',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading()
        },
      });
    },
    success: function() {
      // Swal.close();
    },
    error: function (xhr, status, error) {
      // Swal.close();
      Swal.fire({
        title: 'Terjadi Kesalahan',
        text: 'Terjadi kesalahan saat memproses request',
        icon: "error",
        confirmButtonText: "OK",
      });
		},
  };

  // Merge default options with user-provided options
	options = $.extend({}, defaults, options);

	// Perform default action before sending the request
	options.beforeSend();

	// Execute the AJAX request with user-provided options
	return $.ajax(options).always(function () {
		// Perform default action after the request completes (regardless of success or failure)
		// options.complete();
	});
}