const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let fruits = [];
let score = 0;

// Load fruit images
const fruitImages = ['1.jpeg', '2.jpeg']; // Use high-quality fruit images
const loadedImages = fruitImages.map(src => {
    const img = new Image();
    img.src = src;
    return img;
});

function createFruit() {
    const x = Math.random() * canvas.width;
    const y = canvas.height + 20;
    const speed = Math.random() * 2 + 1;
    const img = loadedImages[Math.floor(Math.random() * loadedImages.length)];
    fruits.push({ x, y, speed, img });
}

function updateFruits() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    fruits.forEach((fruit, index) => {
        fruit.y -= fruit.speed;
        ctx.save();
        ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
        ctx.shadowBlur = 10;
        ctx.drawImage(fruit.img, fruit.x - 20, fruit.y - 20, 40, 40); // Draw the fruit image with shadow
        ctx.restore();
        if (fruit.y < -20) {
            fruits.splice(index, 1);
        }
    });
}

function gameLoop() {
    updateFruits();
    requestAnimationFrame(gameLoop);
}

canvas.addEventListener('mousemove', (event) => {
    const mouseX = event.clientX;
    const mouseY = event.clientY;
    fruits.forEach((fruit, index) => {
        const dx = fruit.x - mouseX;
        const dy = fruit.y - mouseY;
        const distance = Math.sqrt(dx * dx + dy * dy);
        if (distance < 20) {
            fruits.splice(index, 1);
            score++;
            console.log('Score:', score);
        }
    });
});

setInterval(createFruit, 1000);
gameLoop();