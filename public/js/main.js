const map = L.map('map').setView([50.845347, 4.350323], 13);
const markers_hashmap = {};
const markers = [];
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

if (document.querySelector("#locations-table tbody")){
    const page = /page=/.test(location.href) ? Number(location.href.match("page=([0-9]*)")[1]) : 1;
    console.log(page);
    fetch(`./?datas_page=${page}`).then(res=>res.json()).then(handle_res).catch(error=>console.log("error", error));
}else {
    fetch("./?all_datas").then(res=>res.json()).then(handle_res).catch(error=>console.log("error", error));
}

function handle_res(locations){
    if(locations.error){
        alert(locations.error);
        return;
    }
    //add markers to map
    locations.forEach((location)=>{
        add_marker_location(location);
    });
    //center zoom
    const group = new L.featureGroup(markers);
    map.fitBounds(group.getBounds());
    //add locations to table (private home)
    const tbody = document.querySelector("#locations-table tbody");
    if (tbody){
        locations.forEach((location)=>{
            tbody_add_location(tbody, location);
        });
    }
    //add locations to list (public home)
    const ul_list = document.querySelector("#locations-list");
    if (ul_list){
        locations.forEach((location)=>{
            ul_add_location(ul_list, location);
        });
    }
    //show the number of location (public home)
    if (ul_list){
        const nb_locations_h3 = document.querySelector("#nb-locations");
        if (locations.length===0)nb_locations_h3.textContent = "pas encore de lieux";
        else if (locations.length===1)nb_locations_h3.textContent = "Il y a 1 lieu dans la base de données";
        else nb_locations_h3.textContent = `Il y a ${locations.length} lieux dans la base de données`;
	}
}

function add_marker_location(location){
    const marker = L.marker([location.latitude, location.longitude]).addTo(map);
    marker.bindPopup(`<h3>${location.nom}</h3><p>${location.rue} ${location.codepostal} Bruxelles</p><p>tel: ${location.telephone}</p><a href=${location.url}" target="_blank">Voir le site</a>`);
    markers_hashmap[location.id] = marker;
    markers.push(marker);
}

function ul_add_location(ul, location){
    const li = document.createElement("li");
    const li_html_content = `${location.nom} | ${location.rue} ${location.codepostal} Bruxelles | ${location.telephone} | <a href="${location.url}" target="_blank">Voir le site</a>`;
    li.innerHTML = li_html_content;
    ul.insertAdjacentElement("beforeend", li);
    //zoom on the marker when click
    li.addEventListener("click", (e)=>{
        const marker = markers_hashmap[location.id];
        marker.openPopup();
        map.setView(marker.getLatLng(), 17);
    });
}

function tbody_add_location(tbody, location){
    const tr = document.createElement("tr");
    //name
    const td1 = document.createElement("td");
    td1.textContent = location.nom;
    //adresse
    const td2 = document.createElement("td");
    td2.textContent = `${location.rue} ${location.codepostal} Bruxelles`;
    //telephone
    const td3 = document.createElement("td");
    td3.textContent = location.telephone;
    //url
    const td4 = document.createElement("td");
    const a4 = document.createElement("a");
    a4.href = location.url;
    a4.textContent = "Voir le site";
    a4.target = "_blank";
    td4.insertAdjacentElement("afterbegin", a4);
    //icon
    const td5 = document.createElement("td");
    td5.classList.add("text-center");
    const icon_i = document.createElement("i");
    icon_i.classList.add("fa", "fa-eye", "text-primary", "eye-icon")
    td5.insertAdjacentElement("afterbegin", icon_i);
    //add event when clicking on the icon
    icon_i.addEventListener("click", ()=>{
        const marker = markers_hashmap[location.id];
        marker.openPopup();
        map.setView(marker.getLatLng(), 17);
    });
    //if modo: show the icons to edit and delete
    if (document.querySelector("#logout-link")){
        const edit_a = document.createElement("a");
        const delete_a = document.createElement("a");
        edit_a.href=`./?edit=${location.id}`;
        delete_a.href=`./?delete=${location.id}`;
        const edit_icon = document.createElement("i");
        const delete_icon = document.createElement("i");
        edit_icon.classList.add("fa", "fa-pencil", "text-primary", "eye-icon")
        delete_icon.classList.add("fa", "fa-trash", "text-primary", "eye-icon")
        edit_a.insertAdjacentElement("afterbegin", edit_icon);
        delete_a.insertAdjacentElement("afterbegin", delete_icon);
        td5.insertAdjacentElement("beforeend", edit_a);
        td5.insertAdjacentElement("beforeend", delete_a);
    }
    //insert tds in tr
    tr.insertAdjacentElement("beforeend", td1);
    tr.insertAdjacentElement("beforeend", td2);
    tr.insertAdjacentElement("beforeend", td3);
    tr.insertAdjacentElement("beforeend", td4);
    tr.insertAdjacentElement("beforeend", td5);
    //insert the tr
    tbody.insertAdjacentElement("beforeend", tr);
}
