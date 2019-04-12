const canvas = document.getElementById('tetris'); //access the canvas:
const context = canvas.getContext('2d');

context.scale(20, 20); // kaladeles dydis

function arenaSweep() {
    let rowCount = 1;
    outer: for (let y = arena.length -1; y > 0; --y) { // nuo apacios i virsu
        for (let x = 0; x < arena[y].length; ++x) {
            if (arena[y][x] === 0) { // jeigu eile/eiles nera pilnai uzpildoma
                continue outer; // ciklai for vykdosi is naujo
            }
        }
        
        const row = arena.splice(y, 1)[0].fill(0); // istriname uzsipildziusia eilute/eilutes is arenos. indexas yra y, 1-splice ilgis
        arena.unshift(row); // tuscia eilute padeda 
        ++y; // kad istrintu visas eilutes, kurios uzpildytos (ne tik viena)

        player.score += rowCount * 10;
        rowCount *= 2;
    }
}

function collide(arena, player) {
    const [m, o] = [player.matrix, player.pos];
    for (let y =0; y < m.length; ++y) {
        for (let x = 0; x < m[y].length; ++x) {
            if (m[y][x] !== 0 && 
                (arena[y + o.y] && // jei turi row
                arena[y + o.y][x + o.x]) !==0) { // jei turi column
                    return true;
                }
        }
    }
    return false;
}


function createMatrix(w, h) {
    const matrix = [];
    while (h--) { //loop . kol h nelygu 0, mes deklaruojame vienetu ir  sukuriamas naujas masyvas
        matrix.push(new Array(w).fill(0)); //su ilgiu w ir uzpildytu nuliais.
    }
    return matrix;
}

function createPiece(type) { // sukuriame daugiau kaladeliu. skaiciais nustatysime spalvas
    if (type === 'T') {
        return [
            [0, 0, 0],
            [1, 1, 1],
            [0, 1, 0],
        ];
    } else if (type === 'O') {
        return [
            [2, 2],
            [2, 2],
        ];
    } else if (type === 'L') {
        return [
            [0, 3, 0],
            [0, 3, 0],
            [0, 3, 3],
        ];
    } else if (type === 'J') {
        return [
            [0, 4, 0],
            [0, 4, 0],
            [4, 4, 0],
        ];
    } else if (type === 'I') {
        return [
            [0, 5, 0, 0],
            [0, 5, 0, 0],
            [0, 5, 0, 0],
            [0, 5, 0, 0],
        ];
    } else if (type === 'S') {
        return [
            [0, 6, 6],
            [6, 6, 0],
            [0, 0, 0],
        ];
    } else if (type === 'Z') {
        return [
            [7, 7, 0],
            [0, 7, 7],
            [0, 0, 0],
        ];
    } 
}



function draw() { // draw metode deklaruojame canvas - tam, jog kaladele judetu, ir neliktu senoje vietoje kaip dublis!!!
    context.fillStyle = '#000';
    context.fillRect(0, 0, canvas.width, canvas.height); // koordinates ir p/h
    
    drawMatrix(arena, {x: 0, y: 0}); // NUKRITUSI KALADELE NEISNYKSTA!!! ant jos krenta kitos
    drawMatrix(player.matrix, player.pos);
}

function drawMatrix(matrix, offset) { // offset leis judeti
    matrix.forEach((row, y) => { // sukuriami row ir y indeksai
        row.forEach((value, x) => { // 0 reiksmes bus niekas/permatomos
            if (value !== 0) { // patikriname, ar reiksme nera 0
                context.fillStyle = colors[value];
                context.fillRect(x + offset.x,
                    y + offset.y,
                    1, 1); // x-kairei, y-virsui, 
            }
        });
    });
}

function merge(arena, player) { // nukopijuoja playerio reiksmes i arena teisingoje pozicijoje
    player.matrix.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value !== 0) {
                arena[y + player.pos.y][x + player.pos.x] = value; // jei nera nulis, norime nukopijuoti offset value i teisinga pozicija
            }
        });
    });
}

