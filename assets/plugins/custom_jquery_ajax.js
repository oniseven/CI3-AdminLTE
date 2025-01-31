$.cajax = function(options) {
  var defaults = {
    beforeSemd: function() {
      Swal.fire({
        title: 'Please Wait !',
        html: 'Loading ...',// add html attribute if you want or remove
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading()
        },
      });
    }
  }
}