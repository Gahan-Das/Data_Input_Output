//window.onload = showValues;

var input = document.getElementById("roll_no");

input.addEventListener("keypress", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("myBtn").click();
  }
});

var input = document.getElementById("search");
input.addEventListener("keypress", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("search-button").click();
  }
});
function showValues() {
  const value = document.getElementById("Records").value;

  fetch("handler.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "Records=" + encodeURIComponent(value),
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("table").innerHTML = data;
    });
}

document.getElementById("demo").innerHTML = "Wow Working";

function generateRandomNumber() {
  const randomValue = Math.floor(Math.random() * 1000) + 1;
  document.getElementById("random-number").innerHTML = randomValue;
}

function getInput() {
  name_ = document.getElementById("name").value;
  std_class = document.getElementById("class").value;
  section = document.getElementById("section").value;
  roll = document.getElementById("roll_no").value;

  document.getElementById("myForm").reset();
  let MyArray = Array(name_, std_class, section, roll);
  fetch("input.php?action=insert-op", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    // body: `name=${encodeURIComponent(name)}`
    body: JSON.stringify(MyArray),
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("given-name").innerHTML = data;
    });
}
function getInput_2(event) {
  console.log("getInput_2 triggered", event);
  const name_old = event.target.value;

  const name_ = document.getElementById("name_2").value;
  const std_class = document.getElementById("class_2").value;
  const section = document.getElementById("section_2").value;
  const roll = document.getElementById("roll_no_2").value;

  const MyArray = [name_, std_class, section, roll, name_old];
  fetch("input.php?action=edit-op", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    // body: `name=${encodeURIComponent(name)}`
    body: JSON.stringify(MyArray),
  })
    .then((response) => response.text())
    .then((data) => {
      // console.log("Server responded with:", data);
      document.getElementById("search-results").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function searchInput() {
  document.getElementById("search-results").style.visibility = "visible";
  search = document.getElementById("search").value;
  fetch("search.php?action=search-op", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `search=${encodeURIComponent(search)}`,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("search-results").innerHTML = data;
    });
}

function deleteSelectedRow(event) {
  const name = event.target.value;
  const filter = document.getElementById("search").value;
  fetch("search.php?action=delete-op", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `name=${encodeURIComponent(name)}&filter=${encodeURIComponent(
      filter
    )}`,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("search-results").innerHTML = data;
    });
}

function editSelectedRow(event) {
  const name = event.target.value;
  fetch("search.php?action=edit-op", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `name=${encodeURIComponent(name)}`,
  })
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("search-results").innerHTML = data;
    });
}

let fulldata = [];
const rowsPerPage = 5;
let currentPage = 1;
let currentFilter = "All";
function fetchData() {
  fetch("data.php")
    .then((response) => response.json())
    .then((data) => {
      if (Array.isArray(data) && data.length > 0) {
        fulldata = data;

        const totalPages = Math.ceil(fulldata.length / rowsPerPage);

        // If current page becomes invalid (e.g., too high), reset to last page
        if (currentPage > totalPages) {
          currentPage = totalPages;
        }

        displayTable(currentPage);
      }
    })
    .catch((error) => {
      console.error("Fetch error:", error);
    });
}

function displayTable(page) {
  const table = document.getElementById("table");
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const slicedData = fulldata.slice(startIndex, endIndex);
  //alert(slicedData);
  // Clear existing table rows
  let headerHTML = "<tr>";
  if (currentFilter === "All") {
    headerHTML += `
      <th>ROLL NUMBER</th>
      <th>CLASS</th>
      <th>SECTION</th>
      <th>NAME</th>`;
  } else if (currentFilter === "Name") {
    headerHTML += "<th>NAME</th>";
  } else if (currentFilter === "Class") {
    headerHTML += `<th>CLASS</th>
     <th>NAME</th>`;
  } else if (currentFilter === "Roll_No") {
    headerHTML += `
      <th>ROLL NUMBER</th>
      <th>NAME</th>`;
  }
  headerHTML += "</tr>";
  table.innerHTML = headerHTML;

  // Add new rows to the table
  slicedData.forEach((item) => {
    const row = table.insertRow();
    if (currentFilter === "All") {
      row.insertCell(0).innerText = item.Roll_Number;
      row.insertCell(1).innerText = item.Class;
      row.insertCell(2).innerText = item.Section;
      row.insertCell(3).innerText = item.Name;
    } else if (currentFilter === "Name") {
      row.insertCell(0).innerText = item.Name;
    } else if (currentFilter === "Class") {
      row.insertCell(0).innerText = item.Class;
      row.insertCell(1).innerText = item.Name;
    } else if (currentFilter === "Roll_No") {
      row.insertCell(0).innerText = item.Roll_Number;
      row.insertCell(1).innerText = item.Name;
    }
  });

  // Update pagination
  updatePagination(page);
}

function updatePagination(currentPageDisplay) {
  const pageCount = Math.ceil(fulldata.length / rowsPerPage);
  const paginationContainer = document.getElementById("pagination");
  paginationContainer.innerHTML = "";

  for (let i = 1; i <= pageCount; i++) {
    const pageLink = document.createElement("a");
    pageLink.href = "#";
    pageLink.innerText = i;
    pageLink.style.margin = "0 5px";
    if (i === currentPageDisplay) {
      pageLink.style.fontWeight = "bold";
      pageLink.style.backgroundColor = "dodgerblue";
      pageLink.style.color = "white";
    }

    pageLink.onclick = function () {
      currentPage = i;
      displayTable(i);
    };

    paginationContainer.appendChild(pageLink);
    //paginationContainer.appendChild(document.createTextNode(" "));
  }
}

document.getElementById("Records").addEventListener("change", function () {
  currentFilter = this.value;
  currentPage = 1; // reset to page 1 on filter change
  fetchData();
});

fetchData();

setInterval(function () {
  generateRandomNumber();
  fetchData();
}, 1000);
history.replaceState({}, document.title, window.location.pathname);
