const cloud = document.getElementById("log-gob");
const barraLateral = document.querySelector(".barra-lateral");
const spans = document.querySelectorAll("span");
const palanca = document.querySelector(".switch");
const circulo = document.querySelector(".circulo");
const menu = document.querySelector(".menu");
const main = document.querySelector("main");

menu.addEventListener("click", () => {
  barraLateral.classList.toggle("max-barra-lateral");
  if (barraLateral.classList.contains("max-barra-lateral")) {
    menu.children[0].style.display = "none";
    menu.children[1].style.display = "block";
  } else {
    menu.children[0].style.display = "block";
    menu.children[1].style.display = "none";
  }
  if (window.innerWidth <= 320) {
    barraLateral.classList.add("mini-barra-lateral");
    main.classList.add("min-main");
    spans.forEach((span) => {
      span.classList.add("oculto");
    });
  }
});

palanca.addEventListener("click", () => {
  let body = document.body;
  body.classList.toggle("dark-mode");
  // body.classList.toggle("");
  circulo.classList.toggle("prendido");
});

cloud.addEventListener("click", () => {
  barraLateral.classList.toggle("mini-barra-lateral");
  main.classList.toggle("min-main");
  spans.forEach((span) => {
    span.classList.toggle("oculto");
  });
});
// navbar------------------

//tabla-----------------------

const search = document.querySelector(".input-group input"),
  table_rows = document.querySelectorAll("tbody tr"),
  table_headings = document.querySelectorAll("thead th");

// 1.Buscando datos específicos de una tabla HTML
search.addEventListener("input", searchTable);

function searchTable() {
  table_rows.forEach((row, i) => {
    let table_data = row.textContent.toLowerCase(),
      search_data = search.value.toLowerCase();

    row.classList.toggle("hide", table_data.indexOf(search_data) < 0);
    row.style.setProperty("--delay", i / 25 + "s");
  });

  document.querySelectorAll("tbody tr:not(.hide)").forEach((visible_row, i) => {
    visible_row.style.backgroundColor =
      i % 2 == 0 ? "transparent" : "#0000000b";
  });
}

// 2. Clasificación | Ordenar datos de la tabla HTML

table_headings.forEach((head, i) => {
  let sort_asc = true;
  head.onclick = () => {
    table_headings.forEach((head) => head.classList.remove("active"));
    head.classList.add("active");

    document
      .querySelectorAll("td")
      .forEach((td) => td.classList.remove("active"));
    table_rows.forEach((row) => {
      row.querySelectorAll("td")[i].classList.add("active");
    });

    head.classList.toggle("asc", sort_asc);
    sort_asc = head.classList.contains("asc") ? false : true;

    sortTable(i, sort_asc);
  };
});

function sortTable(column, sort_asc) {
  [...table_rows]
    .sort((a, b) => {
      let first_row = a
          .querySelectorAll("td")
          [column].textContent.toLowerCase(),
        second_row = b.querySelectorAll("td")[column].textContent.toLowerCase();

      return sort_asc
        ? first_row < second_row
          ? 1
          : -1
        : first_row < second_row
        ? -1
        : 1;
    })
    .map((sorted_row) =>
      document.querySelector("tbody").appendChild(sorted_row)
    );
}

// 3. Convertir una tabla HTML a PDF

const pdf_btn = document.querySelector("#toPDF");
const tab_inc = document.querySelector("#tab_inc");

const toPDF = function (tab_inc) {
  const html_code = `
   <link rel="stylesheet" href="/frontend/aseets/css/index.css"/>
   <link rel="stylesheet" href="/frontend/aseets/css/navbar.css"/>
   <div class="table" id="tab_inc">${tab_inc.innerHTML}</div>`;

  const new_window = window.open();
  new_window.document.write(html_code);

  setTimeout(() => {
    new_window.print();
    new_window.close();
  }, 200);
};

pdf_btn.onclick = () => {
  toPDF(tab_inc);
};

// // 4. Convertir una tabla HTML a JSON

const json_btn = document.querySelector("#toJSON");

