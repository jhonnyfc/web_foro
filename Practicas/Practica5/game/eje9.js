var sqSize = 32

var config = {
    type: Phaser.AUTO,
    width: 850,
    height: 655,
    parent: 'gameLay',
    pixelArt: true,
    backgroundColor: '#1a1a2d',
    //backgroundColor: '#C6EBF3',
    scene: {
        preload: preload,
        create: create
    }
};

var game = new Phaser.Game(config);

function preload () {
    this.load.image('tiles', 'assets/drawtiles-spaced.png');
    this.load.image('car', 'assets/car90.png');

    //this.load.tilemapCSV('map', 'assets/grid.csv');
}

function create () {

    var level = new Array(18).fill(0).map(() => new Array(24).fill(0));

    for (var i = 0; i < 18; ++i) {
        for (var j = 0; j < 24; ++j) {
            // 2 == muro
            // 1 == pilar
            // 0 vacio
            level[i][j] = Math.trunc(Math.random()*3)
        }
    }

    console.log(level);

    //  Add data to the cache
    //game.cache.addTilemap('map', null, data, Phaser.Tilemap.CSV);

    //  Create our map (the 16x16 is the tile size)
    //map = game.add.tilemap('map', sqSize, sqSize);


   var map = this.make.tilemap({ key: 'map', data:level, tileWidth: sqSize, tileHeight: sqSize});
    var tileset = map.addTilesetImage('tiles', null, 32,32,1,2);
    var layer = map.createLayer(0, tileset, 0, 0);

    /*
    var player = this.add.image(sqSize+16, sqSize+16, 'car');

    //  Left
    this.input.keyboard.on('keydown-A', function (event) {

        var tile = layer.getTileAtWorldXY(player.x - sqSize, player.y, true);

        if (tile.index === 2) {
            //  Blocked, we can't move
        } else {
            player.x -= sqSize;
            player.angle = 180;
        }
    });

    //  Right
    this.input.keyboard.on('keydown-D', function (event) {

        var tile = layer.getTileAtWorldXY(player.x + sqSize, player.y, true);

        if (tile.index === 2) {
            //  Blocked, we can't move
        } else {
            player.x += sqSize;
            player.angle = 0;
        }
    });

    //  Up
    this.input.keyboard.on('keydown-W', function (event) {

        var tile = layer.getTileAtWorldXY(player.x, player.y - sqSize, true);

        if (tile.index === 2) {
            //  Blocked, we can't move
        } else {
            player.y -= sqSize;
            player.angle = -90;
        }
    });

    //  Down
    this.input.keyboard.on('keydown-S', function (event) {

        var tile = layer.getTileAtWorldXY(player.x, player.y + sqSize, true);

        if (tile.index === 2) {
            //  Blocked, we can't move
        } else {
            player.y += sqSize;
            player.angle = 90;
        }
    });*/
}
