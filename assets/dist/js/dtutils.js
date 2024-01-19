const DTUtils = {
  refreshData: function (grid, initCompleteGrid, callback) {
    grid.ajax.reload(initCompleteGrid)

    if (callback && typeof callback === "function") {
      callback()
    }
  },
  toggleCheckbox: (inputID, is_checked) => {
    return (
      `<span class="custom-control custom-switch">
        <input type="checkbox" class="dtutils-toggle-checkbox custom-control-input change_is_active custom-switch-off-danger custom-switch-on-success" id="${inputID}" value="1" ${is_checked ? 'checked' : ''} >
        <label class="custom-control-label" for="${inputID}"/>
      </span>`
    );
  },
	editDeleteButton: (full) => {
		return `<div class="btn-group">
      <div type="button" class="edit-data btn btn-sm btn-info" title="Edit Data" data-id="${full.id}">
        <i class="fas fa-edit"></i>
      </div>
      <div type="button" class="delete-data btn btn-sm btn-danger" title="Delete Data" data-id="${full.id}">
        <i class="fas fa-trash-alt"></i>
      </div>
    </div>`;
	},
	drawSearchResetButton: (table, rowFilter) => {
		var search = $(`<button class="btn btn-success btn-sm btn-icon grid-search">
                  <span>
                    <i class="fa fa-search"></i>
                  </span>
                </button>`);

		var reset = $(`<button class="btn btn-default btn-sm btn-icon">
                  <span>
                    <i class="fas fa-sync"></i>
                  </span>
                </button></div></div>`);
		var coldiv = $('<div class="col-md-12 text-center">');
		var btngrp = $('<div class="btn-group">');

		var tmpSearch = btngrp.append(search);
		var tmpReset = btngrp.append(reset);
		var tmpcol = coldiv.append(tmpSearch).append(tmpReset);

		var tmpRow = $('<div class="row">').append(tmpcol);

		$('<th class="text-center">').append(tmpRow).appendTo(rowFilter);

		$(search).on("click", function (e) {
			e.preventDefault();
			var params = {};
			$(rowFilter)
				.find(".filter-input")
				.each(function () {
					var i = $(this).data("col-index");
					if (params[i]) {
						params[i] += "|" + $(this).val();
					} else {
						params[i] = $(this).val();
					}
				});
			$.each(params, function (i, val) {
				// apply search params to datatable
				table.column(i).search(val ? val : "", false, false);
			});
			table.table().draw();
		});

		$(reset).on("click", function (e) {
			e.preventDefault();
			$(rowFilter)
				.find(".filter-input")
				.each(function (i) {
					$(this).val("");
					table.column($(this).data("col-index")).search("", false, false);
				});
			table.table().draw();
		});
	},
	drawNumber: (table, index = 0) => {
		table.on("draw.dt", function () {
			var info = table.page.info();
			table
				.column(index, { search: "applied", order: "applied", page: "applied" })
				.nodes()
				.each(function (cell, i) {
					cell.innerHTML = i + 1 + info.start;
				});
		});
	},
	singleRowSelection: (table) => {
		table.on("click", "tbody tr", (e) => {
			let classList = e.currentTarget.classList;

			if (classList.contains("selected")) {
				classList.remove("selected");
			} else {
				table
					.rows(".selected")
					.nodes()
					.each((row) => row.classList.remove("selected"));
				classList.add("selected");
			}
		});
	},
	multiRowSelection: (table) => {
		table.on("click", "tbody tr", function (e) {
			e.currentTarget.classList.toggle("selected");
		});
	},
};
