let gridUser;

const tableUserGridID = "#user-grid";
const tableUserGrid = $(tableUserGridID);
const userForm = $('#user-form');
const userModal = $('#user-modal');

const userJs = (() => {
  const handleDataTable = () => {
    const table = tableUserGrid.DataTable({
      dom: `<'row'<'col-sm-6 d-flex align-items-center'l><'col-sm-6 d-flex justify-content-end'<'tambah-input m-0'>>>
            <'row'<'col-sm-12'tr>>
			      <'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>`,
			scrollY: "40vh",
			scrollX: true,
			scrollCollapse: true,
			lengthMenu: [10, 25, 50],
			pageLength: 10,
      searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: {
				url: `${pageUrl}/../user/datatable`,
				type: "POST",
				data: {
					columnDefs: [
						{ value: "u.id", type: "num" },
						{ value: "fullname", type: "string" },
						{ value: "username", type: "string" },
						{ value: "email", type: "string" },
						{ value: "p.name", type: "string" },
						{ value: "u.is_active", type: "num" },
					],
				},
				error: function (xhr, error, code) {
					Swal.fire({
            title: 'Terjadi Kesalahan',
            text: 'Terjadi kesalahan saat memproses request',
            icon: "error",
            confirmButtonText: "OK",
          });
				},
			},
			columns: [
				{ data: "id" },
				{ data: "fullname" },
				{ data: "username" },
				{ data: "email" },
				{ data: "privilege" },
				{ data: "is_active" },
				{ data: "actions", responsivePriority: -1 },
			],
			order: [[1, "asc"]],
      columnDefs: [
        { 
          className: "text-center", 
          targets: [0], 
          orderable: false,
					searchable: false,
        },
        { className: "text-center", targets: [0, 2, 3, 4, 5, 6] },
        {
					targets: [5],
					className: "text-center",
					render: (data, type, full, meta) => {
						const is_checked = +data;
						const inputID = `user_is_active_${full.id}`;
						return DTUtils.toggleCheckbox(inputID, is_checked);
					},
				},
				{
					targets: -1,
					className: "text-center",
					orderable: false,
					searchable: false,
					render: (data, type, full, meta) => DTUtils.editDeleteButton(full),
				},
      ],
      initComplete: function () {
        $(`${tableUserGridID}_filter input`).unbind();
				$(`${tableUserGridID}_filter input`).bind("keyup", function (e) {
					const value = this.value;
					if (e.keyCode == 13 || value.length == 0)
						table.search(this.value).draw();
				});

        var rowFilter = $('<tr class="filter"></tr>').appendTo(
					$(tableUserGrid.DataTable().table().header())
				);

        this.api()
					.columns()
					.every(function () {
            const column = this;
						const actionsPointer = "actions";
						let input;

            switch (column.title()) {
							case "fullname":
							case "username":
							case "email":
							case "privilege":
                input = $(
									`<input type="text" class="form-control form-control-sm form-filter filter-input me-5" data-col-index="${column.index()}"/>`
								);
								$(input).keyup(function (e) {
									e.preventDefault();
									const value = this.value;
									var code = e.which;
									if (code === 13 || value.length == 0) {
										$(this)
											.closest("tr")
											.find("button.grid-search")
											.trigger("click");
									}
								});
                break;
              case "is_active":
                input = document.createElement("select");
                input.add(new Option("All", -1, true));
                input.add(new Option("Tidak Aktif", 0));
                input.add(new Option("Aktif", 1));

                input.className =
                  "form-control form-control-sm form-filter filter-input mx-auto";
                input.setAttribute("data-col-index", column.index());

                $(input).on("change", function (e) {
                  $(this)
                    .closest("tr")
                    .find("button.grid-search")
                    .trigger("click");
                });
                break;
              case actionsPointer:
                DTUtils.drawSearchResetButton(table, rowFilter);
                break;
            }

            if (column.title() !== actionsPointer) {
							$(input).appendTo(
								$("<div class='pe-3'>").appendTo($("<th>").appendTo(rowFilter))
							);
						}
          })
      }
    });

    $(".tambah-input")
			.html(`<button type="button" id="btn-modal" class="btn btn-success btn-sm" data-toggle="modal" data-target="#user-modal">
        <i class="fa fa-plus"></i>&nbsp;Tambah
      </button>`);

    DTUtils.drawNumber(table);

    table.on("click", "tbody div.edit-data", function () {
			var data = table.row($(this).parents("tr")).data();
			userJs.editData(data);
		});

    table.on("click", "tbody div.delete-data", function () {
			var data = table.row($(this).parents("tr")).data();
			userJs.deleteData(data);
		});

    table.on("change", "tbody input.change_is_active", function (e) {
			var data = table.row($(this).parents("tr")).data();
			var checked = this.checked;
			userJs.updateStatus(data, checked);
		});

    return table;
  }

  const handleTab = () => {
		$('a#pengguna-tab').on(
			"shown.bs.tab",
			function () {
				DTUtils.refreshData(gridUser);
			}
		);
	};

  const handleSelect2 = () => {
    $('#hakakses').select2({
      placeholder: "Pilih salah satu",
			dropdownParent: "#user-modal",
      ajax: {
				url: `${pageUrl}/list`,
				dataType: "json",
				cache: true,
				data: function (params) {
					var query = {
						q: params.term,
					};
					return query;
				},
				processResults: function (data) {
					return {
						results: data.data,
					};
				},
				error: function (xhr, status, error) {
					
				},
			},
    });
  }

  const handleForm = () => {
    userForm.validate({
      rules: {
        privilege: {
          required: true,
        },
        fullname: {
          required: true,
        },
        username: {
          required: true,
        },
        email: {
          required: true,
        },
      },
      messages: {
        privilege: {
          required: "Pilih salah satu hak akses"
        },
        fullname: {
          required: "Masukkan nama lengkap"
        },
        username: {
          required: "Masukkan username"
        },
        email: {
          required: "Masukkan email"
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        $.cajax({
          url: `${pageUrl}/../user/save`,
          method: "POST",
          data: userForm.serialize(),
          dataType: 'json',
          success: (response) => {
            const { metadata } = response;
            Swal.fire({
              title: metadata.status ? "Berhasil" : "Gagal",
              html: metadata.message,
              icon: metadata.status ? "success" : "warning",
            }).then((result) => {
              if (result.isConfirmed && metadata.status) {
                userJs.resetForm();
              }
            });
          },
        }).always((xhr) => {
          if (xhr.status !== 401 && xhr.status !== 403)
            DTUtils.refreshData(gridUser);
        });
      }
    })
  }

  return {
    init: function() {
      gridUser = handleDataTable();
      handleTab();
      handleSelect2();
      handleForm();
    },
    resetForm: function() {
      $("#user-id").val("");
			userForm.trigger("reset");
      $("#hakakses").val(null).trigger("change");
    },
    editData: function(data) {
      userModal.modal("show");

      const {
        id, 
        fullname,
        username,
        email,
        privilege_id,
        privilege,
        is_active
      } = data;

      $("#user-id").val(+id);
			$("#fullname").val(fullname);
			$("#username").val(username);
			$("#email").val(email);
			$("#password").val("");
      Cignadlte.setManualSelect2('#hakakses', +privilege_id, privilege);
      $("#status_user").prop("checked", +is_active);
    },
    deleteData(data){
      Swal.fire({
				title: `Yakin Ingin Menghapus Data ${data.fullname}?`,
				text: "Data tidak bisa dikembalikan apabila telah dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.isConfirmed) {
					$.cajax({
						url: `${pageUrl}/../user/delete`,
						method: "POST",
						data: {
							id: data.id,
						},
						dataType: 'json',
						success: (response) => {
							const { metadata } = response;
							Swal.fire({
								title: metadata.status ? "Berhasil" : "Gagal",
								html: metadata.message,
								icon: metadata.status ? "success" : "warning",
							});
						},
					}).always((xhr) => {
						if (xhr.status !== 401 && xhr.status !== 403)
							DTUtils.refreshData(gridUser);
					});
				}
			});
    }
  }
})()

Cignadlte.onDOMContentLoaded(() => {
  userJs.init();
});