function playerDrop() {
    player.pos.y++;
    if (collide(arena, player)) { // jei palieciame apacia, kaladele vel krenta nuo virsaus
        player.pos.y--;
        merge(arena, player);
        playerReset();
        arenaSweep();
        updateScore();
    }
    
        dropCounter = 0; // pradeda skaiciuoti nuo pradziu
}

function playerMove(dir) { // funkcija, kuri neleidzia iseiti uz ribu ir ant virsaus susidurti su kita kaladele
    player.pos.x += dir;
    if (collide(arena, player)) { 
        player.pos.x -= dir;
    }
}

function playerReset() {// funkcija, kad kaladeles ismestu random budu
    const pieces = 'ILJOTSZ';
    player.matrix = createPiece(pieces[pieces.length * Math.random() | 0]);
    player.pos.y = 0 // put at the top
    player.pos.x = (arena[0].length / 2 | 0) - // kad kaladele ismestu per centra. 0 = first row. 
                    (player.matrix[0].length / 2 | 0);
    if (collide(arena, player)) { // jeigu kaladeles pasiekia virsu
        arena.forEach(row => row.fill(0)) // isvalomas visas arenos langas
        player.score = 0;
        updateScore();
    }
}

function playerRotate(dir) {
    const pos = player.pos.x;
    let offset = 1; // tam, kad pozicija uz ribu nesikeistu
    rotate(player.matrix, dir);
    while (collide(arena, player)) {
        player.pos.x += offset; // reikia judeti pagal offset. i desine
        offset = -(offset + (offset > 0 ? 1 : -1));  // (i kaire). 
        if (offset > player.matrix[0].length) {
            rotate (player.matrix, -dir); // pasislenka per 1 nuo sieneles, kai darome rotate prie sieneles
            player.pos.x = pos;
            return;
        }
    }
}

function rotate(matrix, dir) {
    for (let y = 0; y < matrix.length; ++y) {
        for (let x = 0; x < y; ++x) { // inner loop
            [
                matrix[x][y],
                matrix[y][x],
            ] = [
                matrix[y][x],
                matrix[x][y],
            ];
        }
    }
    if (dir > 0) {
        matrix.forEach(row => row.reverse());
    } else {
        matrix.reverse();
    }
}


let dropCounter = 0;
let dropInterval = 1000; // milisekundes , per kiek laiko 1 kal. nusileis zemyn 1 karta 

let lastTime = 0; //turime uzsaugoti paskutini laika, kuri mateme
function update(time = 0) { //animation frame nustatome drop laika
    const deltaTime = time - lastTime; //tam, kad sumazetu laiko vienetai
    lastTime = time;
    
    dropCounter += deltaTime;
    if (dropCounter > dropInterval){
        playerDrop();
    }
    
    draw();
    requestAnimationFrame(update); // su siup 
}

function updateScore() {
    document.getElementById('score').innerText = player.score;
}

const colors = [
    null,
    'red',
    'blue',
    'violet',
    'green',
    'purple',
    'orange',
    'pink',
];

const arena = createMatrix(12, 20); // plotis, aukstis 


const player = { // pridedame playerio struktura
    pos: { x: 0, y: 0 }, // pozicija, kurios reiksmes offset
    matrix: null,
    score: 0,
}

// pridedame klaviaturos judejima:
document.addEventListener('keydown', event => {
    if (event.keyCode === 37) { // paleidus console.log ir paspaudus kaire rodyklyte, matome uzkoduota keycode
        playerMove(-1); // kad kaladele nesustotu kraste
    } else if (event.keyCode === 39){ // i desine
        playerMove(1);
    } else if (event.keyCode === 40) {
        // player.pos.y++; REIKIA KONSOLIDUOTI:
        // dropCounter = 0; // nes nenorime, jog paspaudus i apacia pridetu papildoma laika
        playerDrop(); // ja implementuojame auksciau virsuje
    } else if (event.keyCode === 38) {
        playerRotate(-1)
    }
});

// pridedame mygtukus:

function moveup() {
    playerRotate(-1) 
  }
  
  function movedown() {
    playerDrop()
  }
  
  function moveleft() {
    playerMove(-1)
  }
  
  function moveright() {
    playerMove(1)
  }


playerReset();
updateScore();
update();

