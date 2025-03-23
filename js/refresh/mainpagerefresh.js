let popularCar = document.querySelector('#carouselControl1 .carousel-inner');
let soonCar = document.querySelector('#carouselControl2 .carousel-inner');
let createCar = document.querySelector('#carouselControl3 .carousel-inner');
let activeCar = document.querySelector('.active');
function refresh() {
    fetch("/themancerzone/php/refresh/mainpagerefresh.php").then(res => {
        return res.json();
    }).then(data => {
        for (let key in data) {
            const mapping = {
              popularLessons: popularCar,
              soonLessons: soonCar,
              popularCreators: createCar,
            };

            cleanUpCarousel(mapping[key]);
            let isActive = true;
            for (let i = 0; i < 12; i++) {
              if (i % 4 === 0) {
                createCarouselItem(data[key].slice(i, i + 4), isActive, mapping[key]);
                isActive = false;
              }
            }
          }
    });
}

setInterval(refresh, 5000);
refresh();

function cleanUpCarousel(carousel) {
    while(carousel.firstChild) {
        carousel.removeChild(carousel.firstChild);
    }

}
function createCarouselItem(data, isActive, destination) {
    let carouselItem = document.createElement("div");
    carouselItem.className = "carousel-item" + (isActive ? " active" : "");
  
    let multislide = document.createElement("div");
    multislide.className = "multislide";
  
    data.forEach((item) => {
      carouselAddSlide(item, multislide);
    });
  
    carouselItem.appendChild(multislide);
    destination.appendChild(carouselItem);
  }
  
  function carouselAddSlide(data, destination) {
    let title = data.title || data.displayname;
    let carouselImg = document.createElement("img");
    carouselImg.src = data.image;
    carouselImg.alt = title;
    carouselImg.className = "cImage";
  
    let carouselLink = document.createElement("a");
    let linkId = data.lessonid || data.username;
    carouselLink.href = (data.lessonid) ? `/lesson.php?lessonid=/${linkId}` : `/profile.php?username=/${linkId}`;
  
    let titleElement = document.createElement("p");
    titleElement.textContent = title;
  
    let captionPair = document.createElement("div");
    captionPair.className = "captionpair";
  
    carouselLink.appendChild(carouselImg);
    captionPair.appendChild(carouselLink);
    captionPair.appendChild(titleElement);
  
    
    destination.appendChild(captionPair);
  }