const wrapper = document.querySelector(".wrapper"),
selectBtn = wrapper.querySelector(".select-btn"),
options = wrapper.querySelector(".options");


let countries =[ "Côte d Ivoire", "Mali", "Canada", "<Etats Unis", "France", "Belgique", "Darnemak", "Angleterre", "Suisse", "Russie", "France", "Belgique" ];

function addCountry() {
	countries.forEach(country => {
		
        let li = '<li>${country}</li>';
		options.insertAdjacentHTML("beforeend", li);
        
	});
}

addCountry();

selectBtn.addEventListener("click", () => {
    wrapper.classList.toggle("active");
});
