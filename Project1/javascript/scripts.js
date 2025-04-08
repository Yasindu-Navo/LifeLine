//// Wait for the DOM content to be loaded
//document.addEventListener("DOMContentLoaded", function () {
//    loadOverallRating(); // Load the overall rating
//    loadReviews();       // Load recent reviews
//});
//
//// Function to fetch and display the overall rating
//function loadOverallRating() {
//    fetch('get_overall_rating.php')
//        .then(response => {
//            if (!response.ok) {
//                throw new Error('Network response was not ok');
//            }
//            return response.json(); // Parse the JSON response
//        })
//        .then(data => {
//            if (data.error) {
//                throw new Error(data.error);
//            }
//            // Display the overall rating below the 'ratings' element
//            const overallRatingElement = document.getElementById('overallRating');
//            overallRatingElement.innerText = `Overall Rating: ${data.overall_rating.toFixed(1)} / 5`;
//        })
//        .catch(error => {
//            console.error('Error fetching overall rating:', error);
//            const overallRatingElement = document.getElementById('overallRating');
//            overallRatingElement.innerText = 'Error fetching overall rating';
//        });
//}
//
//// Function to fetch and display the recent reviews
//function loadReviews() {
//    fetch('get_reviews.php')
//        .then(response => {
//            if (!response.ok) {
//                throw new Error('Network response was not ok');
//            }
//            return response.json(); // Parse the JSON response
//        })
//        .then(data => {
//            const reviewsDiv = document.getElementById('reviews');
//            reviewsDiv.innerHTML = ''; // Clear any existing reviews
//            data.reviews.forEach(review => {
//                // Create a new div for each review and append it to the reviewsDiv
//                const reviewDiv = document.createElement('div');
//                reviewDiv.classList.add('card','border-0', 'mb-3','g-4');
//                reviewDiv.innerHTML = `
//                    <div class="card-body" id="review-card>
//                        <h5 class="pcard-para">${review.name}</h5>
//                        <p class="card-para">${review.comment}</p>
//                        <p class="card-para">Rating: ${review.rating} / 5</p>
//                        
//                    </div>
//                `;
//                reviewsDiv.appendChild(reviewDiv);
//            });
//        })
//        .catch(error => {
//            console.error('Error fetching reviews:', error);
//            // Optionally, display an error message to the user
//        });
//}







// Handle star rating
            let stars = document.querySelectorAll('.star-rating .fa');
            let ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    let rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    // Reset all stars
                    stars.forEach(s => s.classList.remove('checked'));
                    // Highlight selected stars
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.add('checked');
                    }
                });
            });


