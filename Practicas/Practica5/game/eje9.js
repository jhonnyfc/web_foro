/*source Grid*/
/*http://phaser.io/examples/v3/view/tilemap/grid-movement*/
/*http://phaser.io/examples/v3/view/tilemap/light-map*/

function buscaIO(mapa, io, pool){
	if (io == 0){ // entrada
		pool[0] = Math.trunc(Math.random()*mapa.rows)
		if (mapa.maze[pool[0]][pool[1]+1] == muro){
			return buscaIO(mapa, io, pool)
		} else {
			return pool
		}
	} else { // Salida
		pool[0] = Math.trunc(Math.random()*mapa.rows)
		if (mapa.maze[pool[0]][pool[1]-1] == muro){
			return buscaIO(mapa, io, pool)
		} else {
			return pool
		}
	}
}

/* 2 == muro */
/* 1 == pilar */
/* 0 == vacio */

var muro = (Math.random()*2|0) + 1
var suelo = 0

var sqSize = 32
var nrow = 15
var ncol = 15
var ini =  new Array(2).fill(0)
var fin = new Array(2).fill(0)
var tileSZ = new Array(2).fill(0)
var tilName = ['tiles1','tiles2']

var config = {
    type: Phaser.WEBGL,
	//type: Phaser.AUTO,
    width: 700,
    height: 650,
    parent: 'gameLay',
    pixelArt: true,
    backgroundColor: '#1a1a2d',
    //backgroundColor: '#C6EBF3',
	//backgroundColor: '#7CF9FB',
    scene: {
        preload: preload,
        create: create,
		update: update
    }
};

var game = new Phaser.Game(config);
var light;
var offsets = [];
var layer;
var player

function preload () {
    this.load.image(tilName[0], 'assets/muro1.png');
	this.load.image(tilName[1], 'assets/muro2.png');
    this.load.image('car', 'assets/car90.png');
}

function create () {
	var miMap = new MazeBuilder(ncol,nrow);

	ini[1] = 0
	fin[1] = miMap.cols - 1

	ini = buscaIO(miMap,0,ini)
	fin = buscaIO(miMap,1,fin)

	miMap.maze[ini[0]][ini[1]] = suelo
	miMap.maze[fin[0]][fin[1]] = suelo

	tileSZ[0] = Math.round(config.height/(nrow*2+1)*100)/100
	tileSZ[1] = Math.round(config.width/(ncol*2+1)*100)/100

	/*Creacion del mapa*/
    var map = this.make.tilemap({ key: 'map', data:miMap.maze, tileHeight: tileSZ[0], tileWidth:tileSZ[1]})
    var tileset = map.addTilesetImage(tilName[(Math.random()*2|0)], null, 32,32,1,2);
    layer = map.createLayer(0, tileset, 0, 0).setPipeline('Light2D');
	//layer = map.createLayer(0, tileset, 0, 0)

    player = this.add.image(ini[1] + tileSZ[1]/2, (tileSZ[0]*(ini[0])) + tileSZ[0]/2, 'car')
	player.setScale(tileSZ[1]/32, tileSZ[0]/32)

    //  Left
    this.input.keyboard.on('keydown-A', function (event) {

        var tile = layer.getTileAtWorldXY(player.x - tileSZ[1], player.y, true);

        if (tile.index === muro) {
            //  Blocked, we can't move
        } else {
            player.x -= tileSZ[1];
            player.angle = 180;
        }
    });

    //  Right
    this.input.keyboard.on('keydown-D', function (event) {

        var tile = layer.getTileAtWorldXY(player.x + tileSZ[1], player.y, true);

        if (tile.index === muro) {
            //  Blocked, we can't move
        } else {
            player.x += tileSZ[1];
            player.angle = 0;
        }
    });

    //  Up
    this.input.keyboard.on('keydown-W', function (event) {

        var tile = layer.getTileAtWorldXY(player.x, player.y - tileSZ[0], true);

        if (tile.index === muro) {
            //  Blocked, we can't move
        } else {
            player.y -= tileSZ[0];
            player.angle = -90;
        }
    });

    //  Down
    this.input.keyboard.on('keydown-S', function (event) {

        var tile = layer.getTileAtWorldXY(player.x, player.y + tileSZ[0], true);

        if (tile.index === muro) {
            //  Blocked, we can't move
        } else {
            player.y += tileSZ[0];
            player.angle = 90;
        }
    });

	light = this.lights.addLight(10, 10, 200).setScrollFactor(0.0);

    this.lights.enable().setAmbientColor(0x999999);

    // this.input.on('pointermove', function (pointer) {

    //     light.x = pointer.x;
    //     light.y = pointer.y;

    // });

    //this.lights.addLight(0, 100, 100).setColor(0xff0000).setIntensity(3.0);
    //this.lights.addLight(0, 200, 100).setColor(0x00ff00).setIntensity(3.0);
    //this.lights.addLight(0, 300, 100).setColor(0x0000ff).setIntensity(3.0);
    //this.lights.addLight(0, 400, 100).setColor(0xffff00).setIntensity(3.0);

    offsets = [ 0.1, 0.3, 0.5, 0.7 ];
}

