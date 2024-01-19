"use strict"

let grid
const tableGridID = '#main-grid';
let tableGrid = $(tableGridID)

const mainJs = function() {
  var handleDatatables = () => {
    let table = tableGrid.DataTable({
      dom: `<'row'<'col-sm-6'l><'col-sm-6'p>>
            <'row'<'col-sm-12'tr>>
			      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>`,
      scrollY: "40vh",
      scrollX: true,
      scrollCollapse: true,
      lengthMenu: [10, 25, 50],
      pageLength: 10,
      language: {
        lengthMenu: "Display _MENU_",
        infoFiltered: "",
      },
      searchDelay: 500,
      processing: true,
      serverSide: true,
      // deferLoading: 0,
      ajax: {
        url:`${pageUrl}/datatable`,
        type: "POST",
        data: {
          columnsDef: [
            { value: "id", type: "num" },
            { value: "fullname", type: "string" },
            { value: "username", type: "string" },
            { value: "email", type: "string" },
            { value: "is_active", type: "num" },
            { value: "actions", type: "num" },
          ],
        },
        error: function (xhr, error, code) {
          if (xhr.status === 401){
            return alert('Unauthorize');
          }

          if(error)
            return Swal.fire('', `${code}`);
        },
      },
      columns: [
        { data: "id" },
        { data: "fullname" },
        { data: "username" },
        { data: "email" },
        { data: "is_active" },
        { data: "actions", responsivePriority: -1 },
      ],
      order: [[1, "asc"]],
      columnDefs: [
        {
          targets: [0],
          className: "text-center",
          orderable: false,
          searchable: false
        },
				{
					targets: [1, 2],
					className: "text-center",
				},
        {
					targets: [3],
					className: "text-left",
				},
        {
					targets: [4],
					className: "text-center",
          render: (data, type, full, meta) => {
            const is_checked = parseInt(data);
            const inputID = `is_active_${full.id}`;

            return DTUtils.toggleCheckbox(inputID, is_checked)
          }
				},
        {
          targets: -1,
          className: "text-center",
          orderable: false,
          searchable: false,
          render: (data, type, full, meta) => DTUtils.editDeleteButton(full)
        },
			],
      initComplete: function() {
        $(`${tableGridID}_filter input`).unbind();
				$(`${tableGridID}_filter input`).bind("keyup", function (e) {
					const value = this.value;
					if (e.keyCode == 13 || value.length == 0)
						table.search(this.value).draw();
				});

        var rowFilter = $('<tr class="filter"></tr>').appendTo(
					// $(table.table().header())
					$(tableGrid.DataTable().table().header())
				);

        this.api()
          .columns()
          .every(function() {
            const column = this
            const actionsPointer = "actions"
            let input
            switch (column.title()) {
              case "fullname":
              case "username":
              case "email":
                input = $(
									`<input type="text" class="form-control form-control-sm form-filter filter-input mx-auto" data-col-index="` +
										column.index() +
										`"/>`
								)

                $(input).keyup(function (e) {
									e.preventDefault()
									const value = this.value;
									var code = e.which
									if (code === 13 || value.length == 0) {
										$(this)
											.closest("tr")
											.find("button.grid-search")
											.trigger("click")
									}
								})
                break;
              case "is_active": 
                // Create select element
                input = document.createElement('select')
                input.add(new Option('All', -1, true))
                input.add(new Option('Not Active', 0))
                input.add(new Option('Active', 1))

                input.className = "form-control form-control-sm form-filter filter-input mx-auto"
                input.setAttribute("data-col-index", column.index())

                $(input).on('change', function(e) {
                  $(this)
											.closest("tr")
											.find("button.grid-search")
											.trigger("click")
                })

                break;
              case actionsPointer:
                DTUtils.drawSearchResetButton(table, rowFilter);
                break;
            }
            if (column.title() !== actionsPointer) {
							$(input).appendTo($("<th>").appendTo(rowFilter))
						}
          })
      }
    })

    DTUtils.drawNumber(table)
    // DTUtils.singleRowSelection(table)
    // DTUtils.multiRowSelection(table)

    table.on("click", "tbody div.edit-data", function () {
			var data = table.row($(this).parents("tr")).data()
			
      Swal.fire('Editing Time!', 'You can set it to open up modal for editing, but for now it will be just an Alert')
		})

    table.on("click", "tbody div.delete-data", function () {
			var data = table.row($(this).parents("tr")).data()
			
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success"
          });
        }
      })
		})

    table.on("change", "tbody input.dtutils-toggle-checkbox", function() {
      Swal.fire({
        title: "Are you sure?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Yes",
      }).then(function (result) {
        if (result.value) {
          // do the process here
        } else {
          DTUtils.refreshData(grid)
        }
      })
    })

    return table
  }

  return {
    init: () => {
      grid = handleDatatables()
    },
    delete: (data) => {
      console.log("🚀 ~ mainJs ~ data:", data)
    }
  }
}()

Cignadlte.onDOMContentLoaded(function() {
  mainJs.init()
})