const toJSON = function (table) {
  let table_data = [],
    t_head = [],
    t_headings = table.querySelectorAll("th"),
    t_rows = table.querySelectorAll("tbody tr");

  for (let t_heading of t_headings) {
    let actual_head = t_heading.textContent.trim();
    t_head.push(
      actual_head
        .substr(0, actual_head.length - 1)
        .trim()
        .toLowerCase()
    );
  }

  t_rows.forEach((row) => {
    const row_object = {};
    t_cells = row.querySelectorAll("td");

    t_cells.forEach((t_cell, cell_index) => {
      row_object[t_head[cell_index]] = t_cell.textContent.trim();
    });
    table_data.push(row_object);
  });

  return JSON.stringify(table_data, null, 8);
};

json_btn.onclick = () => {
  const json = toJSON(tab_inc);
  downloadFile(json, "json", "listado de incidencias");
};

// 5. Convertir una tabla HTML a un archivo CSV

const csv_btn = document.querySelector("#toCSV");

const toCSV = function (table) {
  const t_rows = table.querySelectorAll("tr");
  return [...t_rows]
    .map((row) => {
      const cells = row.querySelectorAll("th, td");
      return [...cells].map((cell) => cell.textContent.trim()).join(",");
    })
    .join("\n");
};

csv_btn.onclick = () => {
  const csv = toCSV(tab_inc);
  downloadFile(csv, "csv", "listado de incidencias");
};

// 6. Conversión de tabla HTML a archivo EXCEL
const excel_btn = document.querySelector("#toEXCEL");

const toExcel = function (table) {
  const t_rows = table.querySelectorAll("tr");
  return [...t_rows]
    .map((row) => {
      const cells = row.querySelectorAll("th,td");
      return [...cells].map((cell) => cell.textContent.trim()).join("\t");
    })
    .join("\n");
};

excel_btn.onclick = () => {
  const excel = toExcel(tab_inc);
  downloadFile(excel, "excel", "listado de incidencias");
};

const downloadFile = function (data, fileType, fileName = "") {
  const a = document.createElement("a");
  a.download = fileName;
  const mime_types = {
    json: "application/json",
    csv: "text/csv",
    excel: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  };
  a.href = `
        data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
    `;
  document.body.appendChild(a);
  a.click();
  a.remove();
};
//tabla-----------------------

let startBtn = document.querySelector(".startBtn");
let endBtn = document.querySelector(".endBtn");
let stepBtn = document.querySelectorAll(".stepBtn");
let tbody = document.querySelector("tbody");
let numsContainer = document.querySelector(".nums");

let pageSize = 6; // Número de incidencias por página
let currentPage = 0; // Página actual

function showPage(page) {
  let start = page * pageSize;
  let end = start + pageSize;
  let rows = Array.from(tbody.querySelectorAll("tr"));

  rows.forEach((row, index) => {
    if (index >= start && index < end) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}

function updateBtns() {
  let totalPages = Math.ceil(tbody.querySelectorAll("tr").length / pageSize);

  startBtn.disabled = currentPage === 0;
  endBtn.disabled = currentPage === totalPages - 1;
  stepBtn[0].disabled = currentPage === 0;
  stepBtn[1].disabled = currentPage === totalPages - 1;

  // Generar los números de página
  numsContainer.innerHTML = "";
  let currentPageGroup = Math.floor(currentPage / 6); // Grupo de seis páginas actual
  for (
    let i = currentPageGroup * 6;
    i < Math.min(currentPageGroup * 6 + 6, totalPages);
    i++
  ) {
    let num = document.createElement("a");
    num.href = "#";
    num.classList.add("num");
    num.textContent = i + 1;
    num.addEventListener("click", () => {
      currentPage = i;
      showPage(currentPage);
      updateBtns();
    });
    numsContainer.appendChild(num);
  }

  // Marcar como activa la página actual
  let numElements = numsContainer.querySelectorAll(".num");
  numElements.forEach((num, index) => {
    num.classList.toggle("active", index === currentPage % 6);
  });
}

endBtn.addEventListener("click", () => {
  currentPage = Math.ceil(tbody.querySelectorAll("tr").length / pageSize) - 1;
  showPage(currentPage);
  updateBtns();
});

startBtn.addEventListener("click", () => {
  currentPage = 0;
  showPage(currentPage);
  updateBtns();
});

stepBtn.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    currentPage += e.target.id === "next" ? 1 : -1;
    showPage(currentPage);
    updateBtns();
  });
});

// Mostrar la primera página al cargar la página
showPage(currentPage);
updateBtns();
