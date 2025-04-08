//Data for the cards
const cardData = [
  
    {
     title:"We Supported kavee's Battle Against Leukemia",
     content:"Four year old Kavee, bravely battling leukemia at Apeksha Cancer Institute Maharagama, received Rs. 200,000 in donations through our system. Thanks to the kindness and generosity of donors, Kavee successfully completed her life-saving treatment.",
     date:"Money Transfer Date-2024.04.21",
      image:"images/image1.jpg"
    },

    {
      title:"We Supported mala's Journey to Recovery",
      content:"Thanks to the generous hearts who donated Rs. 350,000 through our system, sixty two year old Mala successfully underwent critical heart surgery at Durdans Hospital and completed her treatment, regaining her health and hope.",
      date:"Money Transfer Date-2024.05.25",
      image:"images/image2.jpg"
   
     },
     {
      title:"We supported little hiruni's battle against stage 3 cancer",
      content:"Eleven year old Hiruni, battling osteosarcoma at Apeksha Cancer Hospital, received Rs. 400,000 in donations through our system. With heartfelt generosity, Hiruni completed her crucial treatment, embodying hope and resilience in her journey.",
      date:"Money Transfer Date-2024.05.10",
      image:"images/image3.webp"
   
     },
     
    
   
  ];
  

  // Container to hold the cards
const cardsContainer = document.getElementById('cards-container');

// Loop through the data and create cards
cardData.forEach(data =>{
  const col = document.createElement('div');
  col.className = 'col-12 col-sm-6 col-md-4 mb-4';  // Responsive classes for different screen sizes
  
  const card = document.createElement('div');
  card.className = 'card shadow-sm';

  card.innerHTML = `
    <div class="card m-3">
          <div class="position-relative">
          <img src="${data.image}" class="card-img-top" alt="...">
          </div>

          <div class="card-body">
            <h5 class="card-title">"${data.title}"</h5>
            <p class="card-text">"${data.content}"</p>
            <p class="card-text"><small class="text-muted">"${data.date}"</small></p>
          </div>
    </div>
  `;

  col.appendChild(card);
  cardsContainer.appendChild(col);
});