function update () {
	light.x = player.x;
    light.y = player.y;
	
/*/
	var index = 0;

    this.lights.lights.forEach(function (currLight) {
        if (light !== currLight){
            currLight.x = 400 + Math.sin(offsets[index]) * 1000;
            offsets[index] += 0.02;
            index += 1;
        }
    });*/
}

/******************************************************************************************************* */


class MazeBuilder {
	/*https://www.the-art-of-web.com/javascript/maze-generator/*/
	constructor(width, height) {
		this.width = width;
		this.height = height;

		this.cols = 2 * this.width + 1;
		this.rows = 2 * this.height + 1;

		this.maze = this.initArray(0);

		// place initial walls
		this.maze.forEach((row, r) => {
			row.forEach((cell, c) => {
				switch(r) {
					case 0:
						case this.rows - 1:
						this.maze[r][c] = muro;
					break;
					default:
						if ((r % 2) == 1) {
							if ((c == 0) || (c == this.cols - 1)) {
								this.maze[r][c] = muro;
							}
						} else if (c % 2 == 0) {
							this.maze[r][c] = muro;
						}
				}
			});
		});
		// start partitioning
		this.partition(1, this.height - 1, 1, this.width - 1);
	}
  
    initArray(value) {
		return new Array(this.rows).fill().map(() => new Array(this.cols).fill(value));
    }
  
    rand(min, max) {
		return min + Math.floor(Math.random() * (1 + max - min));
    }
  
    posToSpace(x) {
		return 2 * (x-1) + 1;
    }
  
    posToWall(x) {
		return 2 * x;
    }
  
    shuffle(array) {
		/*sauce: https://stackoverflow.com/a/12646864*/
		for(let i = array.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[array[i], array[j]] = [array[j], array[i]];
		}
		return array;
    }
  
	// Cambio todo
    partition(r1, r2, c1, c2) {
		/*create partition walls*/
		/*ref: https://en.wikipedia.org/wiki/Maze_generation_algorithm#Recursive_division_method*/

		let horiz, vert, x, y, start, end;

		if((r2 < r1) || (c2 < c1)) {
			return false;
		}

		if(r1 == r2) {
			horiz = r1;
		} else {
			x = r1+1;
			y = r2-1;
			start = Math.round(x + (y-x) / 4);
			end = Math.round(x + 3*(y-x) / 4);
			horiz = this.rand(start, end);
		}

		if(c1 == c2) {
			vert = c1;
		} else {
			x = c1 + 1;
			y = c2 - 1;
			start = Math.round(x + (y - x) / 3);
			end = Math.round(x + 2 * (y - x) / 3);
			vert = this.rand(start, end);
		}

		for(let i = this.posToWall(r1)-1; i <= this.posToWall(r2)+1; i++) {
			for(let j = this.posToWall(c1)-1; j <= this.posToWall(c2)+1; j++) {
				if((i == this.posToWall(horiz)) || (j == this.posToWall(vert))) {
					this.maze[i][j] = muro;
				}
			}
		}

		let gaps = this.shuffle([true, true, true, false]);

		// create gaps in partition walls

		if(gaps[0]) {
			let gapPosition = this.rand(c1, vert);
			this.maze[this.posToWall(horiz)][this.posToSpace(gapPosition)] = suelo;
		}

		if(gaps[1]) {
			let gapPosition = this.rand(vert+1, c2+1);
			this.maze[this.posToWall(horiz)][this.posToSpace(gapPosition)] = suelo;
		}

		if(gaps[2]) {
			let gapPosition = this.rand(r1, horiz);
			this.maze[this.posToSpace(gapPosition)][this.posToWall(vert)] = suelo;
		}

		if(gaps[3]) {
			let gapPosition = this.rand(horiz+1, r2+1);
			this.maze[this.posToSpace(gapPosition)][this.posToWall(vert)] = suelo;
		}

		// recursively partition newly created chambers

		this.partition(r1, horiz-1, c1, vert-1);
		this.partition(horiz+1, r2, c1, vert-1);
		this.partition(r1, horiz-1, vert+1, c2);
		this.partition(horiz+1, r2, vert+1, c2);
    }
}

function nexLevel(level,nickName){
	$.ajax({
		url:"index.php",
		method:"POST",
		data: {accion:'juego', id:'2',name:nickName,nivel:level},
		success:function(data){
			list_image();
		}
	})
}