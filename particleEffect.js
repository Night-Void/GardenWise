const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particlesArray = [];

// Throttle particle creation rate (limits creation every X ms)
let lastMouseMoveTime = 0;
const particleCreationDelay = 100; // In milliseconds

// Mouse object to store coordinates
const mouse = {
  x: null,
  y: null,
};

canvas.addEventListener("mousemove", function (event) {
  const currentTime = Date.now();
  if (currentTime - lastMouseMoveTime > particleCreationDelay) {
    mouse.x = event.x;
    mouse.y = event.y;

    // Add leaf particles when the mouse moves
    for (let i = 0; i < 3; i++) {
      particlesArray.push(new LeafParticle());
    }

    lastMouseMoveTime = currentTime; // Update the last creation time
  }
});

// Define the leaf colors
const leafColors = [
  { hue: 90, saturation: '60%', lightness: '40%' },  // Green
  { hue: 30, saturation: '70%', lightness: '50%' },  // Orange
  { hue: 60, saturation: '70%', lightness: '50%' },  // Yellow
  { hue: 0, saturation: '60%', lightness: '50%' },   // Red
  { hue: 40, saturation: '60%', lightness: '40%' },  // Brown
];

// Leaf particle class
class LeafParticle {
  constructor() {
    this.x = mouse.x;
    this.y = mouse.y;
    this.size = Math.random() * 20 + 20; // Leaf size (larger for more realism)
    this.speedX = Math.random() * 0.75 - 0.375; // Reduced horizontal movement
    this.speedY = Math.random() * 0.5 + 0.2; // Reduced falling speed
    this.angle = Math.random() * 360; // Random initial angle
    this.spinSpeed = Math.random() * 0.02 - 0.01; // Slightly slower spin
    this.opacity = 1; // Full opacity at the start

    // Randomly pick a color from the leafColors array
    const colorChoice = leafColors[Math.floor(Math.random() * leafColors.length)];
    this.color = `hsl(${colorChoice.hue}, ${colorChoice.saturation}, ${colorChoice.lightness})`;
  }

  update() {
    this.x += this.speedX;
    this.y += this.speedY;
    this.angle += this.spinSpeed; // Apply slow spin
    this.size *= 0.998; // Slower shrinking (more gradual)
    this.opacity -= 0.0025; // Slower fading (more gradual)
  }

  draw() {
    ctx.save();
    ctx.translate(this.x, this.y);
    ctx.rotate(this.angle); // Rotate the leaf

    // Draw the leaf shape using quadratic curves
    ctx.fillStyle = `hsla(${this.color.match(/\d+/g)[0]}, 60%, 40%, ${this.opacity})`;
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.quadraticCurveTo(-this.size / 2, -this.size / 2, 0, -this.size); // Left half of the leaf
    ctx.quadraticCurveTo(this.size / 2, -this.size / 2, 0, 0); // Right half
    ctx.closePath();
    ctx.fill();

    // Optionally add a central vein for more realism
    ctx.strokeStyle = `rgba(255, 255, 255, ${this.opacity * 0.6})`; // Subtle white vein
    ctx.lineWidth = 1;
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(0, -this.size);
    ctx.stroke();

    ctx.restore();
  }
}

// Animate particles
function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Filter out small/invisible particles (improved performance)
  particlesArray = particlesArray.filter(particle => particle.size > 1 && particle.opacity > 0);
  
  for (let particle of particlesArray) {
    particle.update();
    particle.draw();
  }

  requestAnimationFrame(animate);
}

// Resize canvas when the window size changes
window.addEventListener("resize", function () {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  // Optional: Clear particles on resize for consistency
  particlesArray = [];
});

// Start animation
animate();
