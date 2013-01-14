
 /*
 * # level.js
 *
 * Levelobjekt inklusive aller Levelfunktionalitäten
 */
var level = {
	grid: [],
	gridSize: 50,
	tileSize: 10,

	 /*
	 * ## initializeGrid
	 *
	 * Erzeugung des Spielfeldes
	 *
	 * @param {int} gridSize Größe des zu erzeugenden Spielfeldes
	 */
	initializeGrid: function(gridSize){
		this.gridSize = gridSize;

		for (var i = 0; i < this.gridSize; i++) {
		    this.grid[i] = [];
		    for (var j = 0; j < this.gridSize; j++){
		        this.grid[i][j] = {food: 0, player: false};
		    }
		}
		
		this.printGrid();
	},

	/*
	 * ## printGrid
	 *
	 * Zeichnung des Spielfeldes
	 */
	printGrid: function(){
		for (var x = 0; x < this.gridSize; x++){
	        for (var y = 0; y < this.gridSize; y++){
	            this.drawTile(x, y, 'white');
	        }
	    }
	},

	/*
	 * ## isInGrid
	 *
	 * Prüfung, ob Koordinaten noch innerhalb des Spielfeldes sind
	 *
	 * @param {int} x x-Koordinate der zu prüfenden Kachel
	 * @param {int} y y-Koordinate der zu prüfenden Kachel
	 */
	isInGrid: function(x, y){
		if (x < 0 || x >= this.gridSize || y < 0 || y >= this.gridSize){
	        return false;
	    } else{
	        return true;
	    }
	},

	/*
	 * ## drawTile
	 *
	 * Zeichnung einer Kachel
	 *
	 * @param {int} x x-Koordinate der Kachel
	 * @param {int} y y-Koordinate der Kachel
	 * @param {string} color Farbcode für die Kachel
	 */
	drawTile: function(x, y, color){
		ctx.fillStyle = color;
    	ctx.fillRect(x*this.tileSize, y*this.tileSize, this.tileSize, this.tileSize);
    
    	ctx.strokeStyle = "#F2F2F2";
    	ctx.strokeRect(x*this.tileSize, y*this.tileSize, this.tileSize, this.tileSize);
	},

	/*
	 * ## generateFood
	 *
	 * Zeichnung des Essens
	 * Eintragung in die Levelinformation
	 *
	 * @param {int} x x-Koordinate des zu erzeugenden Essens
	 * @param {int} y y-Koordinate des zu erzeugenden Essens
	 */
	generateFood: function(x, y){
	    this.grid[x][y] = {food: 5};
	    this.drawTile(x, y, 'black');
	}
}