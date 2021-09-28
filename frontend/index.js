console.log('This is the AJAX document');

let isCreateModal = true;
let updateID;

// ----------- DOM functionalities -----------
function openCreationModal() {
  isCreateModal = true;

  // change model title
  document.getElementById('modelLabel').innerText = 'Create Record'

  // show the modal
  const modelElement = document.getElementById('model');
  const modal = bootstrap.Modal.getOrCreateInstance(modelElement); // Returns a Bootstrap modal instance
  modal.show();

}

function openUpdateModel(record) {
  console.log(record.record_id);
  updateID = record.record_id;
  // populate the inputs with the current record fields
  document.getElementById("new-artist").value = record.artist;
  document.getElementById("new-album").value = record.album;
  document.getElementById("new-released").value = record.released;
  document.getElementById("new-cover").value = record.cover;
  document.getElementById("new-genre").value = record.genre;
  document.getElementById("new-label").value = record.label;
  document.getElementById("new-onsale-yes").checked = record.onsale === '1';
  document.getElementById("new-onsale-no").checked = record.onsale === '0';
  document.getElementById("new-price").value = record.price;

  isCreateModal = false;

  // change model title
  document.getElementById('modelLabel').innerText = 'Update Record'

  // show the modal
  const modelElement = document.getElementById('model');
  const modal = bootstrap.Modal.getOrCreateInstance(modelElement); // Returns a Bootstrap modal instance
  modal.show();
}


function clearModal(){

  document.getElementById("new-artist").value = '';
  document.getElementById("new-album").value = '';
  document.getElementById("new-released").value = '';
  document.getElementById("new-cover").value = '';
  document.getElementById("new-genre").value = 'Rock';
  document.getElementById("new-label").value = '';
  document.getElementById("new-onsale-yes").checked = true;
  document.getElementById("new-price").value = 0;
}

function closeModal(){
  clearModal();
  const modelElement = document.getElementById('model')
  const modal = bootstrap.Modal.getInstance(modelElement) // Returns a Bootstrap modal instance
  
  modal.hide();
}


// ----------- API Functions -----------

function loadRecords() {
  $.ajax({
    url: 'http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/read.php',
    type: 'GET',
    success: function(result){
      const tbody = document.getElementsByTagName("tbody")[0];
    //   Create the rows by looping through the JSON
      const containerRecords = document.getElementsByTagName('records-container')[0];
      tbody.innerHTML = '';
      result.data.forEach(record => {
          //body.insertAdjacentHTML('beforeend', `<div>${record.artist} - ${record.album}<div><br/>`);
          tbody.insertAdjacentHTML('beforeend',
          `<tr>
            <td scope="row" class="ps-3">${record.record_id}</td>
            <td>${record.artist}</td>
            <td>${record.album}</td>
            <td>${record.released}</td>
            <td>${record.label}</td>
            <td><img src="${record.cover}" width="75" height="75" srcset=""></td>
            <td>${record.genre}</td>
            <td>${record.onsale == "1" ? '<i class="text-success fas fa-check"></i>' : ''}</td>
            <td>$${record.price}</td>
            <td class="pe-3">
              <i id="update-record-${record.record_id}" class="cursor-pointer fas fa-edit h4 text-primary me-3"></i>
              <i class="cursor-pointer fas fa-trash-alt h4 text-danger" onclick="deleteRecord(${record.record_id})"></i>
            </td>
          </tr>`
        );
        document.getElementById(`update-record-${record.record_id}`).addEventListener('click', () => openUpdateModel(record))                                        
      });
    },
  });
}


function filterRecords(genre) {
  $.ajax({
    url: `http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/read_with_filter.php?genre=${genre}`,
    type: 'GET',
    success: function(result){
      const tbody = document.getElementsByTagName("tbody")[0];
    //   Create the rows by looping through the JSON
      const containerRecords = document.getElementsByTagName('records-container')[0];
      tbody.innerHTML = '';
      result.data.forEach(record => {
          //body.insertAdjacentHTML('beforeend', `<div>${record.artist} - ${record.album}<div><br/>`);
          tbody.insertAdjacentHTML('beforeend',
          `<tr>
            <td scope="row" class="ps-3">${record.record_id}</td>
            <td>${record.artist}</td>
            <td>${record.album}</td>
            <td>${record.released}</td>
            <td>${record.label}</td>
            <td><img src="${record.cover}" width="75" height="75" srcset=""></td>
            <td>${record.genre}</td>
            <td>${record.onsale == "1" ? '<i class="text-success fas fa-check"></i>' : ''}</td>
            <td>$${record.price}</td>
            <td class="pe-3">
              <i id="update-record-${record.record_id}" class="cursor-pointer fas fa-edit h4 text-primary me-3"></i>
              <i class="cursor-pointer fas fa-trash-alt h4 text-danger" onclick="deleteRecord(${record.record_id})"></i>
            </td>
          </tr>`
        );
        document.getElementById(`update-record-${record.record_id}`).addEventListener('click', () => openUpdateModel(record))                                        
      });
    },
  });
}


function createRecord(payload) {
  fetch('http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/create.php',
  {
    method: 'POST',
    body: JSON.stringify(payload),
  })
  .then(result => result.json())
  .then(data => {
    console.log(data);
    closeModal();
    loadRecords();
  })
  .catch(error => console.log(error));
}

function updateRecord(id, payload) {
  fetch('http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/update.php',
  {
    method: 'PUT',
    body: JSON.stringify({
      ...payload,
      id,
    }),
  })
  .then(result =>result.json())
  .then(data => {
    console.log(data);
    closeModal();
    loadRecords();
  })
  .catch(error => console.log(error));
}

function deleteRecord(id) {
  // call delete api
  fetch(`http://localhost/dashboard/comp1230/ASGMT_2_REDO/api/record/delete.php?id=${id}`, 
    {
      method: 'DELETE',
    }).then(response => response.json())
    .then(data => {
      console.log(data);
      loadRecords();
    }).catch(error => {
      console.log(error);
    });

    // fetch() returns a Promise, we call then() to handle the resolved case for the response 
    // response is ResponseStream object, in order to get the data from the repsonse object we need to call repsonse.json() which returns another promise
    // So the second then handles the resolved case for repsonse.json() Promise
    // catch() handles the case when either Promises gets rejected
}


// initial data load
loadRecords();

// add event for creation of record
const submitBtn = document.getElementById("modal-submit-btn");
submitBtn.addEventListener("click", () => {
  
  const payload = {
    artist: document.getElementById("new-artist").value,
    album: document.getElementById("new-album").value,
    released: document.getElementById("new-released").value,
    cover: document.getElementById("new-cover").value,
    genre: document.getElementById("new-genre").value,
    label: document.getElementById("new-label").value,
    onsale: document.getElementById("new-onsale-yes").checked ? 1 : 0,
    price: document.getElementById("new-price").value,
  }
  // console.log(artist, album, released, cover, genre, onsale, price)

  if (isCreateModal) {
    // call create api (needs payload)
    createRecord(payload);
  } else {
    // call update api (it needs the id and the payload)
    updateRecord(updateID, payload)
  }

});




