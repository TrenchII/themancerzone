let sounds = [];
for (let i = 0; i < 9; i++) {
  sounds[i] = new Audio('/rdecrewe/themancerzone/sounds/whoosh.mp3');
}
sounds[9] = new Audio('/rdecrewe/themancerzone/sounds/alakazam.mp3');
let throttleTimeout;
document.addEventListener("mousemove", (e) => {
  if (throttleTimeout) return;

  let sparkleContainer = document.querySelector(".sparkle-container");

  // create container for sparkles if it doesn't exist
  if (!sparkleContainer) {
    sparkleContainer = document.createElement("div");
    sparkleContainer.className = "sparkle-container";
    sparkleContainer.style.position = "absolute";
    sparkleContainer.style.left = "0";
    sparkleContainer.style.top = "0";
    sparkleContainer.style.width = "100%";
    sparkleContainer.style.height = "100%";
    sparkleContainer.style.pointerEvents = "none";
  }

  throttleTimeout = setTimeout(() => {
    throttleTimeout = null;
  }, 20);

  const sparkle = document.createElement("div");
  sparkle.className = "sparkle";

  const colors = [
    [255, 187, 0],
    [128, 0, 128],
  ];
  // randomly choose a color somewhere between the two colors
  const color = colors[Math.floor(Math.random() * colors.length)];
  sparkle.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
  sparkle.style.boxShadow = "0 0 6px #fff, 0 0 10px #ff0";

  sparkle.style.left = `${e.pageX}px`;
  sparkle.style.top = `${e.pageY}px`;

  sparkleContainer.appendChild(sparkle);
  document.body.appendChild(sparkleContainer);

  // JavaScript animation for fadeOut
  let opacity = 1;
  let scale = 1;
  const fadeOutInterval = setInterval(() => {
    opacity -= 0.05;
    scale -= 0.03;
    sparkle.style.opacity = opacity;
    sparkle.style.transform = `scale(${scale})`;

    if (opacity <= 0) {
      clearInterval(fadeOutInterval);
      sparkle.remove();
    }
  }, 40); // Adjust interval timing for smoothness
});

document.addEventListener("click", (e) => {
  const count = document.querySelectorAll(
    ".sparkle[data-click-effect], .star[data-click-effect]"
  );

  if (count.length > 300) {
    count.forEach((el) => {
      el.remove();
    });
  }

  const sparkleContainer =
    document.querySelector(".sparkle-container") ||
    document.createElement("div");

  if (!sparkleContainer.parentElement) {
    sparkleContainer.className = "sparkle-container";
    sparkleContainer.style.position = "absolute";
    sparkleContainer.style.left = "0";
    sparkleContainer.style.top = "0";
    sparkleContainer.style.width = "100%";
    sparkleContainer.style.height = "100%";
    sparkleContainer.style.pointerEvents = "none";
    document.body.appendChild(sparkleContainer);
  }

  const burstCount = 20; // Number of sparkles in the burst
  for (let i = 0; i < burstCount; i++) {
    // Choose a random number between 0 and 1
    const randomNum = Math.random();
    // If the random number is less than 0.5, create a sparkle, otherwise create a star

    let isStar = false;
    let sparkle;

    if (randomNum < 0.5) {
      sparkle = document.createElement("div");
      sparkle.className = "sparkle";
    } else {
      sparkle = document.createElement("div");
      sparkle.className = "star";
      isStar = true;
    }

    if (!isStar) {
      const colors = [
        [255, 187, 0],
        [128, 0, 128],
      ];
      const color = colors[Math.floor(Math.random() * colors.length)];
      sparkle.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
    } else {
      const colors = [
        [255, 255, 0],
        [255, 0, 255],
      ];
      const color = colors[Math.floor(Math.random() * colors.length)];
      sparkle.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
    }

    sparkle.style.left = `${e.pageX}px`;
    sparkle.style.top = `${e.pageY}px`;

    sparkle.dataset.clickEffect = "true";

    sparkleContainer.appendChild(sparkle);

    // Randomize the falling animation
    const angle = Math.random() * 2 * Math.PI;
    const distance = Math.random() * 100 + 50; // Random distance
    const xOffset = Math.cos(angle) * distance;
    const yOffset = Math.sin(angle) * distance;

    let opacity = 1;
    let scale = 1;
    let x = e.pageX;
    let y = e.pageY;

    const fallInterval = setInterval(() => {
      opacity -= 0.05;
      scale -= 0.03;
      x += xOffset / 20; // Spread out the movement
      y += yOffset / 20;

      sparkle.style.opacity = opacity;
      sparkle.style.transform = `scale(${scale})`;
      sparkle.style.left = `${x}px`;
      sparkle.style.top = `${y}px`;

      if (opacity <= 0) {
        clearInterval(fallInterval);
        sparkle.remove();
      }
    }, 30);
  }

  playSound();
});

function playSound() {
  // Play a random sound from the array
  const randomSoundIndex = Math.floor(Math.random() * sounds.length);
  const sound = sounds[randomSoundIndex];

  sound.currentTime = 0; // Reset sound to start
  sound.volume = 0.50;
  sound.play();
}
